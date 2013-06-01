<?php

define('_IN_JOHNCMS', 1);
require('../incfiles/core.php');
require('../incfiles/vendor/Pager/Pager.php');

// khởi tạo đối tượng $gom 
$gom = new Gom();

// lấy về danh sách danh mục dựa trên sự phân cấp trong database
/**
 * BEGIN
 */
$trees_game = $gom->getTreeDanhMuc(array(1, 3));
$danh_muc = $gom->buildOptsDanhMuc($trees_game);
array_unshift($danh_muc, 'Tất cả');
/**
 * END
 */
// lấy về danh sách GameApp dựa trên thiết bị đang truy cập
/**
 * BEGIN
 */
$game_app = array();
if ($deviceInfo) {
    $model_name = $deviceInfo['deviceModel'];
    $game_app = $gom->getGameApp($model_name);

    // lấy về download_link dựa vào nền tảng mà thiết bị hỗ trợ
    // nếu thiết bị hỗ trợ j2me, thì trả về download_link là path tới jar file
    if ($deviceInfo['j2meSupport']) {
        foreach ($game_app as $key => $value) {
            $game_app[$key]['download_link'] = $value['j2me_jar_file_path'];
        }
    }
    // nếu thiết bị có OS là android, thì trả về download_link là path tới apk file
    elseif ($deviceInfo['deviceOS'] == 'android') {
        foreach ($game_app as $key => $value) {
            $game_app[$key]['download_link'] = $value['android_apk_file_path'];
        }
    }
}
/**
 * END
 */
// lấy về danh sách thể loại
/**
 * BEGIN
 */
$the_loai = $gom->getTheLoai();
array_unshift($the_loai, 'Tất cả');

/**
 * END
 */
// thực hiện xử lý phân trang
/**
 * BEGIN
 */
// khởi tạo thiết lập cấu hình
$params = array(
    'itemData' => $game_app, // mảng array dữ liệu cần phân trang
    'perPage' => 5, // số phần tử trên 1 trang
    'delta' => 8, // for 'Jumping'-style a lower number is better
    'append' => true,
    //'separator' => ' | ',
    'clearIfVoid' => false,
    'urlVar' => 'entrant',
    'useSessions' => true,
    'closeSession' => true,
    'mode' => 'Sliding', //try switching modes
//    'mode' => 'Jumping',
);
$pager = & Pager::factory($params);
$page_data = $pager->getPageData(); // lấy về dữ liệu được phân tách ra trong trang page hiện tại
$links = $pager->getLinks(); // lấy về các links điều hướng cho phân trang
/**
 * END
 */
//$selectBox = $pager->getPerPageSelectBox();
//print_r($page_data);
//echo $links['all'];
//$getDanhMuc = $dbConnectObj->prepare(
//        '
//            SELECT
//                 DanhMuc.id,
//                 DanhMuc.name,
//                 COUNT(GameApp.id) AS games
//            FROM
//                 gom_danh_muc AS DanhMuc
//            LEFT JOIN 
//                 gom_game_app AS GameApp ON (
//                 DanhMuc.id = GameApp.danh_muc_id
//                 )
//            WHERE DanhMuc.type = :type
//            GROUP BY DanhMuc.id
//            HAVING COUNT(GameApp.id) > 0
//            LIMIT :init, :end
//          
//    '
//);
//
//$getDanhMuc->bindValue(':type', 1, PDO::PARAM_INT);
//$getDanhMuc->bindValue(':init', 0, PDO::PARAM_INT);
//$getDanhMuc->bindValue(':end', 6, PDO::PARAM_INT);
//$getDanhMuc->execute();
//$getDanhMuc->setFetchMode(PDO::FETCH_ASSOC);
//$danhmucs = $getDanhMuc->fetchAll();
//var_dump($danhmucs);
// đẩy dữ liệu ra view 
/**
 * BEGIN
 */
$template = $twig->loadTemplate('gameapp-main.twig');
$template->display(array(
    'danh_muc' => $danh_muc,
    'the_loai' => $the_loai,
    'page_data' => $page_data,
    'links' => $links,
));
/**

 * END
 */