<?php

App::uses('AppModel', 'Model');

class TheLoai extends AppModel {

    public $useTable = 'the_loai';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'TheLoaiRelation' => array(
            'className' => 'TheLoaiRelation',
            'conditions' => array(
                'TheLoaiRelation.the_loai_id = {$__cakeID__$}',
//                'TheLoaiRelation.status !=' => -1,
            ),
            'foreignKey' => false,
        ),
    );
    public $belongsTo = array(
        'DanhMuc' => array(
            'className' => 'DanhMuc',
            'conditions' => array(
                'DanhMuc.id = TheLoai.danh_muc_id',
//                'DanhMuc.status !=' => -1,
            ),
            'foreignKey' => false,
        ),
    );
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
    );

    public function beforeSave($options = array()) {
        parent::beforeSave();

        $this->data['TheLoai']['last_update'] = date('Y-m-d H:i:s');
        return true;
    }

}
