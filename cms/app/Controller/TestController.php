<?php

class TestController extends AppController {

    function upload() {
        $this->autoRender = FALSE;
        App::import('Vendor', 'jQuery-File-Upload', array('file' => 'jQuery-File-Upload/server/php' . DS . 'UploadHandler.php'));
        $action_link = Router::url(array('action' => 'upload'));
        $upload_handler = new UploadHandler($action_link);
    }

    function index() {
        
    }

    function test() {
        
    }

    function add() {
        $this->render('edit');
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Post', true));
            $this->redirect(array('action' => 'index'));
        }
        if (empty($this->data)) {
            $this->data = $this->Post->read(null, $id);
        }
    }

    function ajax_edit() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        if ($this->RequestHandler->isAjax()) {
            if (!empty($this->data)) {
                $this->Post->create();
                $this->Post->set($this->data['Post']);
                if ($this->Post->validates()) {
                    if ($this->Post->save($this->data)) {
                        $message = __('The Post has been saved.', true);
                        $data = $this->data;
                        $this->set('success', compact('message', 'data'));
                    }
                } else {
                    $message = __('The Post could not be saved. Please, try again.', true);
                    $Post = $this->Post->invalidFields();
                    $data = compact('Post');
                    $this->set('errors', compact('message', 'data'));
                }
            }
        }
    }

}