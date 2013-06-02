<?php

App::uses('AppModel', 'Model');

class CmsUser extends AppModel {

    public $useTable = 'cms_user';
    public $actsAs = array('Containable');
    public $belongsTo = array(
        'Company' => array(
            'className' => 'Company',
            'conditions' => array(
//                'Company.status' => 2,
                'Company.id = CmsUser.company_id',
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
    );
    public $validate = array(
        'user_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
        'type' => array(
            'valid' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc',
                'allowEmpty' => false
            )
        ),
         'company_id' => array(
            'valid' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc',
                'allowEmpty' => false
            )
        ),
    );

    // trước khi thực hiện lưu dữ liệu data nhập từ người dùng vào database
    // thực hiện mã hóa password, và nhập chuỗi đã mã hóa vào database

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

}