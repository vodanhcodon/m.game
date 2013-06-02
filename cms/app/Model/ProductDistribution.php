<?php

App::uses('AppModel', 'Model');

class ProductDistribution extends AppModel {

    public $useTable = 'product_distribution';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'ProductDanhMuc' => array(
            'className' => 'ProductDanhMuc',
            'conditions' => array(
                'ProductDanhMuc.distributor_id = {$__cakeID__$}',
//                'ProductDanhMuc.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'News' => array(
            'className' => 'News',
            'conditions' => array(
                'News.product_distribution_id = {$__cakeID__$}',
//                'News.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
            /**
             * Xóa bỏ thể loại
             * BEGIN
             */
//        'TheLoaiRelation' => array(
//            'className' => 'TheLoaiRelation',
//            'conditions' => array(
//                'TheLoaiRelation.distribution_id = {$__cakeID__$}',
//                'TheLoaiRelation.status' => 2,
//            ),
//            'foreignKey' => false,
//            'dependent' => false,
//        ),
            /**
             *
             * END
             */
    );
    public $belongsTo = array(
        'Distributor' => array(
            'className' => 'Distributor',
            'conditions' => array(
                'Distributor.id = ProductDistribution.distributor_id',
//                'Distributor.status' => 2,
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
        'danh_muc_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy chọn 1 danh mục'
            )
        ),
        /**
         * Xóa bỏ thể loại
         * BEGIN
         */
//        'the_loai_id' => array(
//            'valid' => array(
//                'rule' => array('notEmpty'),
//                'message' => 'Hãy chọn 1 thể loại',
//                'allowEmpty' => false
//            )
//        ),
        /**
         * END
         */
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
        'load_screen_image' => array(
            'extension' => array(
                'rule' => array('extension', array('png', 'jpg')),
                'message' => 'Định dạng file không đúng',
                'allowEmpty' => true
            ),
        ),
        'version' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy điền vào phiên bản version'
            )
        ),
//        'type' => array(
//            'required' => array(
//                'rule' => array('notEmpty'),
//                'message' => 'Hãy chọn 1 loại game'
//            )
//        ),
        'platform' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Hãy chọn 1 loại game'
            )
        ),
    );

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        $type = Configure::read('gom.platform');
        if (!isset($this->data[$this->alias]['platform'])) {
            return TRUE;
        }

        $platform = $this->data[$this->alias]['platform'];
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
                if ($type[$platform] == 'winphone' && $file_ext != 'xap') {
                    return FALSE;
                }
                if ($type[$platform] == 'iphone') {
                    return TRUE;
                }
            }
        } else {
//            return FALSE;
        }

        return TRUE;
    }

    public function beforeSave($options = array()) {
        parent::beforeSave();
        $userId = CakeSession::read('Auth.User.id');
        /**
         * Thực hiện cập nhập time vào các trường created_date và last_update
         * BEGIN
         */
        // nếu là tạo mới thì cập nhật cả 2 trường
        if (!isset($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['cms_user_id'] = $userId;
            $this->data[$this->alias]['created_date'] = $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        }
        // nếu là update thì chỉ cập nhật trường last_update
        else {
            $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        }
        /**
         * END
         */
        return true;
    }

}