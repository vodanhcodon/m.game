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

$mp = new mainpage();
$src = $_GET['src'];

/*
  -----------------------------------------------------------------
  Game store
  -----------------------------------------------------------------
 */
$lst_all_cate = mysql_query("SELECT `a`.`id` FROM `gom_danh_muc` AS `a` WHERE `a`.`parent_id` = 0 ORDER BY `a`.`order`");
if (mysql_num_rows($lst_all_cate) == 1) {
    
} else {
    //max displayed per page
    $per_page = 3;
    // count records
    $count_record = mysql_num_rows(mysql_query("SELECT `a`.`id` FROM `gom_danh_muc` AS `a` WHERE `a`.`parent_id` = 0 ORDER BY `a`.`order`"));
    // count max pages
    $max_pages = ceil($count_record / $per_page);
    // current page
    if (isset($_GET['page']))
        $current_page = $_GET['page'];
    else
        $current_page = 1;
    $str_sql = "SELECT `a`.`id`, `a`.`name` FROM `gom_danh_muc` AS `a` WHERE `a`.`parent_id` = 0 ORDER BY `a`.`order` LIMIT " . $per_page * ($current_page - 1) . ", " . $per_page;
    $lst_cate_top3 = mysql_query($str_sql);
    if (mysql_num_rows($lst_cate_top3)) {
        while (($res_cate = mysql_fetch_assoc($lst_cate_top3)) !== false) {
            echo '<tr><td colspan="2" class="danhmuc">' . $res_cate['name'] . '</td></tr>';
            echo '<tr height="8px;"><td colspan="2"></td></tr>';
            $lst_game_app_top9 = mysql_query("
                SELECT `a`.`id`, `a`.`logo`, `a`.`name`, `a`.`j2me_jad_file_path`, 
			           `a`.`j2me_jar_file_path`, `a`.`android_apk_file_path`, `a`.`short_decription`
		        FROM `gom_game_app` as `a`
				WHERE 
                       `a`.`danh_muc_id` = '" . $res_cate['id'] . "' 
                AND 
                       `a`.status = 2 
                AND
                       LOWER(`a`.`device_support`) LIKE '%" . $deviceInfo['deviceModel'] . "%' 
                ORDER BY 
                       `a`.`last_update` LIMIT 9"
            );
            $i = 0;
            while (($res_app = mysql_fetch_assoc($lst_game_app_top9)) !== false) {
                if ($i < 3) {
                    functions::thumbnail_item_game_app($res_app, $src, $deviceInfo, $set);
                } else {
                    if ($i == 3) {
                        echo '<tr><td colspan="2">';
                        echo '<a href="' . $set['homeurl'] . '/gamestore/index.php?src=' . $src . '&amp;act=detail&amp;id=' . $res_app['id'] . '">' . $res_app['name'] . '</a>';
                    }
                    echo ', <a href="' . $set['homeurl'] . '/gamestore/index.php?src=' . $src . '&amp;act=detail&amp;id=' . $res_app['id'] . '">' . $res_app['name'] . '</a>';
                    if ($i == 8) {
                        echo ' <a href="' . $set['homeurl'] . '/gamestore/index.php?src=' . $src . '&amp;act=category&amp;id=' . $res_cate['id'] . '">Xem tất cả</a></td></tr>';
                        echo '<tr height="8px;"><td colspan="2"></td></tr>';
                    }
                }
                $i++;
            }
            if ($i <= 3)
                echo '<tr><td colspan="2">';
            if ($i < 8) {
                echo ' <a href="' . $set['homeurl'] . '/gamestore/index.php?src=' . $src . '&amp;act=category&amp;id=' . $res_cate['id'] . '">Xem tất cả</a></td></tr>';
                echo '<tr height="8px;"><td colspan="2"></td></tr>';
            }
        }
        /*
          -----------------------------------------------------------------
          Paging block
          -----------------------------------------------------------------
         */
        echo '<tr><td colspan="2"><hr /></td></tr>';
        echo '<tr><td colspan="2">Đến trang';
        for ($i = 1; $i <= $max_pages; $i++) {
            if ($current_page != $i)
                echo ' <a href="' . $set['homeurl'] . '/index.php?src=' . $src . '&amp;page=' . $i . '">' . $i . '</a> ';
            else
                echo " " . $i . " ";
        }
        echo '</td></tr>';
        echo '<tr><td colspan="2"><hr /></td></tr>';
    }
}

/*
  -----------------------------------------------------------------
  Блок информации - The information block
  -----------------------------------------------------------------
 *
  echo '<div class="menu-wrapper">';
  echo '<div class="phdr"><b>' . $lng['information'] . '</b></div>';
  echo $mp->news;
  echo '<div class="menu"><a href="news/index.php">' . $lng['news_archive'] . '</a> (' . $mp->newscount . ')</div>' .
  '<div class="menu"><a href="pages/faq.php">' . $lng['information'] . ', FAQ</a></div>';
  echo '</div>';
  /*
  -----------------------------------------------------------------
  Блок общения - block communication
  -----------------------------------------------------------------
 *
  echo '<div class="menu-wrapper">';
  echo '<div class="phdr"><b>' . $lng['dialogue'] . '</b></div>';
  // Ссылка на гостевую
  if ($set['mod_guest'] || $rights >= 7)
  echo '<div class="menu"><a href="guestbook/index.php">' . $lng['guestbook'] . '</a> (' . counters::guestbook() . ')</div>';
  // Ссылка на Форум
  if ($set['mod_forum'] || $rights >= 7)
  echo '<div class="menu"><a href="forum/">' . $lng['forum'] . '</a> (' . counters::forum() . ')</div>';
  echo '</div>';
  /*
  -----------------------------------------------------------------
  Блок полезного - Block useful
  -----------------------------------------------------------------
 *    
  echo '<div class="menu-wrapper">';
  echo '<div class="phdr"><b>' . $lng['useful'] . '</b></div>';
  // Ссылка на загрузки
  if ($set['mod_down'] || $rights >= 7)
  echo '<div class="menu"><a href="download/">' . $lng['downloads'] . '</a> (' . counters::downloads() . ')</div>';
  // Ссылка на библиотеку
  if ($set['mod_lib'] || $rights >= 7)
  echo '<div class="menu"><a href="library/">' . $lng['library'] . '</a> (' . counters::library() . ')</div>';
  // Ссылка на библиотеку
  if ($set['mod_gal'] || $rights >= 7)
  echo '<div class="menu"><a href="gallery/">' . $lng['gallery'] . '</a> (' . counters::gallery() . ')</div>';
  if ($user_id || $set['active']) {
  echo '<div class="phdr"><b>' . $lng['community'] . '</b></div>' .
  '<div class="menu"><a href="users/index.php">' . $lng['users'] . '</a> (' . counters::users() . ')</div>' .
  '<div class="menu"><a href="users/album.php">' . $lng['photo_albums'] . '</a> (' . counters::album() . ')</div>';
  }
  echo '</div>';
 */
?>
