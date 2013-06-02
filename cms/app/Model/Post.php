<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {

    var $name = 'Post';
    var $validate = array(
        'title' => array(
            'required' => array('rule' => 'notEmpty'),
            'maxlength' => array('rule' => array('maxLength', 30))
        ),
        'body' => array(
            'required' => array('rule' => 'notEmpty'),
            'maxlength' => array('rule' => array('maxLength', 200))
        )
    );

}
