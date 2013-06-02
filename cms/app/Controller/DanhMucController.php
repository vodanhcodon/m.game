<?php

App::uses('AppController', 'Controller');

class DanhMucController extends AppController {

    public $uses = array('DanhMuc');
    public $type = '';

    public function index($type = null) {
        /**
         * Xóa bỏ cách xử lý danh mục của hệ thống cũ
         * BEGIN
         */
//        $orders = $this->DanhMuc->find('list', array('fields' => array('order', 'order'), 'group' => array('DanhMuc.order')));
//        $this->set('orders', $orders);
//
//        $this->paginate = array(
//            'DanhMuc' => array(
//                'order' => 'DanhMuc.order ASC',
//                'contain' => false,
//                'recursive' => -1,
//                'limit' => 20
//            )
//        );
//        $danhmucs = $this->paginate('DanhMuc');
//        $this->set('danhmucs', $danhmucs);
//
//        if ($this->request->is('post') || $this->request->is('put')) {
//            if ($this->DanhMuc->saveMany($this->request->data)) {
//                $this->Session->setFlash(__('Danh mục đã được cập nhật thành công!'));
//                $this->redirect(array('action' => 'index'));
//            } else {
//                $this->Session->setFlash(__('Lỗi, danh mục chưa được cập nhật, hãy thử lại lần nữa!'));
//            }
//        }
        /**
         * END
         */
        // xử lý điều kiện search
        $options = array();
        if ($this->request->is('post')) {
            if (!empty($this->request->data['Search']['type'])) {
                $type = $this->request->data['Search']['type'];
            }
            if (isset($this->request->data['Search']['status']) && strlen($this->request->data['Search']['status'])) {
                $options['conditions']['DanhMuc.status'] = $this->request->data['Search']['status'];
            }
            if (!empty($this->request->data['Search']['parent_id'])) {
                $options['conditions']['DanhMuc.parent_id'] = $this->request->data['Search']['parent_id'];
            }
        }

        $trees_game = $this->getTreeDanhMuc(1);

        $trees_news = $this->getTreeDanhMuc(2);

        $trees_app = $this->getTreeDanhMuc(3);

        $trees_product = $this->getTreeDanhMuc(6);

        // tạo ra selectbox phân cấp cha con
        $opts_game = $this->buildOptsDanhMuc($trees_game);
        $opts_news = $this->buildOptsDanhMuc($trees_news);
        $opts_app = $this->buildOptsDanhMuc($trees_app);
        $opts_product = $this->buildOptsDanhMuc($trees_product);

        // nếu có thực hiện search, thì thực hiện tìm kiếm danh mục theo điều kiện search
        // xây dựng cấu trúc tree danh mục
        if (!empty($type)) {
            switch ($type):
                case '1':
                    $trees_game = $this->getTreeDanhMuc(1, $options);
                    break;
                case '2':
                    $trees_news = $this->getTreeDanhMuc(2, $options);
                    break;
                case '3':
                    $trees_app = $this->getTreeDanhMuc(3, $options);
                    break;
                case '6':
                    $trees_product = $this->getTreeDanhMuc(6, $options);
                    break;
                default :
                    $trees_game = $this->getTreeDanhMuc(1, $options);
            endswitch;
        }
        else {
            // Mặc định set type = 1 tức là luôn kích hoạt tab danh mục Game trong view
            $type = 1;
        }

        // thực hiện build ra cấu trúc <ol> và <li> lồng nhau, dựa vào cây tree danh mục ở trên
        $this->firstOl = 0;
        $danhmuc_game = $this->buildTreeDanhMuc($trees_game, 1);
        $this->firstOl = 0;
        $danhmuc_app = $this->buildTreeDanhMuc($trees_app, 3);
        $this->firstOl = 0;
        $danhmuc_news = $this->buildTreeDanhMuc($trees_news, 2);
        $this->firstOl = 0;
        $danhmuc_product = $this->buildTreeDanhMuc($trees_product, 6);

        $this->set('type_danhmuc', $type);
        $this->set(compact('danhmuc_game', 'danhmuc_news', 'danhmuc_app', 'danhmuc_product'));
        $this->set(compact('opts_game', 'opts_news', 'opts_app', 'opts_product'));
    }

    public function search() {
        parent::search();
    }

    /**
     * add action
     * @param int $type - dùng để xác định kiểu danh mục xem nó là danh mục GAME, APP , NEWS, ...
     * mục đích để giới hạn phạm vi khi người dùng thêm mới (chỉ thêm mới danh mục thuộc GAME hay APP)
     * và để back về màn hình danh sách mà tab danh mục type tương ứng được kích hoạt
     */
    public function add($type = null) {
        $this->type = $type;
        $this->setInit();

        if ($this->request->is('post')) {
            $this->DanhMuc->create();
            $this->request->data['DanhMuc']['created_date'] = $this->request->data['DanhMuc']['last_update'] = date('Y-m-d H:i:s');
            $tmpfolder = $this->preprocessData();
            if ($this->DanhMuc->save($this->request->data)) {
                $this->Session->setFlash(__('Danh mục đã được thêm mới thành công!'));
                $this->deleteAllFile($tmpfolder);
                $this->redirect(array('action' => 'index', $type));
            } else {
                $this->Session->setFlash(__('Lỗi, danh mục chưa được tạo, hãy thử lại lần nữa!'));
            }
        }
    }

    /**
     * edit action
     * @param int $id
     * @param int $type  - dùng để xác định kiểu danh mục xem nó là danh mục GAME, APP , NEWS, ...
     * mục đích để giới hạn phạm vi khi người dùng thêm mới (chỉ thêm mới danh mục thuộc GAME hay APP)
     * và để back về màn hình danh sách mà tab danh mục type tương ứng được kích hoạt
     * @throws NotFoundException
     */
    public function edit($id = null, $type = null) {
        $this->setInit();
        $this->DanhMuc->id = $id;
        if (!$this->DanhMuc->exists()) {
            throw new NotFoundException(__('Danh mục không hợp lệ'));
        }

        $trees = $this->getTreeDanhMuc();
        $optsDanhMuc = $this->buildOptsDanhMuc($trees);
        $this->set('optsDanhMuc', $optsDanhMuc);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['DanhMuc']['last_update'] = date('Y-m-d H:i:s');
            $tmpfolder = $this->preprocessData();
            if ($this->DanhMuc->save($this->request->data)) {
                $this->Session->setFlash(__('Danh mục đã được cập nhật thành công!'));
                $this->deleteAllFile($tmpfolder);
                $this->redirect(array('action' => 'index', $type));
            } else {
                $this->Session->setFlash(__('Lỗi, danh mục chưa được cập nhật, hãy thử lại lần nữa!'));
            }
        } else {
            $this->DanhMuc->recursive = -1;
            $this->request->data = $this->DanhMuc->read(null, $id);
            //       unset($this->request->data['CmsUser']['password']);
        }
        $this->render('add');
    }

    public function updateList() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('Bạn không có quyền thực hiện thao tác này');
        }
        $trees = json_decode($this->request->data['DanhMuc']['trees'], TRUE);

        $type = !empty($this->request->data['DanhMuc']['type']) ? $this->request->data['DanhMuc']['type'] : 1;

        $target = array();
        foreach ($trees as $item) {
            if (!empty($item['item_id'])) {
                $target[] = array(
                    'id' => $item['item_id'],
                    'parent_id' => !empty($item['parent_id']) ? $item['parent_id'] : 0,
                    'order' => $item['left'],
                );
            }
        }
        if ($this->DanhMuc->saveAll($target)) {
            $this->Session->setFlash('Danh Mục đã được cập nhật thành công!');
            $this->redirect(array('action' => 'index', $type));
        } else {
            $this->Session->setFlash('Lỗi, Danh Mục không được cập nhật thành công!');
            $this->redirect(array('action' => 'index', $type));
        }
    }

    public function delete($id = null, $type = null) {
        $response = array();
        $modelName = $this->modelClass;

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('Bạn không có quyền thực hiện thao tác này');
        }
        // giới hạn quyền delete đối với các user thường: không được xóa các record hiện đang ở
        // trạng thái public
        $userType = $this->Auth->user('type');
        if ($userType != 1) {
            $public = $this->$modelName->find('list', array(
                'conditions' => array($modelName . '.status' => 2),
                'fields' => array($modelName . '.id'),
            ));
            $public = array_values($public);
            if (in_array($id, $public) !== FALSE) {
                $this->autoRender = FALSE;
                $response['error'] = 'Bạn không có quyền thực hiện thao tác này';
                echo json_encode($response);
                return FALSE;
            }
        }
        $this->autoRender = FALSE;
        $this->$modelName->id = $id;
        if (!$this->$modelName->exists()) {
            $response['error'] = 'Dữ liệu không tồn tại';
            echo json_encode($response);
            return FALSE;
        }
        if ($this->$modelName->save(array('status' => -1))) {
            $this->Session->setFlash(__('Dữ liệu đã được xóa'));
            $response['redirect'] = Router::url(array('action' => 'index', $type));
            echo json_encode($response);
            return FALSE;
        } else {
            $response['error'] = 'Dữ liệu không được xóa thành công!';
            echo json_encode($response);
            return FALSE;
        }
    }

    protected function setInit() {
        if (!empty($this->type)) {
            $trees = $this->getTreeDanhMuc($this->type);
        } else {
            $trees = $this->getTreeDanhMuc();
        }
        $danhmucs = $this->buildOptsDanhMuc($trees);

        $types = Configure::read('gom.DanhMuc.type');
        $default = 0;
        if (!empty($this->type)) {
            $types = array($this->type => $types[$this->type]);
            $default = $this->type;
        }

        $this->set('danhmucs', $danhmucs);
        $this->set('types', $types);
        $this->set('default', $default);
    }

    protected function preprocessData() {
        $tmpfolder = Configure::read('gom.tmp');
        $targetfolder = Configure::read('gom.DanhMuc.folder.dir');
        if (!empty($this->request->data['DanhMuc']['image_file_path'])) {
            $image_name = $this->request->data['DanhMuc']['image_file_path'];
            $this->request->data['DanhMuc']['image_file_path'] = $targetfolder . $this->request->data['DanhMuc']['image_file_path'];
            $this->copyFile($tmpfolder . $image_name, $targetfolder . $image_name);
            $this->request->data['DanhMuc']['image_file_type'] = substr(strrchr($this->request->data['DanhMuc']['image_file_path'], '.'), 1);
        } else {
            $this->request->data['DanhMuc']['image_file_path'] = '';
            $this->request->data['DanhMuc']['image_file_type'] = '';
        }
        if (!empty($this->request->data['DanhMuc']['thumbnail_image_path'])) {
            $thumbail_name = $this->request->data['DanhMuc']['thumbnail_image_path'];
            $this->copyFile($tmpfolder . $thumbail_name, $targetfolder . $thumbail_name);
            $this->request->data['DanhMuc']['thumbnail_image_path'] = $targetfolder . $this->request->data['DanhMuc']['thumbnail_image_path'];
        } else {
            $this->request->data['DanhMuc']['thumbnail_image_path'] = '';
        }
        if (empty($this->request->data['DanhMuc']['parent_id'])) {
            $this->request->data['DanhMuc']['parent_id'] = 0;
        }
        return $tmpfolder;
    }

}