<?php

App::uses('AppModel', 'Model');

class AccessLog extends AppModel {

    public $useTable = 'access_log';

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        pr($this->data[$this->alias]);die;
        if (!isset($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $this->data[$this->alias]['url'] = $_SERVER['HTTP_REFERER'];
            $this->data[$this->alias]['access_time'] = date('Y-m-d H:i:s');
        }
    }

}