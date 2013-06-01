<?php

defined('_IN_JOHNCMS') or die('Restricted access');

class Gom {

    public $pdo;
    public static $root = '../';

    public function __construct() {
        $this->db_connect();
    }

    /**
     * getTreeDanhMuc action
     * lấy ra danh sách các danh mục, và cấu trúc hóa cây danh mục sang dạng stdclass
     * 
     * @param int $type
     * @return array $object - có dạng như sau

      stdClass Object
      (
      [id] => 1
      [parent_id] => 0
      [childs] => Array
      (
      [0] => stdClass Object
      (
      [id] => 42
      [parent_id] => 1
      [childs] => Array
      (
      [0] => stdClass Object
      (
      [id] => 43
      [parent_id] => 42
      )

      )

      )

      )

      )
     * 
     */
    public function getTreeDanhMuc($type = null) {
        $query = '
            SELECT 
            DanhMuc.id, DanhMuc.name, DanhMuc.status, DanhMuc.parent_id, DanhMuc.order 
            FROM gom_danh_muc AS DanhMuc 
            WHERE 1 = 1 AND DanhMuc.status = 2
            ';
        if (!empty($type)) {
            if (!is_array($type)) {
                $query .= 'AND DanhMuc.type = ?';
            } else {
                $inQuery = implode(',', array_fill(0, count($type), '?'));
                $query .= 'AND DanhMuc.type IN (' . $inQuery . ') ';
            }
        }
        $query .= ' ORDER BY DanhMuc.order ASC ';

        $find_danh_muc = $this->pdo->prepare($query);
        $find_danh_muc->execute($type);
        $find_danh_muc->setFetchMode(PDO::FETCH_ASSOC);
        $danhmuc = $find_danh_muc->fetchAll();

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

            return isset($childs[0]) ? $childs[0] : array();
            /**
             * END
             */
        }
    }

    /**
     * buildOptsDanhMuc method
     * xây dựng các nhãn Options cho selectbox, có thể nhìn thấy được phân cấp trong danh mục
     * @param array $trees - mảng có cấu trúc được trả về từ getTreeDanhMuc action
     * @see getTreeDanhMuc action
     * @return array
     */
    public function buildOptsDanhMuc($trees) {
        $arrayiter = new RecursiveArrayIterator($trees);
        $iteriter = new RecursiveIteratorIterator($arrayiter);
        $list = array();
        foreach ($iteriter as $key => $value) {
            $id = $iteriter->current();
            $iteriter->next();

            $depth = $iteriter->getDepth();
            $name = $iteriter->current();
            $iteriter->next();

            $label = str_repeat('-', $depth - 1) . $name;
            $iteriter->next();

            $list[$id] = $label;
            $iteriter->next();
        }
        return $list;
    }

    /**
     * getTheLoai lấy về danh sách tất cả các thể loại
     * @return array
     */
    public function getTheLoai() {
        $query = '
            SELECT `TheLoai`.`id`, `TheLoai`.`name`, 
            `TheLoai`.`description`, `TheLoai`.`order`, 
            `TheLoai`.`forum_link`, `TheLoai`.`created_date`, 
            `TheLoai`.`last_update`, `TheLoai`.`status`, `TheLoai`.`danh_muc_id` 
            FROM `gom`.`gom_the_loai` AS `TheLoai` 
            WHERE 1 = 1 
            AND `TheLoai`.`status` = 2
            ORDER BY `TheLoai`.`order` ASC 
            ';
        $find_the_loai = $this->pdo->query($query);
        $find_the_loai->setFetchMode(PDO::FETCH_ASSOC);
        $theloai = $find_the_loai->fetchAll();
        $list_the_loai = array();
        foreach ($theloai as $v) {
            $list_the_loai[$v['id']] = $v['name'];
        }
        return $list_the_loai;
    }

    public function getGameApp($model_name = NULL) {
        $query = '
                      SELECT
                        `GameApp`.`id`,
                        `GameApp`.`type`,
                        `GameApp`.`platform`,
                        `GameApp`.`danh_muc_id`,
                        `GameApp`.`company_id`,
                        `GameApp`.`cms_user_id`,
                        `GameApp`.`name`,
                        `GameApp`.`short_decription`,
                        `GameApp`.`description`,
                        `GameApp`.`device_support`,
                        `GameApp`.`logo`,
                        `GameApp`.`image_path_1`,
                        `GameApp`.`image_path_2`,
                        `GameApp`.`image_path_3`,
                        `GameApp`.`price`,
                        `GameApp`.`forum_link`,
                        `GameApp`.`status`,
                        `GameApp`.`version`,
                        `GameApp`.`j2me_jar_file_path`,
                        `GameApp`.`j2me_jad_file_path`,
                        `GameApp`.`android_apk_file_path`,
                        `GameApp`.`android_store_id`,
                        `GameApp`.`windows_store_id`,
                        `GameApp`.`iphone_store_id`,
                        `GameApp`.`total_download`,
                        `GameApp`.`created_date`,
                        `GameApp`.`last_update`,
                        `GameApp`.`order`,
                        `GameApp`.`distributor_id`
                    FROM
                        `gom`.`gom_game_app` AS `GameApp`
                    WHERE
                        1 = 1';
        if (!empty($model_name)) {
            $query .= ' 
                    AND LOWER(`GameApp`.`device_support`) LIKE "%' . $model_name . '%"';
        }
        $query .= '
                    ORDER BY
                        `GameApp`.`order` ASC
            ';
        $find_game_app = $this->pdo->query($query);
        $find_game_app->setFetchMode(PDO::FETCH_ASSOC);
        $game_app = $find_game_app->fetchAll();
        return $game_app;
    }

    private function db_connect() {
        require(self::$root . 'incfiles/db.php');
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
