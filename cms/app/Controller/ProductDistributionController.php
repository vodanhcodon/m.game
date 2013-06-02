<?php

App::uses('AppController', 'Controller');

class ProductDistributionController extends AppController {

    public $uses = array('ProductDistribution', 'TheLoai', 'DanhMuc', 'Company', 'Distributor', 'TheLoaiRelation', 'ProductDanhMuc');
    public $distributor_id = 0;

    public function index() {
        $this->setInit();
        $user = $this->Auth->user();
        $userType = $user['type'];
        $this->set('userType', $userType);

        $this->parseUrlParams(array(
            'likea' => array('name'),
            'modelname' => 'ProductDistribution',
            'associated' => 'ProductDanhMuc',
            'subcategories' => 'danh_muc_id', // có thực hiện liên kết với các subcategories của nó
        ));
        $this->paginate['ProductDistribution']['order'] = 'ProductDistribution.order ASC';
        $this->paginate['ProductDistribution']['recursive'] = -1;
        $this->paginate['ProductDistribution']['limit'] = 20;
        $apps = $this->paginate('ProductDistribution');
        $this->set('apps', $apps);

        /**
         * xóa bỏ thể loại
         */
        //        $opts_theloai = $this->getOptsFromTheLoaiRelation($ids);
        //        $this->set('opts_theloai', $opts_theloai);

        /**
         * Lấy ra các options của danh mục tương ứng được set với 1 ProductDistribution
         */
        $ids = Hash::extract($apps, '{n}.ProductDistribution.id');
        $opts_danhmuc = $this->getOptsFromProductDanhMuc($ids);
        $this->set('opts_danhmuc', $opts_danhmuc);

        // đếm số tổng số ProductDistribution theo trạng thái status
        $public = $this->ProductDistribution->find('count', array(
            'fields' => 'id',
            'conditions' => array('status' => 2),
        ));
        $waiting = $this->ProductDistribution->find('count', array(
            'fields' => 'id',
            'conditions' => array('status' => 1),
        ));

        // lấy ra danh sách ProductDistribution đang là public
        $appPublics = $this->ProductDistribution->find('all', array(
            'fields' => array('id'),
            'conditions' => array('status' => 2),
        ));
        $appPublics = Hash::extract($appPublics, '{n}.ProductDistribution.id');
        $this->set('gamePublic', $appPublics);
        $this->set('public', $public);
        $this->set('waiting', $waiting);
    }

    /**
     * updateList action
     * Phương thức thực hiện update hàng loạt từ trang danh sách index
     * @throws MethodNotAllowedException
     */
    public function updateList() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('Bạn không có quyền thực hiện thao tác này');
        }
        $target = $this->request->data['UpdateList'];
        if ($this->ProductDistribution->saveAll($target)) {
            $this->Session->setFlash('Product Distribution đã được cập nhât thành công');
        } else {
            $this->Session->setFlash('Lỗi, Product Distribution chưa được cập nhật thành công, hãy thử lại!');
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * phương thức dùng để biến đổi phương thức POST sang kiểu URL của  paginate
     */
    public function search() {
        parent::search();
    }

    public function add() {
        $this->setInit();

        $folder = Configure::read('gom.ProductDistribution.folder');
        $tmp = $folder['tmp'];
        $path = $folder['dir'];

        $type = Configure::read('gom.platform');

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->ProductDistribution->set($this->request->data);
            if ($this->ProductDistribution->validates()) {

                // xác định tên thư mục sẽ được tạo ra dựa vào tên ProductDistribution
                $dirname = $this->request->data['ProductDistribution']['name'];

                // chuyển từ tiếng việt có dấu sang tiếng việt không dấu
                $dirname = $this->convert_vi_to_en($dirname);

                // nếu thư mục không tồn tại sẵn thì tạo 1 thư mục mới
                if (!file_exists($path . $dirname) || !is_dir($path . $dirname)) {
                    mkdir($path . $dirname); // tạo 1 thư mục mới
                }
                $dirpath = $path . $dirname . '/';

                // tạo thư mục con res. nếu thư mục res không tồn tại sẵn thì tạo 1 thư mục mới
                $childpath = 'res';
                if (!file_exists($path . $dirname . '/' . $childpath) || !is_dir($path . $dirname . '/' . $childpath)) {
                    mkdir($path . $dirname . '/' . $childpath); // tạo 1 thư mục mới
                }
                $childpath = $path . $dirname . '/' . $childpath . '/';

                $validate = 1;

                $platform = $this->request->data['ProductDistribution']['platform'];

                // chuyển tiếp file ảnh logo từ tmp sang thư mục childpath vừa tạo ở trên
                if (!empty($this->request->data['ProductDistribution']['logo'])) {
                    $logo = $this->request->data['ProductDistribution']['logo'];
                    $tmp_file = $tmp . $logo;
                    $target_file = $childpath . $logo;
                    $this->request->data['ProductDistribution']['logo'] = $target_file;
                    $this->copyFile($tmp_file, $target_file);
                } else {
                    $validate = 0;
                }

                // chuyển tiếp file ảnh screen loading từ tmp sang thư mục childpath vừa tạo ở trên
                if (!empty($this->request->data['ProductDistribution']['load_screen_image'])) {
                    $load_screen = $this->request->data['ProductDistribution']['load_screen_image'];
                    $tmp_file = $tmp . $load_screen;
                    $target_file = $childpath . $load_screen;
                    $this->request->data['ProductDistribution']['load_screen_image'] = $target_file;
                    $this->copyFile($tmp_file, $target_file);
                }

                // chuyển tiếp các file cài đặt từ tmp sang thư mục vừa tạo ở trên
                if (!empty($this->request->data['ProductDistribution']['file_setup']) && $validate && in_array($type[$platform], array('j2me non touch', 'j2me full touch', 'android', 'winphone'))) {
                    $file_setups = $this->request->data['ProductDistribution']['file_setup'];
                    foreach ($file_setups as $file_setup) {
                        // nhận biết định dạng file tải lên và thực hiện điền chúng vào đúng trường
                        // field trong database
                        $file_ext = strtolower(substr(strrchr($file_setup, '.'), 1));
                        switch ($file_ext):
                            case 'jar':
                                $this->request->data['ProductDistribution']['jar_file'] = $dirpath . $file_setup;
                                break;
                            case 'jad':
                                $this->request->data['ProductDistribution']['jad_file'] = $dirpath . $file_setup;
                                break;
                            case 'apk':
                                $this->request->data['ProductDistribution']['apk_file'] = $dirpath . $file_setup;
                                break;
                            case 'xap':
                                $this->request->data['ProductDistribution']['xap_file'] = $dirpath . $file_setup;
                                break;
                        endswitch;

                        // thực hiện set các trường fields không được xuất hiện trong views thành rỗng
                        // các trường fields này được thực thi xử lý giám tiếp thông qua controller
                        // trong view nó có 1 trường fields đại diện có tên names khác
                        if (empty($this->request->data['ProductDistribution']['jar_file'])) {
                            $this->request->data['ProductDistribution']['jar_file'] = '';
                        }
                        if (empty($this->request->data['ProductDistribution']['jad_file'])) {
                            $this->request->data['ProductDistribution']['jad_file'] = '';
                        }
                        if (empty($this->request->data['ProductDistribution']['apk_file'])) {
                            $this->request->data['ProductDistribution']['apk_file'] = '';
                        }
                        if (empty($this->request->data['ProductDistribution']['xap_file'])) {
                            $this->request->data['ProductDistribution']['xap_file'] = '';
                        }

                        $tmp_file = $tmp . $file_setup;
                        $target_file = $dirpath . $file_setup;
                        $this->copyFile($tmp_file, $target_file);
                    }
                    // chuyển tiếp các file liên quan tới ảnh từ tmp sang thư mục childpath vừa tạo ở trên
                    if (!empty($this->request->data['ProductDistribution']['image_path'])) {
                        foreach ($this->request->data['ProductDistribution']['image_path'] as $key => $image_path) {
                            $this->request->data['ProductDistribution']['image_path_' . ($key + 1)] = $childpath . $image_path;

                            $tmp_file = $tmp . $image_path;
                            $target_file = $childpath . $image_path;
                            $this->copyFile($tmp_file, $target_file);
                        }

                        // thực hiện set các trường fields không được xuất hiện trong views thành rỗng
                        // các trường fields này được thực thi xử lý giám tiếp thông qua controller
                        // trong view nó có 1 trường fields đại diện có tên names khác
                        if (empty($this->request->data['ProductDistribution']['image_path_1'])) {
                            $this->request->data['ProductDistribution']['image_path_1'] = '';
                        }
                        if (empty($this->request->data['ProductDistribution']['image_path_2'])) {
                            $this->request->data['ProductDistribution']['image_path_2'] = '';
                        }
                        if (empty($this->request->data['ProductDistribution']['image_path_3'])) {
                            $this->request->data['ProductDistribution']['image_path_3'] = '';
                        }
                    }

                    $this->deleteAllFile($tmp);
                    if ($this->ProductDistribution->save($this->request->data)) {
                        $this->Session->setFlash(__('ProductDistribution đã được thêm mới thành công!'));
                        $redirect = $this->request->data['referer'];
                        $this->redirect($redirect);
                    }
//                        debug($this->GameApp->validationErrors);
                    $this->Session->setFlash(__('Lỗi, ProductDistribution chưa được thêm mới hãy thử lại lần nữa!'));
                } else {
                    if ($validate && in_array($type[$platform], array('iphone'))) {
                        $this->deleteAllFile($tmp);
                        if ($this->ProductDistribution->save($this->request->data)) {
                            $this->Session->setFlash(__('ProductDistribution đã được thêm mới thành công!'));
                            $redirect = $this->request->data['referer'];
                            $this->redirect($redirect);
                        } else {
//                        debug($this->GameApp->validationErrors);
                            $this->Session->setFlash(__('Lỗi, ProductDistribution chưa được thêm mới hãy thử lại lần nữa!'));
                        }
                    }
//                    debug($this->GameApp->validationErrors);
                    $this->Session->setFlash(__('Lỗi, ProductDistribution chưa được thêm mới hãy thử lại lần nữa!'));
                }
            } else {
//                $this->deleteAllFile($tmp);
//                debug($this->GameApp->validationErrors);
                $this->Session->setFlash(__('Lỗi, ProductDistribution chưa được thêm mới hãy thử lại lần nữa!'));
            }
        }
    }

    public function edit($id = null) {
        $this->ProductDistribution->id = $id;
        $this->set('id', $id);

        $opts_danhmuc = $this->getOptsFromProductDanhMuc(array($id));
        $this->set('opts_danhmuc', $opts_danhmuc);

        if (!$this->ProductDistribution->exists()) {
            throw new NotFoundException(__('ProductDistribution không hợp lệ'));
        }

        $datas = $this->ProductDistribution->read(null, $id);
        // thực hiện chuyển tiếp các dữ liệu đã có trong database ra ngoài view
        // thông qua các input ẩn
        /**
         * BEGIN
         */
        $image_path = array();
        if (!empty($datas['ProductDistribution']['image_path_1'])) {
            $image_path[] = $datas['ProductDistribution']['image_path_1'];
        }
        if (!empty($datas['ProductDistribution']['image_path_2'])) {
            $image_path[] = $datas['ProductDistribution']['image_path_2'];
        }
        if (!empty($datas['ProductDistribution']['image_path_3'])) {
            $image_path[] = $datas['ProductDistribution']['image_path_3'];
        }

        $file_setup = array();
        if (!empty($datas['ProductDistribution']['jar_file'])) {
            $file_setup[] = $datas['ProductDistribution']['jar_file'];
        }
        if (!empty($datas['ProductDistribution']['jad_file'])) {
            $file_setup[] = $datas['ProductDistribution']['jad_file'];
        }
        if (!empty($datas['ProductDistribution']['apk_file'])) {
            $file_setup[] = $datas['ProductDistribution']['apk_file'];
        }
        if (!empty($datas['ProductDistribution']['xap_file'])) {
            $file_setup[] = $datas['ProductDistribution']['xap_file'];
        }

        $this->set(compact('image_path', 'file_setup'));
        /**
         * END
         */
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->add();
        } else {
            $this->setInit();
            $this->request->data = $this->ProductDistribution->read(null, $id);
        }
        $this->render('add');
    }

    public function delete($id = null) {
        parent::delete($id);
    }

    public function beforeFilter() {
        parent::beforeFilter();
//        $user = $this->Auth->user();
        /**
         * Thực hiện chuyển việc phân quyền hiện thị đối với các user không phải loại admin
         * được chuyển xuống tầng model
         * BEGIN
         */
//        if ($user['type'] != 1) {
//            $this->paginate['ProductDistribution']['conditions']['cms_user_id'] = (int) $user['id'];
//        }
        /**
         * END
         */
    }

    /**
     * setInit action
     * Phương thức thiết lập khởi tạo
     */
    protected function setInit() {
        $this->ProductDistribution->recursive = -1;
        $orders = $this->ProductDistribution->find('list', array(
            'fields' => array('order', 'order'),
            'group' => array('ProductDistribution.order'),
        ));
        $this->set('orders', $orders);

        $types = Configure::read('gom.DanhMuc.type');
        // thay đổi req, PRODUCT DISTRIBUTION hiện tại không có type = 6 nữa
        // mà có type giống với NEWS tức = 2
        // thay đổi này đồng thời xóa bỏ quan hện giữa gom_news và gom_product_distribution
//        $product_type = array_search('PRODUCT DISTRIBUTION', $types);
        $product_type = array_search('NEWS', $types);

        $trees = $this->getTreeDanhMuc($product_type);
        $danhmuc = $this->buildOptsDanhMuc($trees);
        $this->set('danhmuc', $danhmuc);

        $this->Company->recursive = -1;
        $company = $this->Company->find('list', array(
            'fields' => array('Company.id', 'Company.name'),
        ));
        $this->set('company', $company);

        $partner = $this->Distributor->find('list', array(
            'fields' => array('Distributor.id', 'Distributor.name'),
        ));

        $this->set('partner', $partner);
    }

    /**
     * Thực hiện xử lý lưu tới các Model liên kết - phân tách quan hệ n-n thành quan hệ 1-n
     * được chuyển xuống tâng model
     * BEGIN

      protected function saveProductDanhMuc() {
      $distributor_id = $this->ProductDistribution->getInsertID();
      $this->distributor_id = $distributor_id;
      $target = array();
      if (!empty($this->request->data['ProductDanhMuc']['danh_muc_id'])) {
      foreach ($this->request->data['ProductDanhMuc']['danh_muc_id'] as $key => $item) {
      $target[$key]['ProductDanhMuc']['danh_muc_id'] = $item;
      $target[$key]['ProductDanhMuc']['distributor_id'] = $distributor_id;
      }
      }
      $this->ProductDanhMuc->saveAll($target);
      }

      protected function saveTheLoaiRelation() {
      $distributor_id = $this->distributor_id;
      $target = array();
      if (!empty($this->request->data['TheLoaiRelation']['the_loai_id'])) {
      foreach ($this->request->data['TheLoaiRelation']['the_loai_id'] as $key => $item) {
      $target[$key]['TheLoaiRelation']['the_loai_id'] = $item;
      $target[$key]['TheLoaiRelation']['distributor_id'] = $distributor_id;
      }
      }
      $this->ProductDanhMuc->saveAll($target);
      }
     * END
     */
}