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

// Рекламный блок сайта
// Advertising block site
//if (!empty($cms_ads[2]))
//    echo '<div class="gmenu">' . $cms_ads[2] . '</div>';

//echo '</div><div class="fmenu">';
//if ($headmod != "mainpage" || ($headmod == 'mainpage' && $act))
//    echo '<a href="' . $set['homeurl'] . '">' . $lng['homepage'] . '</a><br/>';

// Меню быстрого перехода
// Menu quick transition
// if ($set_user['quick_go']) {
//     echo '<form action="' . $set['homeurl'] . '/go.php" method="post">';
//     echo '<div><select name="adres" style="font-size:x-small">
//     <option selected="selected">' . $lng['quick_jump'] . '</option>
//     <option value="guest">' . $lng['guestbook'] . '</option>
//     <option value="forum">' . $lng['forum'] . '</option>
//     <option value="news">' . $lng['news'] . '</option>
//     <option value="gallery">' . $lng['gallery'] . '</option>
//     <option value="down">' . $lng['downloads'] . '</option>
//     <option value="lib">' . $lng['library'] . '</option>
//     </select><input type="submit" value="Go!" style="font-size:x-small"/>';
//     echo '</div></form>';
// }
// Счетчик посетителей онлайн
// Online visitors counter
//echo '</div><div class="footer">' . counters::online() . '</div>';
//echo '<div class="copyright">';
//echo '<p><b>&copy; Copyright 2012 Vteen.vn</b></p>';

// Form search
if(isset($_GET['advanced_name']))
	$advanced_name = $_GET['advanced_name'];
else
	$advanced_name = '';
if(isset($_GET['advanced_danhmuc']))
	$advanced_danhmuc = $_GET['advanced_danhmuc'];
else
	$advanced_danhmuc = '';
if(isset($_GET['advanced_theloai']))
	$advanced_theloai = $_GET['advanced_theloai'];
else
	$advanced_theloai = '';
echo '<tr><td colspan="2"><form method="get" action="'.$set['homeurl'].'/gamestore/index.php">' . 
		'<table width="100%"><tr><td colspan="2"><span style="font-size: medium; color:red; font-weight: bold;" >Tìm kiếm</span></td></tr>' .
		'<tr><td>Tên game</td><td><input type="hidden" name="act" id="act" value="advanced" /><input type="text" name="advanced_name" id="advanced_name" value="'.$advanced_name.'" style="width: 88%; border: 2px solid #F79646;" /></td></tr>';
$lst_danhmuc = mysql_query("SELECT `a`.`id`, `a`.`name` FROM `gom_danh_muc` as `a` ORDER BY `a`.`order`");
echo '<tr><td>Danh mục</td><td><select name="advanced_danhmuc" id="advanced_danhmuc" style="width: 90%; border: 2px solid #F79646;">';
echo '<option value="">Tất cả</option>';
if (mysql_num_rows($lst_danhmuc)) {
	while (($res_danhmuc = mysql_fetch_assoc($lst_danhmuc)) !== false) {
		if($res_danhmuc['id'] == $advanced_danhmuc)
			echo '<option value="'.$res_danhmuc['id'].'" selected="selected">'.$res_danhmuc['name'].'</option>';
		else 
			echo '<option value="'.$res_danhmuc['id'].'">'.$res_danhmuc['name'].'</option>';
	}
}
echo '</select></td></tr>';
$lst_theloai = mysql_query("SELECT `a`.`id`, `a`.`name` FROM `gom_the_loai` as `a` ORDER BY `a`.`order`");
echo '<tr><td>Thể loại</td><td><select name="advanced_theloai" id="advanced_theloai" style="width: 90%; border: 2px solid #F79646;">';
echo '<option value="">Tất cả</option>';
if (mysql_num_rows($lst_theloai)) {
	while (($res_theloai = mysql_fetch_assoc($lst_theloai)) !== false) {
		if($res_theloai['id'] == $advanced_theloai)
			echo '<option value="'.$res_theloai['id'].'" selected="selected">'.$res_theloai['name'].'</option>';
		else
			echo '<option value="'.$res_theloai['id'].'">'.$res_theloai['name'].'</option>';
	}
}
echo '</select></td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Tìm kiếm" id="search" name="search" class="button" /></td></tr></table>' .
		'</form></td></tr>';
echo '<tr><td colspan="2"><hr /></td></tr>';
echo '<tr><td colspan="2"><table width="100%"><tr>' . 
		'<td align="center"><a href="#" style="">Top hot</a></td>' .  
		'<td align="center"><a href="'.$set['homeurl'].'/gamestore/index.php?act=topdownload">Top tải</a></td>' . 
		'<td align="center"><a href="#">Sự kiện hot</a></td>' . 
		'<td align="center"><a href="#">Diễn đàn</a></td>' . 
		'</tr></table></td></tr>';
echo '<tr><td colspan="2"><hr /></td></tr>';
// Footer
echo '<tr bgcolor="#D9D9D9"><td colspan="2" style="font-size: small; text-align: center"><span style="color:red; font-weight: bold;" >&copy; Copyright 2013 Vteen.vn</span></td></tr>';

// Счетчики каталогов
// counters directory
/**
 * 
functions::display_counters();
*/
// Рекламный блок сайта
// Advertising block site
/**
 * 
if (!empty($cms_ads[3]))
    echo '<br />' . $cms_ads[3];
*/
/*
-----------------------------------------------------------------
ВНИМАНИЕ!!!
Данный копирайт нельзя убирать в течение 60 дней с момента установки скриптов
-----------------------------------------------------------------
ATTENTION!!!
The copyright could not be removed within 60 days of installation scripts
-----------------------------------------------------------------
*/

echo '</table></body></html>';