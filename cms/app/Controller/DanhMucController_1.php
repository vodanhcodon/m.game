<?php
App::uses('AppController', 'Controller');
class DanhMucController extends AppController {
  public $uses = array('DanhMuc');
  
  public function index(){
    $orders = $this->DanhMuc->find('list',array('fields' => array('order','order'),'group' => array('DanhMuc.order')));
    $this->set('orders',$orders);
    
    $this->paginate = array(
        'DanhMuc' => array(
            'order' => 'DanhMuc.order ASC',
            'contain' => false,
            'recursive' => -1,
        )
    );
    $danhmucs = $this->paginate('DanhMuc');
    $this->set('danhmucs',$danhmucs);
    
    if($this->request->is('post')||$this->request->is('put')){
//       pr(array_values($this->request->data));
     if($this->DanhMuc->saveMany(array_values($this->request->data))){
        $this->Session->setFlash(__('Danh mục đã được cập nhật thành công!'));
        $this->redirect(array('action' => 'index'));
      }
      else{
        $this->Session->setFlash(__('Lỗi, danh mục chưa được cập nhật, hãy thử lại lần nữa!'));
      } 
    }

  }
  public function add(){
    if ($this->request->is('post')) {
      $this->DanhMuc->create();
      $this->request->data['DanhMuc']['created_date'] = $this->request->data['DanhMuc']['last_update'] = date('Y-m-d H:i:s');
      if ($this->DanhMuc->save($this->request->data)) {
        $this->Session->setFlash(__('Danh mục đã được thêm mới thành công!'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('Lỗi, danh mục chưa được tạo, hãy thử lại lần nữa!'));
      }
    }
  }
 public function edit($id = null){
    $this->DanhMuc->id = $id;
    if (!$this->DanhMuc->exists()) {
      throw new NotFoundException(__('Danh mục không hợp lệ'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      $this->request->data['DanhMuc']['last_update'] = date('Y-m-d H:i:s');
      if ($this->DanhMuc->save($this->request->data)) {
         
        $this->Session->setFlash(__('Danh mục đã được cập nhật thành công!'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('Lỗi, danh mục chưa được cập nhật, hãy thử lại lần nữa!'));
      }
    } else {
      $this->request->data = $this->DanhMuc->read(null, $id);
      //       unset($this->request->data['CmsUser']['password']);
    }
  
  }
  public function delete($id = null){
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->DanhMuc->id = $id;
    if (!$this->DanhMuc->exists()) {
      throw new NotFoundException(__('Danh mục không hợp lệ'));
    }
    $this->request->data['DanhMuc']['last_update'] = date('Y-m-d H:i:s');
    if ($this->DanhMuc->save(array('status' => -1))) {
      $this->Session->setFlash(__('Danh mục đã được xóa thành công!'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Danh mục không được xóa, hãy thử lại lần nữa!'));
    $this->redirect(array('action' => 'index'));
  
  }
}