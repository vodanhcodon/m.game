<?php

App::uses('AppModel', 'Model');

class NewsImage extends AppModel {

    public $useTable = 'news_image';
    public $actsAs = array('Containable');
    public $belongsTo = array(
        'News' => array(
            'className' => 'News',
            'conditions' => array('News.id = NewsImage.news_id'),
            'foreignKey' => false,
            'dependent' => false,
        )
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
    }

}