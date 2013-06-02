<?php

/*
 * các cấu hình thiết lập trong Gom
 */
$config['gom'] = array(
    'sitename' => 'Gom CMS',
    'platform' => array(
        1 => 'j2me non touch',
        2 => 'j2me full touch',
        3 => 'android',
        4 => 'iphone',
        5 => 'winphone',
    ),
    'tmp' => 'tmp/',
    'cmsuser' => array(
        'type' => array(
            1 => 'Tài khoản admin',
            2 => 'Tài khoản thường'
        )
    ),
    'status' => array(
        -1 => 'xóa',
        0 => 'không hiện thị tạm thời',
        1 => 'đang chờ xét duyệt',
        2 => 'công khai'
    ),
    'DanhMuc' => array(
        'type' => array(
            1 => 'GAME',
            2 => 'NEWS',
            3 => 'APP',
            4 => 'AUDIO',
            5 => 'BOOK',
            6 => 'PRODUCT DISTRIBUTION',
        ),
        'folder' => array(
            'dir' => 'danhmuc_images/',
        ),
    ),
    'TheLoai' => array(
    /**
     * thay đổi req
     * BEGIN
     */
//        'type' => array(
//            1 => 'game',
//            2 => 'news',
//            3 => 'app'
//        )
    /**
     * END
     */
    ),
    'GameApp' => array(
        'filesize' => array(
            'jar' => 5,
            'jad' => 5,
            'apk' => 20,
            'img' => 1,
        ),
        'type' => array(
            1 => 'game',
            2 => 'app',
        ),
        'folder' => array(
            'tmp' => 'tmp/',
            'dir' => 'gameapp_files/'
        ),
    ),
    'ProductDistribution' => array(
        'type' => array(
            1 => 'j2me',
            2 => 'android',
            3 => 'iphone',
            4 => 'winphone'
        ),
        'folder' => array(
            'tmp' => 'tmp/',
            'dir' => 'product_files/'
        ),
    ),
    'GameEvent' => array(
        'folder' => array(
            'tmp' => 'tmp/',
            'dir' => 'event_files/'
        ),
    ),
    'News' => array(
        'folder' => array(
            'tmp' => 'tmp/',
            'dir' => 'news_files/'
        ),
    ),
);