<?php

App::uses('AppController', 'Controller');

class GameEventController extends AppController {

    public $uses = array('GameEvent', 'TheLoai', 'DanhMuc', 'GameApp', 'Company');

    /**
     * index action
     * Liệt kê danh sách
     */
    public function index() {

        // liên kết $joins giữa 2 bảng game_app và game_event
        $joins = array(
            array(
                'table' => 'game_app',
                'alias' => 'GameApp',
                'type' => 'LEFT',
                'conditions' => array('GameApp.id = GameEvent.game_app_id'),
            ),
        );

        $this->parseUrlParams(array(
            'likea' => array('name'),
            'modelname' => 'GameEvent'
        ));

        $this->paginate['GameEvent']['order'] = 'GameEvent.order ASC';
        $this->paginate['GameEvent']['recursive'] = -1;
        $this->paginate['GameEvent']['limit'] = 20;
        $this->paginate['GameEvent']['joins'] = $joins;
        $this->paginate['GameEvent']['fields'] = array('GameEvent.*', 'GameApp.*');

        $gameEvents = $this->paginate('GameEvent');
        $this->set('gameEvents', $gameEvents);

        $orders = $this->GameEvent->find('list', array(
            'fields' => array('order', 'order'),
            'group' => array('GameEvent.order'),
        ));
        $this->set('orders', $orders);

        // lấy ra danh sách game đang là public
        $gamePublics = $this->GameEvent->find('all', array(
            'fields' => array('id'),
            'conditions' => array('GameEvent.status' => 2),
            'contain' => array('GameEvent'),
        ));
        $gamePublics = Hash::extract($gamePublics, '{n}.GameEvent.id');
        $this->set('gamePublic', $gamePublics);
    }

    /*
     * search action
     * phương thức dùng để biến đổi phương thức POST sang kiểu URL của  paginate
     */

    public function search() {
        parent::search();
    }

    public function add() {

        $this->setInit();
        $folder = Configure::read('gom.GameEvent.folder');
        $tmp = $folder['tmp'];

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->GameEvent->set($this->request->data);
            if ($this->GameEvent->validates()) {

                $dirpath = $this->getDirPath('name');

                if (!empty($this->request->data['GameEvent']['image_path'])) {
                    foreach ($this->request->data['GameEvent']['image_path'] as $key => $image_path) {
                        $this->request->data['GameEvent']['image_path_' . ($key + 1)] = $dirpath . $image_path;

                        $tmp_file = $tmp . $image_path;
                        $target_file = $dirpath . $image_path;
                        $this->copyFile($tmp_file, $target_file);
                    }

                    // thực hiện set các trường fields không được xuất hiện trong views thành rỗng
                    // các trường fields này được thực thi xử lý giám tiếp thông qua controller
                    // trong view nó có 1 trường fields đại diện có tên names khác
                    if (empty($this->request->data['GameEvent']['image_path_1'])) {
                        $this->request->data['GameEvent']['image_path_1'] = '';
                    }
                    if (empty($this->request->data['GameEvent']['image_path_2'])) {
                        $this->request->data['GameEvent']['image_path_2'] = '';
                    }
                    if (empty($this->request->data['GameEvent']['image_path_3'])) {
                        $this->request->data['GameEvent']['image_path_3'] = '';
                    }
                }

                $this->deleteAllFile($tmp);

                if ($this->GameEvent->save($this->request->data)) {
                    $this->Session->setFlash(__('GameEvent đã được thêm mới thành công!'));
                    $redirect = $this->request->data['referer'];
                    $this->redirect($redirect);
                } else {
                    $this->Session->setFlash(__('Lỗi, game chưa được thêm mới hãy thử lại lần nữa!'));
                }
            } else {
                $this->Session->setFlash(__('Lỗi, game chưa được thêm mới hãy thử lại lần nữa!'));
            }
        }
    }

    public function edit($id = null) {
        $this->GameEvent->id = $id;
        $this->set('id', $id);
        if (!$this->GameEvent->exists()) {
            throw new NotFoundException(__('Sự kiện GameEvent không hợp lệ'));
        }

        $datas = $this->GameEvent->read(null, $id);
        // thực hiện chuyển tiếp các dữ liệu đã có trong database ra ngoài view
        // thông qua các input ẩn
        /**
         * BEGIN
         */
        $image_path = array();
        if (!empty($datas['GameEvent']['image_path_1'])) {
            $image_path[] = $datas['GameEvent']['image_path_1'];
        }
        if (!empty($datas['GameEvent']['image_path_2'])) {
            $image_path[] = $datas['GameEvent']['image_path_2'];
        }
        if (!empty($datas['GameEvent']['image_path_3'])) {
            $image_path[] = $datas['GameEvent']['image_path_3'];
        }

        $this->set('image_path', $image_path);
        /**
         * END
         */
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->add();
        } else {
            $this->setInit();
            $this->request->data = $this->GameEvent->read(null, $id);
        }

        $this->render('add');
    }

    public function delete($id = null) {
        parent::delete($id);
    }

    public function getForumLink() {
        $this->autoRender = FALSE;
        if (!empty($this->request->query['game_app_id'])) {
            $gameId = $this->request->query['game_app_id'];
            $forumlinks = $this->GameApp->find('first', array(
                'conditions' => array('GameApp.id' => $gameId),
                'fields' => array('GameApp.forum_link'),
            ));

            $forumlink = '';
            if (!empty($forumlinks)) {
                $forumlink = $forumlinks['GameApp']['forum_link'];
            }
            echo $forumlink;
        }
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $user = $this->Auth->user();
        if ($user['type'] != 1) {
            $this->paginate['GameEvent']['conditions']['GameEvent.cms_user_id'] = (int) $user['id'];
        }
    }

    protected function setInit() {
        $company = $this->Company->find('list', array(
            'fields' => array('Company.id', 'Company.name'),
        ));
        $findGame = $this->GameApp->find('all', array(
            'fields' => array('GameApp.id', 'GameApp.name', 'GameApp.status'),
        ));
        $game = array();
        $status = Configure::read('gom.status');
        foreach ($findGame as $item) {
            $id = $item['GameApp']['id'];
            $label = $item['GameApp']['name'] . '(' . $status[$item['GameApp']['status']] . ')';
            $game[$id] = $label;
        }
        $this->set('company', $company);
        $this->set('game', $game);
    }

}