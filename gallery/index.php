<?php

/**
 * @package     JohnCMS
 * @link        http://johncms.com
 * @copyright   Copyright (C) 2008-2011 JohnCMS Community
 * @license     LICENSE.txt (see attached file)
 * @version     VERSION.txt (see attached file)
 * @author      http://johncms.com/about
 */

define('_IN_JOHNCMS', 1);

require('../incfiles/core.php');
$headmod = 'gallery';
$lng_gal = core::load_lng('gallery');
$textl = $lng['gallery'];
require('../incfiles/head.php');

// Ограничиваем доступ к Галерее
$error = '';
if (!$set['mod_gal'] && $rights < 7)
    $error = $lng_gal['gallery_closed'];
elseif ($set['mod_gal'] == 1 && !$user_id)
    $error = $lng['access_guest_forbidden'];
if ($error) {
    require_once('../incfiles/head.php');
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once('../incfiles/end.php');
    exit;
}

$array = array(
    'new',
    'edf',
    'delf',
    'edit',
    'del',
    'load',
    'upl',
    'cral',
    'razd'
);
if (in_array($act, $array) && file_exists($act . '.php')) {
    require_once($act . '.php');
} else {
    if (!$set['mod_gal'])
        echo '<p><font color="#FF0000"><b>' . $lng_gal['gallery_closed'] . '</b></font></p>';
    if ($id) {
        $type = mysql_query("SELECT * FROM `gallery` WHERE `id` = '$id' LIMIT 1");
        $ms = mysql_fetch_assoc($type);
        switch ($ms['type']) {
            case 'rz':
                /*
                -----------------------------------------------------------------
                Просмотр раздела
                -----------------------------------------------------------------
                */
                echo '<div class="phdr"><a href="index.php"><b>' . $lng['gallery'] . '</b></a> | ' . $ms['text'] . '</div>';
                $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `gallery` WHERE `type` = 'al' AND `refid` = '$id'"), 0);
                if ($total) {
                    $req = mysql_query("SELECT * FROM `gallery` WHERE `type` = 'al' AND `refid` = '$id' ORDER BY `time` DESC LIMIT $start, $kmess");
                    while ($res = mysql_fetch_assoc($req)) {
                        echo $i % 2 ? '<div class="list2">' : '<div class="list1">';
                        $total_f = mysql_result(mysql_query("SELECT COUNT(*) FROM `gallery` WHERE `type` = 'ft' AND `refid` = '" . $res['id'] . "'"), 0);
                        echo '<a href="index.php?id=' . $res['id'] . '">' . $res['text'] . '</a> (' . $total_f . ')</div>';
                        ++$i;
                    }
                } else {
                    echo '<div class="menu"><p>' . $lng['list_empty'] . '</p></div>';
                }
                echo '<div class="phdr">' . $lng['total'] . ': ' . $total . '</div><p>';
                if ($total > $kmess) {
                    echo '<p>' . functions::display_pagination('index.php?id=' . $id . '&amp;', $start, $total, $kmess) . '</p>' .
                         '<p><form action="index.php?id=' . $id . '" method="post">' .
                         '<input type="text" name="page" size="2"/>' .
                         '<input type="submit" value="' . $lng['to_page'] . ' &gt;&gt;"/>' .
                         '</form></p>';
                }
                if ($rights >= 6) {
                    echo "<a href='index.php?act=cral&amp;id=" . $id . "'>" . $lng_gal['create_album'] . "</a><br/>";
                    echo "<a href='index.php?act=del&amp;id=" . $id . "'>" . $lng_gal['delete_section'] . "</a><br/>";
                    echo "<a href='index.php?act=edit&amp;id=" . $id . "'>" . $lng_gal['edit_section'] . "</a><br/>";
                }
                echo "<a href='index.php'>В галерею</a></p>";
                break;

            case 'al':
                /*
                -----------------------------------------------------------------
                Просмотр альбома
                -----------------------------------------------------------------
                */
                $delimag = opendir("temp");
                while ($imd = readdir($delimag)) {
                    if ($imd != "." && $imd != ".." && $imd != "index.php") {
                        $im[] = $imd;
                    }
                }
                closedir($delimag);
                $totalim = count($im);
                for ($imi = 0; $imi < $totalim; $imi++) {
                    $filtime[$imi] = filemtime("temp/$im[$imi]");
                    $tim = time();
                    $ftime1 = $tim - 10;
                    if ($filtime[$imi] < $ftime1) {
                    }
                }
                $rz = mysql_query("select * from `gallery` where type='rz' and  id='" . $ms['refid'] . "';");
                $rz1 = mysql_fetch_array($rz);
                echo '<div class="phdr"><a href="index.php"><b>' . $lng['gallery'] . '</b></a> | <a href="index.php?id=' . $ms['refid'] . '">' . $rz1['text'] . '</a> | ' . $ms['text'] . '</div>';
                $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `gallery` WHERE `type` = 'ft' AND `refid` = '$id'"), 0);
                $req = mysql_query("SELECT * FROM `gallery` WHERE `type` = 'ft' AND `refid` = '$id' ORDER BY `time` DESC LIMIT $start, $kmess");
                while ($fot1 = mysql_fetch_array($req)) {
                    echo $i % 2 ? '<div class="list2">' : '<div class="list1">';
                    if (file_exists('foto/' . $fot1['name'])) {
                        echo '<a href="index.php?id=' . $fot1['id'] . '">';
                        $infile = "foto/$fot1[name]";
                        if (!empty($_SESSION['frazm'])) {
                            $razm = $_SESSION['frazm'];
                        } else {
                            $razm = 50;
                        }
                        $sizs = GetImageSize($infile);
                        $width = $sizs[0];
                        $height = $sizs[1];
                        $quality = 80;
                        $x_ratio = $razm / $width;
                        $y_ratio = $razm / $height;
                        if (($width <= $razm) && ($height <= $razm)) {
                            $tn_width = $width;
                            $tn_height = $height;
                        } else if (($x_ratio * $height) < $razm) {
                            $tn_height = ceil($x_ratio * $height);
                            $tn_width = $razm;
                        } else {
                            $tn_width = ceil($y_ratio * $width);
                            $tn_height = $razm;
                        }
                        $format = functions::format($infile);
                        switch ($format) {
                            case "gif":
                                $im = ImageCreateFromGIF($infile);
                                break;

                            case "jpg":
                                $im = ImageCreateFromJPEG($infile);
                                break;

                            case "jpeg":
                                $im = ImageCreateFromJPEG($infile);
                                break;

                            case "png":
                                $im = ImageCreateFromPNG($infile);
                                break;
                        }
                        $im1 = imagecreatetruecolor($tn_width, $tn_height);
                        $namefile = "$fot1[name]";
                        imagecopyresized($im1, $im, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);
                        switch ($format) {
                            case "gif":
                                $imagnam = "temp/$namefile.temp.gif";
                                ImageGif($im1, $imagnam, $quality);
                                echo "<img src='" . $imagnam . "' alt=''/><br/>";
                                break;

                            case "jpg":
                                $imagnam = "temp/$namefile.temp.jpg";
                                imageJpeg($im1, $imagnam, $quality);
                                echo "<img src='" . $imagnam . "' alt=''/><br/>";
                                break;

                            case "jpeg":
                                $imagnam = "temp/$namefile.temp.jpg";
                                imageJpeg($im1, $imagnam, $quality);
                                echo "<img src='" . $imagnam . "' alt=''/><br/>";

                                break;

                            case "png":
                                $imagnam = "temp/$namefile.temp.png";
                                imagePng($im1, $imagnam, $quality);
                                echo "<img src='" . $imagnam . "' alt=''/><br/>";

                                break;
                        }
                        imagedestroy($im);
                        imagedestroy($im1);
                        $fotsz = filesize("foto/$ms[name]");
                        echo '</a>';
                        if (!empty($fot1['text']))
                            echo "$fot1[text]<br/>";
                        if ($rights >= 6) {
                            echo "<a href='index.php?act=edf&amp;id=" . $fot1['id'] . "'>" . $lng['edit'] . "</a> | <a href='index.php?act=delf&amp;id=" . $fot1['id'] . "'>" . $lng['delete'] . "</a><br/>";
                        }
                    } else {
                        echo $lng_gal['image_missing'] . '<br /><a href="index.php?act=delf&amp;id=' . $fot1['id'] . '">' . $lng['delete'] . '</a>';
                    }
                    echo "</div>";
                    ++$i;
                }
                echo '<div class="phdr">' . $lng['total'] . ': ' . $total . '</div><p>';
                if ($total > $kmess) {
                    echo '<p>' . functions::display_pagination('index.php?id=' . $id . '&amp;', $start, $total, $kmess) . '</p>' .
                         '<p><form action="index.php?id=' . $id . '" method="post">' .
                         '<input type="text" name="page" size="2"/>' .
                         '<input type="submit" value="' . $lng['to_page'] . ' &gt;&gt;"/>' .
                         '</form></p>';
                }
                if (($user_id && $rz1['user'] == 1 && $ms['text'] == $login && !$ban['1'] && !$ban['14']) || $rights >= 6) {
                    echo '<a href="index.php?act=upl&amp;id=' . $id . '">' . $lng_gal['upload_photo'] . '</a><br/>';
                }
                if ($rights >= 6) {
                    echo "<a href='index.php?act=del&amp;id=" . $id . "'>" . $lng_gal['delete_album'] . "</a><br/>";
                    echo "<a href='index.php?act=edit&amp;id=" . $id . "'>" . $lng_gal['edit_album'] . "</a><br/>";
                }
                echo "<a href='index.php'>" . $lng_gal['to_gallery'] . "</a></p>";
                break;

            case 'ft':
                /*
                -----------------------------------------------------------------
                Просмотр фото
                -----------------------------------------------------------------
                */
                echo "<br/>&#160;";
                $infile = "foto/$ms[name]";
                if (!empty($_SESSION['frazm'])) {
                    $razm = $_SESSION['frazm'];
                } else {
                    $razm = 50;
                }
                $sizs = GetImageSize($infile);
                $width = $sizs[0];
                $height = $sizs[1];
                $quality = 85;
                $format = functions::format($infile);
                switch ($format) {
                    case "gif":
                        $im = ImageCreateFromGIF($infile);
                        break;

                    case "jpg":
                        $im = ImageCreateFromJPEG($infile);
                        break;

                    case "jpeg":
                        $im = ImageCreateFromJPEG($infile);
                        break;

                    case "png":
                        $im = ImageCreateFromPNG($infile);
                        break;
                }
                $im1 = imagecreatetruecolor($width, $height);
                $namefile = "$ms[name]";
                imagecopy($im1, $im, 0, 0, 0, 0, $width, $height);
                switch ($format) {
                    case "gif":
                        $imagnam = "temp/$namefile.gif";
                        ImageGif($im1, $imagnam, $quality);
                        echo "<img src='" . $imagnam . "' alt=''/><br/>";
                        break;

                    case "jpg":
                        $imagnam = "temp/$namefile.jpg";
                        imageJpeg($im1, $imagnam, $quality);
                        echo "<img src='" . $imagnam . "' alt=''/><br/>";
                        break;

                    case "jpeg":
                        $imagnam = "temp/$namefile.jpg";
                        imageJpeg($im1, $imagnam, $quality);
                        echo "<img src='" . $imagnam . "' alt=''/><br/>";

                        break;

                    case "png":
                        $imagnam = "temp/$namefile.png";
                        imagePng($im1, $imagnam, $quality);
                        echo "<img src='" . $imagnam . "' alt=''/><br/>";

                        break;
                }
                imagedestroy($im);
                imagedestroy($im1);
                $fotsz = filesize("foto/$ms[name]");
                $fotsz = round($fotsz / 1024, 2);
                $sizs = GetImageSize("foto/$ms[name]");
                $fwidth = $sizs[0];
                $fheight = $sizs[1];
                echo "<p>" . $lng['description'] . ": $ms[text]<br/>";
                echo $lng_gal['dimensions'] . ": $fwidth*$fheight px.<br/>";
                echo $lng_gal['weight'] . ": $fotsz kb.<br/>";
                echo $lng['date'] . ': ' . functions::display_date($ms['time']) . '<br/>';
                echo $lng_gal['posted_by'] . ": $ms[avtor]<br/>";
                echo "<a href='foto/$ms[name]'>" . $lng['download'] . "</a><br /><br />";
                echo "<a href='index.php?id=" . $ms['refid'] . "'>" . $lng['back'] . "</a><br/>";
                echo "<a href='index.php'>" . $lng_gal['to_gallery'] . "</a></p>";
                break;
            default :
                header("location: index.php");
                break;
        }
    } else {
        /*
        -----------------------------------------------------------------
        Главная страница Галлереи
        -----------------------------------------------------------------
        */
        echo '<p><a href="index.php?act=new">' . $lng_gal['new_photo'] . '</a> (' . counters::gallery(1) . ')</p>';
        echo '<div class="phdr"><b>' . $lng['gallery'] . '</b></div>';
        $req = mysql_query("SELECT * FROM `gallery` WHERE `type` = 'rz'");
        $total = mysql_num_rows($req);
        while ($res = mysql_fetch_assoc($req)) {
            echo $i % 2 ? '<div class="list2">' : '<div class="list1">';
            $al = mysql_query("select * from `gallery` where type='al' and  refid='" . $res['id'] . "'");
            $countal = mysql_num_rows($al);
            echo '<a href="index.php?id=' . $res['id'] . '">' . $res['text'] . '</a> (' . $countal . ')</div>';
            ++$i;
        }
        echo '<div class="phdr">' . $lng['total'] . ': ' . $total . '</div><p>';
        if ($rights >= 6) {
            echo "<a href='index.php?act=razd'>" . $lng_gal['create_section'] . "</a><br/>";
        }
        echo "</p>";
    }
}

require('../incfiles/end.php');
?>