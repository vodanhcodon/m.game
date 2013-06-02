<?php

App::uses('AppModel', 'Model');

class TheLoaiRelation extends AppModel {

    public $useTable = 'the_loai_relation';
    public $actsAs = array('Containable');
    public $belongsTo = array(
        'TheLoai' => array(
            'className' => 'TheLoai',
            'conditions' => array(
                'TheLoai.id = TheLoaiRelation.the_loai_id',
//                'TheLoai.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'News' => array(
            'className' => 'News',
            'conditions' => array(
                'News.id = TheLoaiRelation.news_id',
//                'News.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'GameApp' => array(
            'className' => 'GameApp',
            'conditions' => array(
                'GameApp.id = TheLoaiRelation.game_app_id',
//                'GameApp.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'ProductDistribution' => array(
            'className' => 'ProductDistribution',
            'conditions' => array(
                'ProductDistribution.id = TheLoaiRelation.distribution_id',
//                'ProductDistribution.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
    );

}