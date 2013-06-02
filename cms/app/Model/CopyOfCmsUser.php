<?php

App::uses('AppModel', 'Model');

class CmsUser extends AppModel {

    public $validate = array(
        'user_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'type' => array(
            'valid' => array(
                'rule' => array('notEmpty'),
                'message' => 'A type is required',
                'allowEmpty' => false
            )
        )
    );

    // trước khi thực hiện lưu dữ liệu data nhập từ người dùng vào database
    // thực hiện mã hóa password, và nhập chuỗi đã mã hóa vào database

    public function beforeSave($options = array()) {
        if (isset($this->data['CmsUser']['password'])) {
            $this->data['CmsUser']['password'] = AuthComponent::password($this->data['CmsUser']['password']);
        }
        return true;
    }

}