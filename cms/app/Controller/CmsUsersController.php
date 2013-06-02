<?php

App::uses('AppController', 'Controller');

class CmsUsersController extends AppController {

    var $uses = array('CmsUser', 'Company', 'AccessLog');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    /**
     * Danh sách CMS user
     */
    public function index() {

        $this->setInit();
        /**
         * comment code lại, do thực hiện join các bảng table thông qua
         * tầng model
         * BEGIN
         */
        /*
          $joins = array(
          array(
          'table' => 'companies',
          'alias' => 'Company',
          'type' => 'LEFT',
          'conditions' => array('Company.id = CmsUser.company_id'),
          ),
          );
         * */
        /**
         * END
         */
        $this->parseUrlParams(array(
            'likea' => array('user_name'),
            'modelname' => 'CmsUser',
        ));

        $this->paginate['CmsUser']['order'] = 'CmsUser.id desc';
        $this->paginate['CmsUser']['recursive'] = -1;
        $this->paginate['CmsUser']['contain'] = array('Company');
        $this->paginate['CmsUser']['fields'] = 'Company.*,CmsUser.*';
        $this->paginate['CmsUser']['limit'] = 20;
        $users = $this->paginate('CmsUser');

        $this->set('users', $users);
    }

    public function search() {
        parent::search();
    }

    /**
     * Phương thức thêm mới CMS user
     */
    public function add() {
        $this->setInit();
        if ($this->request->is('post')) {
            $this->CmsUser->create();
            if ($this->CmsUser->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * phương thức chỉnh sửa CMS user
     * @param int $id
     * @throws NotFoundException
     */
    public function edit($id = null) {

        $this->setInit();
        $this->CmsUser->id = $id;
        if (!$this->CmsUser->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->CmsUser->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been updated'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->CmsUser->read(null, $id);
//       unset($this->request->data['CmsUser']['password']);
        }
        $this->render('add');
    }

    /**
     * Phương thức xóa vật lý CMS user
     * @param int $id
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->CmsUser->id = $id;
        if (!$this->CmsUser->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
//        if ($this->CmsUser->delete()) {
//            $this->Session->setFlash(__('User deleted'));
//            $this->redirect(array('action' => 'index'));
//        }
        if ($this->CmsUser->save(array('status' => -1))) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    protected function setInit() {
        /*
         * lấy về danh sách các công ty company
         */
        $this->Company->recursive = -1;
        $companys = $this->Company->find('list', array(
            'fields' => array('Company.id', 'Company.name')
        ));
        $this->set('companys', $companys);
        /*         * ************************************************ */
    }

}