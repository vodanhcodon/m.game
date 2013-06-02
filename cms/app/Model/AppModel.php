<?php

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    // tên những model bị giới hạn hành vi theo người dùng user thông thường
    public $limitModel = array('GameApp', 'GameEvent');
    public $subjectID = '';
    public $associateID = '';
    public $baseID = '';
    public $type = '';

    public function convert_vi_to_en($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
//$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        return $str;
    }

    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        $userId = CakeSession::read('Auth.User.id');
        $userType = CakeSession::read('Auth.User.type');
        // với những user bình thường có type !=1, chỉ được phép thấy các bài post thuộc vào company của họ
        // trong những model bị giới hạn
        if (!empty($userType)) {
//            if ($userType != 1 && $this->hasField('cms_user_id')) {
//                $queryData['conditions'][$this->alias . '.cms_user_id'] = (int) $userId;
//            }
            if ($userType != 1 && $this->hasField('cms_user_id')) {
                $queryData['conditions'][$this->alias . '.cms_user_id'] = (int) $userId;
            }

            if ($userType != 1 && $this->hasField('company_id')) {
                $company_id = CakeSession::read('Auth.User.company_id');
                $queryData['conditions'][$this->alias . '.company_id'] = $company_id;
            }
        }
        /**
         * chỉ được liệt kê ra các record có status != -1
         */
//        if ($this->hasField('status')) {
//            $queryData['conditions'][$this->alias . '.status !='] = -1;
//        }

        return $queryData;
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        /**
         * Thực hiện cập nhập time vào các trường created_date và last_update
         * BEGIN
         */
        // nếu là tạo mới thì cập nhật cả 2 trường
        if (empty($this->data[$this->alias]['id']) && $this->hasField('created_date') && $this->hasField('last_update')) {
            $this->data[$this->alias]['created_date'] = $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        }
        // nếu là update thì chỉ cập nhật trường last_update
        elseif (!empty($this->data[$this->alias]['id']) && $this->hasField('created_date') && $this->hasField('last_update')) {
            $this->data[$this->alias]['last_update'] = date('Y-m-d H:i:s');
        }
        /**
         * END
         */
        /**
         * Tự động điền thêm cms_user_id của người dùng vào nội dung khi họ thực hiện tạo ra 
         * BEGIN
         */
        if (empty($this->data[$this->alias]['id']) && $this->hasField('cms_user_id')) {
            $userId = CakeSession::read('Auth.User.id');
            $this->data[$this->alias]['cms_user_id'] = $userId;
        }
        /**
         * END
         */
    }

    public function afterSave($created) {
        parent::afterSave($created);
//        if ($created) {
        // lấy ra toàn bộ model mà Model hiện tại có quan hệ hasMany
        $associatedModel = $this->getAssociated('hasMany');

        // chỉ thực hiện cập nhật vào DanhMuc hay TheLoai khi action không phải delete action - tức có status = -1
        if (!empty($associatedModel) && isset($this->data[$this->alias]['id'])) {
            $this->baseID = $this->data[$this->alias]['id'];
//            debug($this->data);die;
            // Nếu trong đó có Model là ProductDanhMuc, xác định duy nhất đang thực hiện xử lý trên
            /**
             * gom_product_distribution - gome_product_danh_muc - gom_danh_muc
             */
            if (in_array('ProductDanhMuc', $associatedModel)) {
                $this->saveProductDanhMuc($this->alias);
            }

            if (in_array('TheLoaiRelation', $associatedModel)) {
                $this->saveTheLoaiRelation($this->alias);
            }
        }
//        }
    }

    /**
     * saveProductDanhMuc action
     * Khi add hay edit liên quan tới quan hệ n-n với DanhMuc, thực hiện cập nhập các dữ liệu cần thiết vào bảng ProductDanhMuc
     * @param string $currentModel
     */
    protected function saveProductDanhMuc($currentModel) {
        switch ($currentModel):
            case 'ProductDistribution':
                $this->subjectID = 'distributor_id';
                $this->associateID = 'danh_muc_id';
                break;
            default :
                return 0;
        endswitch;

        $detele = $this->ProductDanhMuc->deleteAll(array('ProductDanhMuc.' . $this->subjectID => $this->baseID), FALSE);
        if ($detele) {
            if (!empty($this->data['ProductDanhMuc'][$this->associateID])) {
                $productDanhMuc = array();
                foreach ($this->data['ProductDanhMuc'][$this->associateID] as $key => $value) {
                    $productDanhMuc[$key]['ProductDanhMuc'][$this->associateID] = $value;
                    $productDanhMuc[$key]['ProductDanhMuc'][$this->subjectID] = $this->baseID;
                }
                $this->ProductDanhMuc->saveAll($productDanhMuc);
            }
        }
    }

    /**
     * saveTheLoaiRelation action
     * Khi add hay edit liên quan tới quan hệ n-n với TheLoai, thực hiện cập nhập các dữ liệu cần thiết vào bảng TheLoaiRelation
     * @param string $currentModel
     */
    protected function saveTheLoaiRelation($currentModel) {
        $types = Configure::read('gom.DanhMuc.type');
        $this->associateID = 'the_loai_id';
        switch ($currentModel):
            case 'ProductDistribution':
                $this->subjectID = 'distributor_id';
                $this->type = array_search('PRODUCT DISTRIBUTION', $types);
                break;
            case 'GameApp':
                $this->subjectID = 'game_app_id';
                $gameAppType = $this->data['GameApp']['type'];
                if ($gameAppType == 1) {
                    $this->type = array_search('GAME', $types);
                } elseif ($gameAppType == 2) {
                    $this->type = array_search('APP', $types);
                }
                break;
            case 'News':
                $this->subjectID = 'news_id';
                $this->type = array_search('NEWS', $types);

                // fix lỗi khi thực hiện lưu the_loai_id(multiple select) đối với bảng News
                // dữ liệu bị Cake chuyển đối sai cấu trúc khi tuc hien luu kiu saveAll, nên phải thực hiên sửa lại
                //xem thêm view/news/add.ctp
                if (!empty($this->data['TheLoaiRelation'][$this->associateID]['TheLoaiRelation'])) {
                    $this->data['TheLoaiRelation'][$this->associateID] = $this->data['TheLoaiRelation'][$this->associateID]['TheLoaiRelation'];
                }
                break;
            default :
                return 0;
        endswitch;
        $detele = $this->TheLoaiRelation->deleteAll(array('TheLoaiRelation.' . $this->subjectID => $this->baseID), FALSE);
        if ($detele) {
            if (!empty($this->data['TheLoaiRelation'][$this->associateID])) {
                $theLoaiRelation = array();
                foreach ($this->data['TheLoaiRelation'][$this->associateID] as $key => $value) {
                    $theLoaiRelation[$key]['TheLoaiRelation'][$this->associateID] = $value;
                    $theLoaiRelation[$key]['TheLoaiRelation'][$this->subjectID] = $this->baseID;
                    $theLoaiRelation[$key]['TheLoaiRelation']['type'] = $this->type;
                }
                $this->TheLoaiRelation->saveAll($theLoaiRelation);
            }
        }
    }

}
