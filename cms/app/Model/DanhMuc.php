<?php

App::uses('AppModel', 'Model');

class DanhMuc extends AppModel {

    public $useTable = 'danh_muc';
    public $actsAs = array(
        'Containable',
    );
    public $hasMany = array(
        'TheLoai' => array(
            'className' => 'TheLoai',
            'conditions' => array(
                'TheLoai.danh_muc_id = {$__cakeID__$}',
//                'TheLoai.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'GameApp' => array(
            'className' => 'GameApp',
            'conditions' => array(
                'GameApp.danh_muc_id= {$__cakeID__$}',
//                'GameApp.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'ProductDanhMuc' => array(
            'className' => 'ProductDanhMuc',
            'conditions' => array(
                'ProductDanhMuc.danh_muc_id = {$__cakeID__$}',
//                'ProductDanhMuc.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'News' => array(
            'className' => 'News',
            'conditions' => array(
                'News.danh_muc_id = {$__cakeID__$}',
//                'News.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
    );
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
        'type' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
    );

    public function beforeSave($options = array()) {
        parent::beforeSave();
        $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');

        /**
         * Thực hiện kiểm tra tính đồng bộ dữ liệu trong Phân cấp danh mục parent_id
         * và kiểu danh mục type
         * BEGIN
         */
        if (!empty($this->data[$this->alias]['parent_id']) && !empty($this->data[$this->alias]['type'])) {
            // lấy về lựa chọn parent_id mà người dùng đã chọn dựa vào selectbox phân cấp danh mục
            $parent_id = $this->data[$this->alias]['parent_id'];
            
            // lấy về kiểu danh mục type mà người dùng đã chọn, dựa vào selectbox kiểu danh mục type
            $target_type = $this->data[$this->alias]['type'];
            
            // lấy các thông tin liên quan tới danh mục cha 
            // mà người dùng đã chọn dựa vào selectbox phân cấp danh mục
            $get_parent_type = $this->find('first', array(
                'conditions' => array('id' => $parent_id),
                'recursive' => -1,
            ));
            $parent_type = $get_parent_type[$this->alias]['type']; // lấy về kiểu type danh mục 
            $id = $get_parent_type[$this->alias]['id']; // lấy về id của danh mục

            // nếu kiểu type không đồng nhấttrong 2 selectbox mà người dùng đã chọn
            // thông báo lỗi
            if ($parent_type != $target_type) {
                $this->invalidate('parent_id', 'Lỗi, Phân cấp danh mục và Kiểu phân loại không tương ứng');
                $this->invalidate('type', 'Lỗi, Phân cấp danh mục và Kiểu phân loại không tương ứng');
                return FALSE;
            }

            // nếu người dùng chọn danh mục phân cấp cha trung với chính danh mục hiện tại
            // giữ nguyên parent_id đã có trong database từ trước không cập nhật mới
            if ($parent_id == $id) {
                unset($this->data[$this->alias]['parent_id']);
            }
        }
        /**
         * END
         */
        return true;
    }

}