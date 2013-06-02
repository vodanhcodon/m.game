<?php

App::uses('AppModel', 'Model');

class GameEvent extends AppModel {

    public $useTable = 'game_event';
    public $belongsTo = array(
        'GameApp' => array(
            'className' => 'GameApp',
            'conditions' => array(
                'GameApp.id = GameEvent.game_app_id',
//                'GameApp.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
    );
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào tên game'
            )
        ),
        'short_decription' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào mô tả ngắn'
            )
        ),
        'description' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào mô tả'
            )
        ),
        'start_date' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào ngày bắt đầu'
            )
        ),
        'end_date' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào ngày kết thúc'
            )
        ),
        'game_app_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào game tương ứng'
            )
        ),
        'game_forum_link' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào đường dẫn game forum'
            )
        ),
        'image_path_1' => array(
            'extension' => array(
                'rule' => array('extension', array('png', 'jpg')),
                'message' => 'Định dạng file không đúng',
                'allowEmpty' => true
            ),
        ),
        'image_path_2' => array(
            'extension' => array(
                'rule' => array('extension', array('png', 'jpg')),
                'message' => 'Định dạng file không đúng',
                'allowEmpty' => true
            ),
        ),
        'image_path_3' => array(
            'extension' => array(
                'rule' => array('extension', array('png', 'jpg')),
                'message' => 'Định dạng file không đúng',
                'allowEmpty' => true
            )
        ),
    );

    public function beforeSave($options = array()) {
        parent::beforeSave();
        $userId = CakeSession::read('Auth.User.id');
//        $userType = CakeSession::read('Auth.User.type');
//        $this->data['Game']['cms_user_id'] = $userId;
        /*
         * thực hiện thêm tên thư mục mới tạo ra tùy thuộc vào tên game
         * vào phía trước tên mỗi file sẽ được upload lên
         */
        if (isset($this->data[$this->alias]['name']) && strlen($this->data[$this->alias]['name'])) {
            $dirname = $this->convert_vi_to_en($this->data[$this->alias]['name']);
            $this->prefixDirName($dirname, array('image_path_1', 'image_path_2', 'image_path_3'));
        }
        if (!isset($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['cms_user_id'] = $userId;
            $this->data[$this->alias]['created_date'] = $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        } else {
            $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        }
        if (!empty($this->data[$this->alias]['start_date'])) {
            $startDate = $this->data[$this->alias]['start_date'];
            $startDate = str_replace('/', '-', $startDate);
            $this->data[$this->alias]['start_date'] = date('Y-m-d H:i:s', strtotime($startDate));
        }
        if (!empty($this->data[$this->alias]['end_date'])) {
            $endDate = $this->data[$this->alias]['end_date'];
            $endDate = str_replace('/', '-', $endDate);
            $this->data[$this->alias]['end_date'] = date('Y-m-d H:i:s', strtotime($endDate));
        }
        return true;
    }

    public function prefixDirName($dirname, $fields = array()) {
        foreach ($fields as $field) {
            if (isset($this->data[$this->alias][$field]) && strlen($this->data[$this->alias][$field]) && strpos($this->data[$this->alias][$field], $dirname . '/') === FALSE) {
                $this->data[$this->alias][$field] = $dirname . '/' . $this->data[$this->alias][$field];
            }
        }
    }

}