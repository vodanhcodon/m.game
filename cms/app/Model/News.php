<?php

App::uses('AppModel', 'Model');

class News extends AppModel {

    public $useTable = 'news';
    public $actsAs = array('Containable');
    public $validate = array(
        'title' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
        'short_body' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
        'body' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Đây là trường bắt buộc'
            ),
        ),
    );
    public $hasMany = array(
        'NewsImage' => array(
            'className' => 'NewsImage',
            'conditions' => array(
                'NewsImage.news_id = {$__cakeID__$}'
            ),
            // trong định nghĩa hasMany thì đây là 1 trường quan trọng,
            // dùng để xác định rõ kết nối quan hệ giữa bảng chủ và bảng kết nối
            // khi định nghĩa rõ ràng mối quan hệ thì khi lưu theo kiểu saveAll sẽ nhẹ nhàng hơn
            'foreignKey' => 'news_id',
        ),
        'TheLoaiRelation' => array(
            'className' => 'TheLoaiRelation',
            'conditions' => array(
                'TheLoaiRelation.news_id = {$__cakeID__$}',
//                'TheLoaiRelation.status' => 2,
            ),
            'foreignKey' => 'the_loai_id',
        ),
    );
    public $belongsTo = array(
        'DanhMuc' => array(
            'className' => 'DanhMuc',
            'conditions' => array(
                'News.danh_muc_id = DanhMuc.id',
//                'DanhMuc.status' => 2,
            ),
            'foreignKey' => false,
        ),
        'ProductDistribution' => array(
            'className' => 'ProductDistribution',
            'conditions' => array(
                'ProductDistribution.id = News.product_distribution_id',
//                'ProductDistribution.status' => 2,
            ),
            'foreignKey' => false,
        ),
    );

}