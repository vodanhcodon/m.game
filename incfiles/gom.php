<?php

defined('_IN_JOHNCMS') or die('Restricted access');

class Gom {

    public $pdo;

    public function __construct() {
        $this->db_connect();
    }

    public function getTreeDanhMuc($type = null) {
        $query = '
            SELECT 
            `DanhMuc`.`id`, `DanhMuc`.`name`, `DanhMuc`.`status`, `DanhMuc`.`parent_id`, `DanhMuc`.`order` 
            FROM `gom_danh_muc` AS `DanhMuc` 
            WHERE 1 = 1 
            ';
        if (!empty($type)) {
            $query .= 'AND `DanhMuc`.`type` = ' . $type;
        }
        $query .= ' ORDER BY `DanhMuc`.`order` ASC ';

        $find_danh_muc = $this->pdo->query($query);
        $find_danh_muc->setFetchMode(PDO::FETCH_ASSOC);
        $danhmuc = $find_danh_muc->fecthAll();

        $childs = array();

        if (!empty($danhmuc)) {

            // thực hiện chuyển đổi mảng array đa chiều thành mảng chứa đối tượng stdclass
            foreach ($danhmuc as $key => $item) {
                $danhmuc[$key] = (object) $item;
            }
            unset($item);
            unset($key);

            //thực hiện cấu trúc hóa cây tree danh mục dựa vào parent_id và id
            /**
             * BEGIN
             */
            foreach ($danhmuc as $item) {
                $childs[$item->parent_id][] = $item;
            }
            unset($item);
            foreach ($danhmuc as $item) {
                if (isset($childs[$item->id])) {
                    $item->childs = $childs[$item->id];
                }
            }
            unset($item);
            /**
             * END
             */
        }
    }

    private function db_connect() {
        require('db.php');
        var_dump($db_host);
        $db_host = isset($db_host) ? $db_host : 'localhost';
        $db_user = isset($db_user) ? $db_user : '';
        $db_pass = isset($db_pass) ? $db_pass : '';
        $db_name = isset($db_name) ? $db_name : '';
        $connect = @mysql_connect($db_host, $db_user, $db_pass) or die('Error: cannot connect to database server');
        @mysql_select_db($db_name) or die('Error: specified database does not exist');
        @mysql_query("SET NAMES 'utf8'", $connect);

        // khởi tạo và gán đối tượng PDO dùng để kết nối Database vào trong thuộc tính self::$pdo
        // dựa vào các thông số cài đặt trong db.php
        try {
            $this->pdo = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=UTF-8', $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}

?>
