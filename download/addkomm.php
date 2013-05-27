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

if ($user_id && !$ban['1'] && !$ban['10'] && ($set['mod_down_comm'] || $rights < 7)) {
    if ($_GET['id'] == "") {
        require_once ("../incfiles/head.php");
        echo "Не выбран файл<br/><a href='?'>К категориям</a><br/>";
        require_once ('../incfiles/end.php');
        exit;
    }
    if (isset ($_POST['submit'])) {
        // Проверка на флуд
        $flood = functions::antiflood();
        if ($flood) {
            require_once ('../incfiles/head.php');
            echo functions::display_error('Вы не можете так часто добавлять сообщения<br />Пожалуйста, подождите ' . $flood . ' сек.', '<a href="index.php?act=komm&amp;id=' . $id . '">Назад</a>');
            require_once ('../incfiles/end.php');
            exit;
        }
        if ($_POST['msg'] == "") {
            require_once ("../incfiles/head.php");
            echo "Вы не ввели сообщение!<br/><a href='?act=komm&amp;id=" . $id . "'>К комментариям</a><br/>";
            require_once ('../incfiles/end.php');
            exit;
        }
        $msg = functions::check($_POST['msg']);
        if ($_POST[msgtrans] == 1) {
            $msg = functions::trans($msg);
        }
        $msg = mb_substr($msg, 0, 500);
        $agn = strtok($agn, ' ');
        mysql_query("insert into `download` values(0,'$id','','" . time() . "','','komm','$login','" . long2ip($ip) . "','" . $agn . "','" . $msg . "','');");
        $fpst = $datauser['komm'] + 1;
        mysql_query("UPDATE `users` SET
		`komm`='" . $fpst . "',
		`lastpost` = '" . time() . "'
		WHERE `id`='" . $user_id . "'");
        header("Location: index.php?act=komm&id=$id");
    }
    else {
        require_once ("../incfiles/head.php");
        echo "Напишите комментарий<br/><br/><form action='?act=addkomm&amp;id=" . $id .
             "' method='post'>
Cообщение(max. 500)<br/>
<textarea rows='3' title='Введите комментарий' name='msg' ></textarea><br/><br/>
<input type='checkbox' name='msgtrans' value='1' title='Поставьте флажок для транслитерации сообщения' /> Транслит<br/>
<input type='submit' title='Нажмите для отправки' name='submit' value='добавить' />
  </form><br/>";
        echo '<a href="index.php?act=trans">Транслит</a><br /><a href="../str/smile.php">' . $lng['smileys'] . '</a><br/>';
    }
}
else {
    require_once ("../incfiles/head.php");
    echo "Вы не авторизованы!<br/>";
}
echo '<br/><br/><a href="?act=komm&amp;id=' . $id . '">К комментариям</a><br/><a href="?act=view&amp;file=' . $id . '">К файлу</a><br/>';

?>