<?php

App::uses('AppModel', 'Model');

class Distributor extends AppModel {

    public $useTable = 'distributor';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'ProductDistribution' => array(
            'className' => 'ProductDistribution',
            'conditions' => array(
                'ProductDistribution.distributor_id = {$__cakeID__$}',
//                'ProductDistribution.status !=' => -1,
            ),
            'foreignKey' => false,
        ),
    );

}