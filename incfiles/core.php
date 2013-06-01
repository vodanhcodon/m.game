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
// Error_Reporting(E_ALL & ~E_NOTICE);
@ini_set('session.use_trans_sid', '0');
@ini_set('arg_separator.output', '&amp;');
date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');
$rootpath = isset($rootpath) ? $rootpath : '../';

/*
  -----------------------------------------------------------------
  Автозагрузка Классов
  -----------------------------------------------------------------
 */
spl_autoload_register('autoload');

function autoload($name) {
    global $rootpath;
    $file = $rootpath . 'incfiles/classes/' . $name . '.php';
    if (file_exists($file))
        require_once($file);
}

/*
  -----------------------------------------------------------------
  Инициализируем Ядро системы
  -----------------------------------------------------------------
 */
$core = new core() or die('Error: Core System');
unset($core);

/*
  -----------------------------------------------------------------
  Получаем системные переменные
  -----------------------------------------------------------------
 */
$ip = core::$ip;                                          // Адрес IP
$agn = core::$user_agent;                                 // User Agent
$set = core::$system_set;                                 // Системные настройки
$lng = core::$lng;                                        // Фразы языка
$is_mobile = core::$is_mobile;                            // Определение мобильного браузера
$home = $set['homeurl'];                                  // Домашняя страница
/*
  -----------------------------------------------------------------
  Tích hợp vào nhân core PDO, Cách nhận biết thiết bị, Twig templates
  -----------------------------------------------------------------
 */
// khởi tạo đối tượng PDO dùng để kết nối database
$pdo = core::$pdo;

// lấy về thông tin thiết bị device đang truy cập hiện tại
$deviceInfo = core::getDeviceInfo();

// lấy về đối tượng template: $twig object
$twig = core::getTwig();

// khởi tạo đối tượng Gom - xử lý nghiệp vụ cho Gom system
$gom = new Gom($pdo) or die('Error: Gom System');

// lấy về đối tượng memcache
//$memcache = core::memCache();
//$memCached = core::memCached();
/*
  -----------------------------------------------------------------
  kết thúc đoạn tích hợp
  -----------------------------------------------------------------
 */

/*
  -----------------------------------------------------------------
  Получаем пользовательские переменные
  -----------------------------------------------------------------
 */
$user_id = core::$user_id;                                // Идентификатор пользователя
$rights = core::$user_rights;                             // Права доступа
$datauser = core::$user_data;                             // Все данные пользователя
$set_user = core::$user_set;                              // Пользовательские настройки
$ban = core::$user_ban;                                   // Бан
$login = isset($datauser['name']) ? $datauser['name'] : false;
$kmess = $set_user['kmess'] > 4 && $set_user['kmess'] < 100 ? $set_user['kmess'] : 10;

/*
  -----------------------------------------------------------------
  Получаем и фильтруем основные переменные для системы
  -----------------------------------------------------------------
 */
$id = isset($_REQUEST['id']) ? abs(intval($_REQUEST['id'])) : false;
$user = isset($_REQUEST['user']) ? abs(intval($_REQUEST['user'])) : false;
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
$mod = isset($_REQUEST['mod']) ? trim($_REQUEST['mod']) : '';
$do = isset($_REQUEST['do']) ? trim($_REQUEST['do']) : false;
$page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? intval($_REQUEST['page']) : 1;
$start = isset($_REQUEST['page']) ? $page * $kmess - $kmess : (isset($_GET['start']) ? abs(intval($_GET['start'])) : 0);
$headmod = isset($headmod) ? $headmod : '';

/*
  -----------------------------------------------------------------
  Показываем Дайджест
  -----------------------------------------------------------------
 */
if ($user_id && $datauser['lastdate'] < (time() - 3600) && $set_user['digest'] && $headmod == 'mainpage')
    header('Location: ' . $set['homeurl'] . '/index.php?act=digest&last=' . $datauser['lastdate']);

/*
  -----------------------------------------------------------------
  Буфферизация вывода
  -----------------------------------------------------------------
 */
if (!isset($set['gzip'])) {
    mysql_query("INSERT INTO `cms_settings` SET `key` = 'gzip', `val` = '1'");
    $set['gzip'] = 1;
}
if ($set['gzip'] && @extension_loaded('zlib')) {
    @ini_set('zlib.output_compression_level', 3);
    ob_start('ob_gzhandler');
} else {
    ob_start();
}