<?php

App::uses('AppModel', 'Model');

class GameApp extends AppModel {

    public $useTable = 'game_app';
    public $actsAs = array('Containable');
    public $belongsTo = array(
        'DanhMuc' => array(
            'className' => 'DanhMuc',
            'conditions' => array(
                'DanhMuc.id = GameApp.danh_muc_id',
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'Company' => array(
            'className' => 'Company',
            'conditions' => array(
                'Company.id = GameApp.company_id',
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
    );
    public $hasMany = array(
        'GameEvent' => array(
            'className' => 'GameEvent',
            'conditions' => array(
                'GameEvent.game_app_id = {$__cakeID__$}',
            ),
            'foreignKey' => false,
        ),
        'TheLoaiRelation' => array(
            'className' => 'TheLoaiRelation',
            'conditions' => array(
                'TheLoaiRelation.game_app_id = {$__cakeID__$}',
            ),
            'foreignKey' => false,
        ),
    );
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào tên game'
            )
        ),
        'danh_muc_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy chọn 1 danh mục'
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
        'device_support' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy nhập vào dòng máy hỗ trợ'
            )
        ),
        'logo' => array(
            'extension' => array(
                'rule' => array('extension', array('png', 'jpg')),
                'message' => 'Định dạng file không đúng',
            ),
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường dữ liệu bắt buộc'
            )
        ),
        'version' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào phiên bản version'
            )
        ),
        'type' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường dữ liệu bắt buộc'
            )
        ),
        'platform' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường dữ liệu bắt buộc'
            )
        ),
        'android_store_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường dữ liệu bắt buộc'
            )
        ),
        'windows_store_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường dữ liệu bắt buộc'
            )
        ),
        'iphone_store_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường dữ liệu bắt buộc'
            )
        ),
//        'file_setup' => array(
//            'required' => array(
//                'rule' => array('checkEmpty'),
//                'message' => 'Đây là trường dữ liệu bắt buộc'
//            )
//        ),
    );

    public function checkEmpty($check) {
        if (empty($check)) {
            return FALSE;
        }
        return TRUE;
    }

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        $type = Configure::read('gom.platform');

        if (!isset($this->data[$this->alias]['platform'])) {
            return TRUE;
        }
        $platform = $this->data[$this->alias]['platform'];
        // xóa bỏ đi các điều kiện ràng buộc không cần thiết, phụ thuộc vào platform
        if ($type[$this->data[$this->alias]['platform']] == 'j2me non touch' || $type[$this->data[$this->alias]['platform']] == 'j2me full touch') {
            $this->validator()->remove('android_store_id');
            $this->validator()->remove('windows_store_id');
            $this->validator()->remove('iphone_store_id');
        } elseif ($type[$this->data[$this->alias]['platform']] == 'android') {
            $this->validator()->remove('windows_store_id');
            $this->validator()->remove('iphone_store_id');
        } elseif ($type[$this->data[$this->alias]['platform']] == 'winphone') {
            $this->validator()->remove('iphone_store_id');
            $this->validator()->remove('android_store_id');
        } elseif ($type[$this->data[$this->alias]['platform']] == 'iphone') {
            $this->validator()->remove('windows_store_id');
            $this->validator()->remove('android_store_id');
        }

        // kiểm tra tính hợp lệ của dữ liệu tải lên, xem định dạng file có phù hợp với platform không
        if (!empty($this->data[$this->alias]['file_setup'])) {
            foreach ($this->data[$this->alias]['file_setup'] as $file_setup) {
                $file_ext = strtolower(substr(strrchr($file_setup, '.'), 1));
                if (($type[$platform] == 'j2me non touch' || $type[$platform] == 'j2me full touch') && ($file_ext != 'jad' && $file_ext != 'jar')) {
                    return FALSE;
                }
                if ($type[$platform] == 'android' && $file_ext != 'apk') {
                    return FALSE;
                }
                if ($type[$platform] == 'winphone' || $type[$platform] == 'iphone') {
                    return TRUE;
                }
            }
        } else {
//            $this->invalidate('file_error', 'Đây là trường bắt buộc');
            return FALSE;
        }

        // kiểm tra sự tương ứng giữa Danh mục danh_muc_id và type
        /**
         * BEGIN
         */
        // lấy ra danh_muc_id và type mà người dùng đã chọn
        $danh_muc_id = $this->data[$this->alias]['danh_muc_id'];
        $gameapp_type = $this->data[$this->alias]['type'];

        // lấy ra Danh mục type, dựa vào danh_muc_id
        $get_danh_muc_type = $this->DanhMuc->find('first', array(
            'conditions' => array('id' => $danh_muc_id),
            'recursive' => -1,
        ));
        $danh_muc_type = $get_danh_muc_type['DanhMuc']['type'];

        // tiến hành kiểm tra sự tương ứng
        // DanhMuc.type = 1 đồng nhấy GameApp.type = 1 nghĩa là Game
        if ($danh_muc_type == 1 && $gameapp_type == 1) {
            
        }
        // DanhMuc.type = 3 đồng nhấy GameApp.type = 2 nghĩa là App
        elseif ($danh_muc_type == 3 && $gameapp_type == 2) {
            
        } else {
            $this->invalidate('danh_muc_id', 'Lỗi, Danh Mục và Loại GameApp không tương ứng');
            $this->invalidate('type', 'Lỗi, Danh Mục và Loại GameApp không tương ứng');
            return FALSE;
        }
        /**
         * END
         */
        return TRUE;
    }

    public function beforeSave($options = array()) {
        parent::beforeSave();
        $userId = CakeSession::read('Auth.User.id');
        if (!isset($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['cms_user_id'] = $userId;
            $this->data[$this->alias]['created_date'] = $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        } else {
            $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        }
        return true;
    }

}