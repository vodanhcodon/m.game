<?php

App::uses('AppController', 'Controller');

class TheLoaiController extends AppController {

    public $uses = array('TheLoai', 'DanhMuc');

    public function index() {

        $this->setInit();

        // đoạn mã tự động xử lý các điều kiện search do người dùng nhập vào
        // can thiệp trực tiếp tới kết quả $this->paginate phân trang hiện tại
        $this->parseUrlParams(array(
            'likea' => array('name'),
            'modelname' => 'TheLoai',
            'subcategories' => 'danh_muc_id', // có thực hiện liên kết với các subcategories của nó
        ));

        $this->paginate['TheLoai']['order'] = 'TheLoai.order ASC';
        $this->paginate['TheLoai']['contain'] = false;
        $this->paginate['TheLoai']['recursive'] = -1;

        $theloais = $this->paginate('TheLoai');
        $this->set('TheLoais', $theloais);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->TheLoai->saveMany(array_values($this->request->data))) {
                $this->Session->setFlash(__('Thể loại đã được cập nhật thành công!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Lỗi, Thể loại chưa được cập nhật, hãy thử lại lần nữa!'));
            }
        }
    }

    public function search() {
        parent::search();
    }

    public function add() {
        $this->setInit();
        if ($this->request->is('post')) {
            $this->TheLoai->create();
            $this->request->data['TheLoai']['created_date'] = $this->request->data['TheLoai']['last_update'] = date('Y-m-d H:i:s');
            if ($this->TheLoai->save($this->request->data)) {
                $this->Session->setFlash(__('Thể loại đã được thêm mới thành công!'));
                $this->redirect($this->request->data['referer']);
            } else {
                $this->Session->setFlash(__('Lỗi, Thể loại chưa được tạo, hãy thử lại lần nữa!'));
            }
        }
    }

    public function edit($id = null) {
        $this->TheLoai->id = $id;
        if (!$this->TheLoai->exists()) {
            throw new NotFoundException(__('Thể loại không hợp lệ'));
        }
        $this->setInit();
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['TheLoai']['last_update'] = date('Y-m-d H:i:s');
            if ($this->TheLoai->save($this->request->data)) {

                $this->Session->setFlash(__('Thể loại đã được cập nhật thành công!'));
                $this->redirect($this->request->data['referer']);
            } else {
                $this->Session->setFlash(__('Lỗi, Thể loại chưa được cập nhật, hãy thử lại lần nữa!'));
            }
        } else {
            $this->request->data = $this->TheLoai->read(null, $id);
            //       unset($this->request->data['CmsUser']['password']);
        }
        $this->render('add');
    }

    public function delete($id = null) {
        parent::delete($id);
    }

    protected function setInit() {
        $orders = $this->TheLoai->find('list', array(
            'fields' => array('order', 'order'),
            'group' => array('TheLoai.order'),
        ));
        $this->set('orders', $orders);

        $trees = $this->getTreeDanhMuc();
        $danhmuc = $this->buildOptsDanhMuc($trees);
        $this->set('danhmuc', $danhmuc);
    }

}