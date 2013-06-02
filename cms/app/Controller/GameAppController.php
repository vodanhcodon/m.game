<?php

App::uses('AppController', 'Controller');

class GameAppController extends AppController {

    public $uses = array('GameApp', 'TheLoai', 'DanhMuc', 'Company', 'Distributor', 'TheLoaiRelation');

    public function index() {
        $this->setInit();
        $this->GameApp->recursive = -1;

        $orders = $this->GameApp->find('list', array('fields' => array('order', 'order'), 'group' => array('GameApp.order')));
        $this->set('orders', $orders);

        $this->parseUrlParams(array(
            'likea' => array('name'),
            'modelname' => 'GameApp',
            'associated' => 'TheLoaiRelation',
            'subcategories' => 'danh_muc_id', // có thực hiện liên kết với các subcategories của nó
        ));

        $this->paginate['GameApp']['order'] = 'GameApp.order ASC';
        $this->paginate['GameApp']['recursive'] = -1;
        $this->paginate['GameApp']['limit'] = 20;
        $games = $this->paginate('GameApp');
        $this->set('games', $games);

        /**
         * Lấy ra các options của thể loại tương ứng được set với 1 GameApp
         */
        $ids = Hash::extract($games, '{n}.GameApp.id');
        $opts_theloai = $this->getOptsFromTheLoaiRelation($ids);
        $this->set('opts_theloai', $opts_theloai);

        // đếm số tổng số game theo trạng thái status
        $public = $this->GameApp->find('count', array(
            'fields' => 'id',
            'conditions' => array('status' => 2),
        ));
        $waiting = $this->GameApp->find('count', array(
            'fields' => 'id',
            'conditions' => array('status' => 1),
        ));

        // lấy ra danh sách game đang là public
        $gamePublics = $this->GameApp->find('all', array(
            'fields' => array('id'),
            'conditions' => array('status' => 2),
        ));
        $gamePublics = Hash::extract($gamePublics, '{n}.GameApp.id');
        $this->set('gamePublic', $gamePublics);

        $user = $this->Auth->user();
        $userType = $user['type'];
        $this->set('userType', $userType);

        $this->set('public', $public);
        $this->set('waiting', $waiting);
    }

    /*
     * phương thức dùng để biến đổi phương thức POST sang kiểu URL của  paginate
     */

    public function search() {
//        if (@strlen($this->request->data['GameApp']['submitflag'])) {
//            $this->Session->write('submitflag', $this->request->data['GameApp']['submitflag']);
//            if ($this->request->data['GameApp']['submitflag'] == 'search') {
//                
//            } else {
//                
//            }
//        }
        parent::search();
    }

    /**
     * updateList action
     * Phương thức thực hiện update hàng loạt từ trang danh sách index
     * @throws MethodNotAllowedException
     */
    public function updateList() {
        $modelName = $this->name;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('Bạn không có quyền thực hiện thao tác này');
        }
        $target = $this->request->data['UpdateList'];
        if ($this->$modelName->saveAll($target)) {
            $this->Session->setFlash('GameApp đã được cập nhât thành công');
        } else {
            $this->Session->setFlash('Lỗi, GameApp chưa được cập nhật thành công, hãy thử lại!');
        }
        $this->redirect(array('action' => 'index'));
    }

    public function add() {
        $this->setInit();

        $folder = Configure::read('gom.GameApp.folder');
        $tmp = $folder['tmp'];
        $path = $folder['dir'];

        $type = Configure::read('gom.platform');

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->GameApp->set($this->request->data);
            if ($this->GameApp->validates()) {

                // tạo thư mục mới dựa vào input có tên là name
                $dirpath = $this->getDirPath('name');
                $validate = 1;

                $platform = $this->request->data['GameApp']['platform'];

                // chuyển tiếp file ảnh logo từ tmp sang thư mục vừa tạo ở trên
                if (!empty($this->request->data['GameApp']['logo'])) {
                    $logo = $this->request->data['GameApp']['logo'];
                    $tmp_file = $tmp . $logo;
                    $target_file = $dirpath . $logo;
                    $this->request->data['GameApp']['logo'] = $target_file;
                    $this->copyFile($tmp_file, $target_file);
                } else {
                    $validate = 0;
                }

                // chuyển tiếp các file cài đặt từ tmp sang thư mục vừa tạo ở trên
                if (!empty($this->request->data['GameApp']['file_setup']) && $validate && in_array($type[$platform], array('j2me non touch', 'j2me full touch', 'android'))) {
                    $file_setups = $this->request->data['GameApp']['file_setup'];
                    foreach ($file_setups as $file_setup) {
                        // nhận biết định dạng file tải lên và thực hiện điền chúng vào đúng trường
                        // field trong database
                        $file_ext = strtolower(substr(strrchr($file_setup, '.'), 1));
                        switch ($file_ext):
                            case 'jar':
                                $this->request->data['GameApp']['j2me_jar_file_path'] = $dirpath . $file_setup;
                                break;
                            case 'jad':
                                $this->request->data['GameApp']['j2me_jad_file_path'] = $dirpath . $file_setup;
                                break;
                            case 'apk':
                                $this->request->data['GameApp']['android_apk_file_path'] = $dirpath . $file_setup;
                                break;
                        endswitch;

                        // thực hiện set các trường fields không được xuất hiện trong views thành rỗng
                        // các trường fields này được thực thi xử lý giám tiếp thông qua controller
                        // trong view nó có 1 trường fields đại diện có tên names khác
                        if (empty($this->request->data['GameApp']['j2me_jar_file_path'])) {
                            $this->request->data['GameApp']['j2me_jar_file_path'] = '';
                        }
                        if (empty($this->request->data['GameApp']['j2me_jad_file_path'])) {
                            $this->request->data['GameApp']['j2me_jad_file_path'] = '';
                        }
                        if (empty($this->request->data['GameApp']['android_apk_file_path'])) {
                            $this->request->data['GameApp']['android_apk_file_path'] = '';
                        }

                        $tmp_file = $tmp . $file_setup;
                        $target_file = $dirpath . $file_setup;
                        $this->copyFile($tmp_file, $target_file);
                    }
                    // chuyển tiếp các file liên quan tới ảnh từ tmp sang thư mục vừa tạo ở trên
                    if (!empty($this->request->data['GameApp']['image_path'])) {
                        foreach ($this->request->data['GameApp']['image_path'] as $key => $image_path) {
                            $this->request->data['GameApp']['image_path_' . ($key + 1)] = $dirpath . $image_path;

                            $tmp_file = $tmp . $image_path;
                            $target_file = $dirpath . $image_path;
                            $this->copyFile($tmp_file, $target_file);
                        }

                        // thực hiện set các trường fields không được xuất hiện trong views thành rỗng
                        // các trường fields này được thực thi xử lý giám tiếp thông qua controller
                        // trong view nó có 1 trường fields đại diện có tên names khác
                        if (empty($this->request->data['GameApp']['image_path_1'])) {
                            $this->request->data['GameApp']['image_path_1'] = '';
                        }
                        if (empty($this->request->data['GameApp']['image_path_2'])) {
                            $this->request->data['GameApp']['image_path_2'] = '';
                        }
                        if (empty($this->request->data['GameApp']['image_path_3'])) {
                            $this->request->data['GameApp']['image_path_3'] = '';
                        }
                    }

                    $this->deleteAllFile($tmp);
                    if ($this->GameApp->save($this->request->data)) {
                        $this->Session->setFlash(__('GameApp đã được thêm mới thành công!'));
                        $redirect = $this->request->data['referer'];
                        $this->redirect($redirect);
                    }
//                        debug($this->GameApp->validationErrors);
                    $this->Session->setFlash(__('Lỗi, GameApp chưa được thêm mới hãy thử lại lần nữa!'));
                } else {
                    if ($validate && in_array($type[$platform], array('winphone', 'iphone'))) {
//                        $this->deleteAllFile($tmp);
                        if ($this->GameApp->save($this->request->data)) {
                            $this->Session->setFlash(__('GameApp đã được thêm mới thành công!'));
                            $redirect = $this->request->data['referer'];
                            $this->redirect($redirect);
                        } else {
//                        debug($this->GameApp->validationErrors);
                            $this->Session->setFlash(__('Lỗi, GameApp chưa được thêm mới hãy thử lại lần nữa!'));
                        }
                    }
//                    debug($this->GameApp->validationErrors);
                    $this->Session->setFlash(__('Lỗi, GameApp chưa được thêm mới hãy thử lại lần nữa!'));
                }
            } else {
//                $this->deleteAllFile($tmp);
//                debug($this->GameApp->validationErrors);
                $this->Session->setFlash(__('Lỗi, GameApp chưa được thêm mới hãy thử lại lần nữa!'));
            }
        }
    }

    public function edit($id = null) {
        $this->GameApp->id = $id;
        $this->set('id', $id);

        $opts_theloai = $this->getOptsFromTheLoaiRelation(array($id));
        $this->set('opts_theloai', $opts_theloai);

        if (!$this->GameApp->exists()) {
            throw new NotFoundException(__('GameApp không hợp lệ'));
        }

        $datas = $this->GameApp->read(null, $id);
        // thực hiện chuyển tiếp các dữ liệu đã có trong database ra ngoài view
        // thông qua các input ẩn
        /**
         * BEGIN
         */
        $image_path = array();
        if (!empty($datas['GameApp']['image_path_1'])) {
            $image_path[] = $datas['GameApp']['image_path_1'];
        }
        if (!empty($datas['GameApp']['image_path_2'])) {
            $image_path[] = $datas['GameApp']['image_path_2'];
        }
        if (!empty($datas['GameApp']['image_path_3'])) {
            $image_path[] = $datas['GameApp']['image_path_3'];
        }

        $file_setup = array();
        if (!empty($datas['GameApp']['j2me_jar_file_path'])) {
            $file_setup[] = $datas['GameApp']['j2me_jar_file_path'];
        }
        if (!empty($datas['GameApp']['j2me_jad_file_path'])) {
            $file_setup[] = $datas['GameApp']['j2me_jad_file_path'];
        }
        if (!empty($datas['GameApp']['android_apk_file_path'])) {
            $file_setup[] = $datas['GameApp']['android_apk_file_path'];
        }

        $this->set(compact('image_path', 'file_setup'));
        /**
         * END
         */
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->add();
        } else {
            $this->setInit();
            $this->request->data = $this->GameApp->read(null, $id);
        }
        $this->render('add');
    }

    public function delete($id = null) {
        parent::delete($id);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        /**
         * 
          $user = $this->Auth->user();
          if ($user['type'] != 1) {
          $this->paginate['GameApp']['conditions']['GameApp.cms_user_id'] = (int) $user['id'];
          }
         * 
         */
    }

    protected function setInit() {
        $types = Configure::read('gom.DanhMuc.type');
        $game_type = array_search('GAME', $types);
        $app_type = array_search('APP', $types);

        $trees_game = $this->getTreeDanhMuc($game_type);
        $danhmuc_game = $this->buildOptsDanhMuc($trees_game);

        $trees_app = $this->getTreeDanhMuc($app_type);
        $danhmuc_app = $this->buildOptsDanhMuc($trees_app);

        $trees = $this->getTreeDanhMuc(array($game_type, $app_type));
        $danhmuc = $this->buildOptsDanhMuc($trees);

        $theloai = $this->getTheLoai();

        // thực hiện lọc phân quyền theo user type != 1 (tức là user thông thường)
        /**
         * user thông thường khi truy nhập vào site, không được chọn lựa vào danh sách tất cả các company
         * Chỉ có 1 company mà user đó thuộc vào, được xuất hiện
         * BEGIN
         */
        $joins2CmsUser = array(
            array(
                'table' => 'cms_user',
                'alias' => 'CmsUser',
                'type' => 'INNER',
                'conditions' => array(
                    'CmsUser.company_id = Company.id',
                ),
            )
        );

        //lấy user type và company_id từ user đang truy cập
        $userType = $this->Auth->user('type');
        $company_id = $this->Auth->user('company_id');
        
        // nếu user không phải là admin, thực hiện lọc lấy company duy nhất tương ứng với user đó
        if ($userType != 1) {
            $com_opts['joins'] = $joins2CmsUser;
            $com_opts['conditions']['CmsUser.company_id'] = $company_id;
        }
        
        $com_opts['fields'] = array('Company.id', 'Company.name');
        $com_opts['recursive'] = -1;
        $company = $this->Company->find('list',$com_opts);
        
        /**
         * END
         */

        $partner = $this->Distributor->find('list', array(
            'fields' => array('Distributor.id', 'Distributor.name'),
            'recursive' => -1,
        ));

        $this->set('danhmuc', $danhmuc);
        $this->set('danhmuc_game', $danhmuc_game);
        $this->set('danhmuc_app', $danhmuc_app);
        $this->set('theloai', $theloai);
        $this->set('company', $company);
        $this->set('partner', $partner);
    }

}