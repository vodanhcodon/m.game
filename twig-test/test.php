<?php

define('_IN_JOHNCMS', 1);
require('../incfiles/core.php');
//require('../incfiles/gom.php');
$gom = new Gom();
$trees_game = $gom->getTreeDanhMuc(1);
$danhmucs = $gom->buildOptsDanhMuc($trees_game);
var_dump($danhmucs);

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
$template = $twig->loadTemplate('gameapp-main.twig');
$template->display(array(
    'danhmucs' => $danhmucs,
));
