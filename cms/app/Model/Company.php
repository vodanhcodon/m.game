<?php

App::uses('AppModel', 'Model');

class Company extends AppModel {

    public $useTable = 'company';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'CmsUser' => array(
            'className' => 'CmsUser',
            'conditions' => array(
                'CmsUser.company_id = {$__cakeID__$}',
//                'CmsUser.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
        'GameApp' => array(
            'className' => 'GameApp',
            'conditions' => array(
                'GameApp.company_id = {$__cakeID__$}',
//                'GameApp.status' => 2,
            ),
            'foreignKey' => false,
            'dependent' => false,
        ),
    );

}