<?php

/**
 * @package     JohnCMS
 * @link        http://johncms.com
 * @copyright   Copyright (C) 2008-2011 JohnCMS Community
 * @license     LICENSE.txt (see attached file)
 * @version     VERSION.txt (see attached file)
 * @author      http://johncms.com/about
 */

defined('_IN_JOHNCMS') or die('Error: restricted access');

$headmod = isset($headmod) ? mysql_real_escape_string($headmod) : '';
$textl = isset($textl) ? $textl : $set['copyright'];

/*
-----------------------------------------------------------------
Выводим HTML заголовки страницы, подключаем CSS файл
Output the HTML page titles, connect the CSS file
-----------------------------------------------------------------
*/
if(stristr(core::$user_agent, "msie") && stristr(core::$user_agent, "windows")){
    // Выдаем заголовки для Internet Explorer
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-type: text/html; charset=UTF-8');
} else {
    // Выдаем заголовки для остальных браузеров
    header("Cache-Control: public");
    header('Content-type: application/xhtml+xml; charset=UTF-8');
}
header("Expires: " . date("r",  time() + 60));
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n" .
     "\n" . '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">' .
     "\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">' .
     "\n" . '<head>' .
     "\n" . '<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8"/>' .
     "\n" . '<meta http-equiv="Content-Style-Type" content="text/css" />' .
     "\n" . '<meta name="Generator" content="JohnCMS, http://johncms.com" />' . // ВНИМАНИЕ!!! Данный копирайт удалять нельзя
     (!empty($set['meta_key']) ? "\n" . '<meta name="keywords" content="' . $set['meta_key'] . '" />' : '') .
     (!empty($set['meta_desc']) ? "\n" . '<meta name="description" content="' . $set['meta_desc'] . '" />' : '') .
     "\n" . '<link rel="stylesheet" href="' . $set['homeurl'] . '/theme/' . $set_user['skin'] . '/style.css" type="text/css" />' .
     "\n" . '<link rel="shortcut icon" href="' . $set['homeurl'] . '/favicon.ico" />' .
     "\n" . '<link rel="alternate" type="application/rss+xml" title="RSS | ' . $lng['site_news'] . '" href="' . $set['homeurl'] . '/rss/rss.php" />' .
     "\n" . '<title>' . $textl . '</title>' .
     "\n" . '</head><body>' . core::display_core_errors() .
	 "\n" . '<table border="0" width="100%" cellspacing="0" id="table1">';

/*
-----------------------------------------------------------------
Рекламный модуль
advertising module
-----------------------------------------------------------------
*/
$cms_ads = array();
if (!isset($_GET['err']) && $act != '404' && $headmod != 'admin') {
    $view = $user_id ? 2 : 1;
    $layout = ($headmod == 'mainpage' && !$act) ? 1 : 2;
    $req = mysql_query("SELECT * FROM `cms_ads` WHERE `to` = '0' AND (`layout` = '$layout' or `layout` = '0') AND (`view` = '$view' or `view` = '0') ORDER BY  `mesto` ASC");
    if (mysql_num_rows($req)) {
        while (($res = mysql_fetch_assoc($req)) !== false) {
            $name = explode("|", $res['name']);
            $name = htmlentities($name[mt_rand(0, (count($name) - 1))], ENT_QUOTES, 'UTF-8');
            if (!empty($res['color'])) $name = '<span style="color:#' . $res['color'] . '">' . $name . '</span>';
            // Если было задано начертание шрифта, то применяем
            $font = $res['bold'] ? 'font-weight: bold;' : false;
            $font .= $res['italic'] ? ' font-style:italic;' : false;
            $font .= $res['underline'] ? ' text-decoration:underline;' : false;
            if ($font) $name = '<span style="' . $font . '">' . $name . '</span>';
            @$cms_ads[$res['type']] .= '<a href="' . ($res['show'] ? functions::checkout($res['link']) : $set['homeurl'] . '/go.php?id=' . $res['id']) . '">' . $name . '</a><br/>';
            if (($res['day'] != 0 && time() >= ($res['time'] + $res['day'] * 3600 * 24)) || ($res['count_link'] != 0 && $res['count'] >= $res['count_link']))
                mysql_query("UPDATE `cms_ads` SET `to` = '1'  WHERE `id` = '" . $res['id'] . "'");
        }
    }
}

/*
-----------------------------------------------------------------
Рекламный блок сайта
Advertising block site
-----------------------------------------------------------------
*/
if (isset($cms_ads[0])) echo $cms_ads[0];

/*
-----------------------------------------------------------------
Выводим логотип и переключатель языков
The logo and switch languages
-----------------------------------------------------------------
*
echo '<table class="header-table"><tr>' .
     '<td valign="bottom"><a href="' . $set['homeurl'] . '"><img src="' . $set['homeurl'] . '/theme/' . $set_user['skin'] . '/images/logo.gif" alt=""/></a></td>' .
     ($headmod == 'mainpage' && count(core::$lng_list) > 1 ? '<td align="right"><a href="' . $set['homeurl'] . '/go.php?lng"><b>' . strtoupper(core::$lng_iso) . '</b></a>&#160;<img src="' . $set['homeurl'] . '/images/flags/' . core::$lng_iso . '.gif" alt=""/>&#160;</td>' : '') .
     '</tr></table>';
*/
echo '<tr class="header"><td colspan="2">' .
		'<a href="' . $set['homeurl'] . '"><img style="margin-top: 8px; border: none;" alt="logo" border="0" src="' . $set['homeurl'] . '/theme/' . $set_user['skin'] . '/images/logo.png"/></a>' .
		'</td></tr>';

/*
-----------------------------------------------------------------
Выводим верхний блок с приветствием
Derive the upper unit with the greeting
-----------------------------------------------------------------
*/
//echo '<div class="header"> ' . $lng['hi'] . ', ' . ($user_id ? '<b>' . $login . '</b>!' : $lng['guest'] . '!') . '</div>';

/*
-----------------------------------------------------------------
Главное меню пользователя
The main user menu
-----------------------------------------------------------------
*
echo '<div class="tmn">' .
     (isset($_GET['err']) || $headmod != "mainpage" || ($headmod == 'mainpage' && $act) ? '<a href=\'' . $set['homeurl'] . '\'>' . $lng['homepage'] . '</a> | ' : '') .
     ($user_id ? '<a href="' . $set['homeurl'] . '/users/profile.php?act=office">' . $lng['personal'] . '</a> | ' : '') .
     ($user_id ? '<a href="' . $set['homeurl'] . '/exit.php">' . $lng['exit'] . '</a>' : '<a href="' . $set['homeurl'] . '/login.php">' . $lng['login'] . '</a> | <a href="' . $set['homeurl'] . '/registration.php">' . $lng['registration'] . '</a> | <a href="' . $set['homeurl'] . '/privacy.php">' . $lng['privacy'] . '</a>') .
     '</div><div class="maintxt">';
*/
$act = $_GET['act'];
$id = $_GET['id'];
switch ($act) {
	case 'type':
		$active = 1;
		break;
	case 'topdownload':
		$active = 3;
		break;
	case 'topevent':
		$active = 4;
		break;
	default:
		$active = 'tab';
		break;
}
$sql_cate_top2 = mysql_query("SELECT `a`.`id`, `a`.`name` FROM `gom_the_loai` as `a` ORDER BY `a`.`order` LIMIT 2");
echo '<tr><td colspan="2"></td></tr>' .
		'<tr><td colspan="2" style="border-top: 1px solid #ffffff; padding: 0;">' .
		'<div class="wrap">' .
		'<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>';
if(mysql_num_rows($sql_cate_top2)) {
	while(($res = mysql_fetch_assoc($sql_cate_top2)) !== false) {
		if(($active == 1) && ($res['id'] == $id))
			echo '<td class="tab-selected"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=type&amp;id='.$res['id'].'">'.$res['name'].'</a></td>';
		else 
			echo '<td class="tab"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=type&amp;id='.$res['id'].'">'.$res['name'].'</a></td>';
	}
}
if ($active == 3)
	echo '<td class="tab-selected"><a href="'.$set['homeurl'].'/gamestore/index.php?act=topdownload">Top tải</a></td>';
else
	echo '<td class="tab"><a href="'.$set['homeurl'].'/gamestore/index.php?act=topdownload">Top tải</a></td>';
if ($active == 4)
	echo '<td class="tab-selected"><a href="'.$set['homeurl'].'/gamestore/index.php?act=topevent">Sự kiện</a></td>';
else
	echo '<td class="tab"><a href="'.$set['homeurl'].'/gamestore/index.php?act=topevent">Sự kiện</a></td>';
echo '</tr></table></div></td></tr>';

/*
 -----------------------------------------------------------------
Search follow name game
-----------------------------------------------------------------
*/
if(isset($_GET['app_game_name']))
	$text_value = $_GET['app_game_name'];
else
	$text_value = '';
echo '<tr><td colspan="2"></td></tr>';
echo '<tr><td colspan="2">
		<form method="get" action="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=search">
		<table width="100%"><tr><td width="20%">Tên game</td>
		<td width="60%"><input type="hidden" id="act" name="act" value="search" /><input type="text" name="app_game_name" id="app_game_name" value="'.$text_value.'" style="width: 90%; border: 2px solid #F79646;" /></td>
		<td width="20%"><input type="submit" name="btn_search" id="btn_search" value="Tìm kiếm" class="button" /></td></tr></table>
		</form>
	 </td></tr>';

/*
 -----------------------------------------------------------------
List category
-----------------------------------------------------------------
*/
$lst_cate = mysql_query("SELECT `a`.`id`, `a`.`name` FROM `gom_danh_muc` AS `a` WHERE `a`.`parent_id` = -1 ORDER BY `a`.`order` LIMIT 6");
if (mysql_num_rows($lst_cate)) {
	echo '<tr><td colspan="2"><table width="100%">';
	echo '<tr><td colspan="2"></td></tr>';
	$i = 0;
	while (($res = mysql_fetch_assoc($lst_cate)) !== false) {
		if($i % 2 == 0) {
			if ($i == 0)
				echo '<tr><td width="50%" align="center" class="category-right-noborder"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=category&amp;id='.$res['id'].'">' . $res['name'] . '</a></td>';
			else
				echo '<tr><td width="50%" align="center" class="category-right"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=category&amp;id='.$res['id'].'">' . $res['name'] . '</a></td>';
		} else {
			if ($i == 1)
				echo '<td width="50%" align="center" class="category-left-noborder"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=category&amp;id='.$res['id'].'">' . $res['name'] . '</a></td></tr>';
			else
				echo '<td width="50%" align="center" class="category-left"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=category&amp;id='.$res['id'].'">' . $res['name'] . '</a></td></tr>';
		}
		$i ++;
	}
	echo '<tr><td colspan="2"></td></tr>';
	echo '</table></td></tr>';
}
