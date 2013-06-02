<?php

App::uses('AppModel', 'Model');

class ProductDanhMuc extends AppModel {

    public $useTable = 'product_danh_muc';
    public $actsAs = array('Containable');
    public $belongsTo = array(
        'DanhMuc' => array(
            'className' => 'DanhMuc',
            'conditions' => array(
                'DanhMuc.id = ProductDanhMuc.danh_muc_id',
//                'DanhMuc.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'ProductDistribution' => array(
            'className' => 'ProductDistribution',
            'conditions' => array(
                'ProductDistribution.id = ProductDanhMuc.distributor_id',
//                'ProductDistribution.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
    );

}
