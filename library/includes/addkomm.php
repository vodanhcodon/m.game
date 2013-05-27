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

if ($user_id && !$ban['1'] && !$ban['10'] && ($set['mod_lib_comm'] || $rights >= 7)) {
    if (!$id) {
        echo "";
        require_once('../incfiles/end.php');
        exit;
    }
    $req = mysql_query("SELECT `name` FROM `lib` WHERE `type` = 'bk' AND `id` = '" . $id . "' LIMIT 1");
    if (mysql_num_rows($req) != 1) {
        // если статья не существует, останавливаем скрипт
        echo '<p>ERROR<br/><a href="../index.php">Back</a></p>';
        require_once('../incfiles/end.php');
        exit;
    }
    // Проверка на флуд
    $flood = functions::antiflood();
    if ($flood) {
        require_once('../incfiles/head.php');
        echo functions::display_error($lng['error_flood'] . ' ' . $flood . ' ' . $lng['sec'], '<a href="?act=komm&amp;id=' . $id . '">' . $lng['back'] . '</a>');
        require_once('../incfiles/end.php');
        exit;
    }
    if (isset($_POST['submit'])) {
        if ($_POST['msg'] == "") {
            echo $lng['error_empty_message'] . "<br/><a href='index.php?act=komm&amp;id=" . $id . "'>" . $lng['back'] . "</a><br/>";
            require_once('../incfiles/end.php');
            exit;
        }
        $msg = functions::check($_POST['msg']);
        if ($_POST['msgtrans'] == 1) {
            $msg = functions::trans($msg);
        }
        $msg = mb_substr($msg, 0, 500);
        $agn = strtok($agn, ' ');
        mysql_query("INSERT INTO `lib` SET
            `refid` = '" . $id . "',
            `time` = '" . time() . "',
            `type` = 'komm',
            `avtor` = '" . $login . "',
            `count` = '" . $user_id . "',
            `text` = '" . $msg . "',
            `ip` = '" . $ip . "',
            `soft` = '" . mysql_real_escape_string($agn) . "'
        ");
        $fpst = $datauser['komm'] + 1;
        mysql_query("UPDATE `users` SET
            `komm`='" . $fpst . "',
            `lastpost` = '" . time() . "'
            WHERE `id`='" . $user_id . "'
        ");
        echo '<p>' . $lng_lib['comment_added'] . '<br />';
    } else {
        echo "<p>" . $lng_lib['write_comment'] . "<br/><br/><form action='?act=addkomm&amp;id=" . $id . "' method='post'>
        " . $lng['message'] . "<br/><textarea rows='3' name='msg'></textarea><br/><br/>
        <input type='checkbox' name='msgtrans' value='1' /> " . $lng['translit'] . "<br/>
        <input type='submit' name='submit' value='добавить' />
        </form><br/>";
        echo '<a href="index.php?act=trans">' . $lng['translit'] . '</a><br /><a href="../str/smile.php">' . $lng['smileys'] . '</a><br/>';
    }
    echo '<a href="?act=komm&amp;id=' . $id . '">' . $lng_lib['to_comments'] . '</a></p>';
} else {
    echo "<p>ERROR</p>";
}

?>