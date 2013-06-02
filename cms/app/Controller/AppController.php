<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'pages', 'action' => 'display'),
            'logoutRedirect' => array('controller' => 'CmsUsers', 'action' => 'login'),
            'loginAction' => array('controller' => 'CmsUsers', 'action' => 'login'),
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'CmsUser',
                    'fields' => array('username' => 'user_name', 'password' => 'password'),
                )
            ),
            'unauthorizedRedirect' => array('controller' => 'CmsUsers', 'action' => 'login'),
            'authError' => 'Đăng nhập không thành công, vui lòng đăng nhập lại!',
            'authorize' => array('Controller'),
        ),
    );
    // tên name của các controller chỉ dành cho người dùng loại admin
    public $admin_controllers = array(
        'CmsUsers', 'DanhMuc', 'TheLoai',
        'ProductDistribution', 'Companies','News'
    );
    public $paginate = array('limit' => 20);
    public $subjectID = '';

    const Game = 'GameApp';
    const App = 'GameApp';
    const Category = 'DanhMuc';
    const TheLoai = 'TheLoai';
    const Event = 'GameEvent';
    const News = 'News';
    const NewsImage = 'NewsImage';
    const Company = 'Company';
    const ProductDistribution = 'ProductDistribution';
    const ProductDanhMuc = 'ProductDanhMuc';
    const TheLoaiRelation = 'TheLoaiRelation';

    public function beforeFilter() {
        // sửa lỗi phân quyền khi logout
        $this->Auth->allow('login', 'logout');
    }

    /**
     * Thiết lập back link để quay trở lại trang page lúc trước khi thực hiện add/edit
     */
    public function beforeRender() {
        $referer = '';
        if (isset($_SERVER['HTTP_REFERER']) && !isset($this->request->data['referer']) && !isset($this->request->query['referer']))
            $referer = $_SERVER['HTTP_REFERER'];
        else {
            if (isset($this->request->data['referer'])) {
                $referer = $this->request->data['referer'];
            } else if (isset($this->request->query['referer'])) {
                $referer = $this->request->query['referer'];
            }
        }
        $this->set('referer', $referer);
        parent::beforeRender();
    }

    public function isAuthorized($user) {
        $name_controller = $this->name;

        // thực hiện kiểm tra quyền hạn permissions đối với người dùng user có loại tài khoản bình thường
        // user có type là 2, bị giới hạn truy câp tới 1 số controller
        if ($user['type'] == 2) {
            $this->set('admin', 0);
            if (in_array($name_controller, $this->admin_controllers) !== FALSE) {
                return false;
            }
        } elseif ($user['type'] == 1) {
            $this->set('admin', 1);
        }
        // user có type là 1, có loại tài khoản admin thì luôn được truy cập tới mọi controller
        return true;
    }

    protected function uploadFile($src, $tmp, $type = 'img', $overwrite = false) {
        $filesize = Configure::read('gom.GameApp.filesize');
        $maxsize = $filesize[$type];
        $response = array();
        if ($src['size'] <= $maxsize * 1024 * 1024) {
            if (strlen($src['name'])) {
                if ($src["error"] > 0) {
                    $response['flagmessage'] = 'Lỗi, Không thực hiện upload được file. Hãy thực hiện lại';
                    $response['status'] = 0;
                    return $response;
                } else {
                    @list($txt, $ext) = explode(".", $src['name']);
                    if (!$overwrite) {
                        $actual_image_name = $txt . "_" . time() . "." . $ext;
                    } else {
                        $actual_image_name = $txt . "." . $ext;
                    }
                    if (move_uploaded_file($src["tmp_name"], $tmp . $actual_image_name)) {
                        $response['filename'] = $actual_image_name;
                        $response['status'] = 1;
                        return $response;
                    } else {
                        $response['flagmessage'] = 'Lỗi, Không thực hiện upload được file. Hãy thực hiện lại';
                        $response['status'] = 0;
                        return $response;
                    }
                }
            }
        } else {
            $response['flagmessage'] = 'Lỗi, file vượt quá dung lượng cho phép, dung lượng file phải nhỏ hơn hoặc bằng ' . $maxsize . 'MB';
            $response['status'] = 0;
            return $response;
        }
    }

    public function deleteAllFile($folder) {
        $files = glob($folder . '*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
    }

    public function search() {
        // the page we will redirect to
        $url['action'] = 'index';

        // build a URL will all the search elements in it
        // the resulting URL will be
        // example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
        foreach ($this->request->data as $k => $v) {
            foreach ($v as $kk => $vv) {
                $url[$k . '.' . $kk] = $vv;
            }
        }
        // redirect the user to the url
        $this->redirect($url, null, true);
    }

    /*
     * parseUrlParams action
     * thực hiện phân tích các params có trong URL, vào trong điều kiện conditions của paginaiton
     * mục đích giữ được điều kiện search và phân trang
     * @tham số: là 1 mảng cấu hình (array) $options
     * $options['likel'] chứa các params sẽ được tìm kiếm LIKE %value
     * $options['liker'] chứa các params sẽ được tìm kiếm LIKE value%
     * $options['likea'] chứa các params sẽ được tìm kiếm LIKE %value%
     * @trả về: gán các điều kiện đã được biến đổi vào trong $this->paginate['Game']['conditions']
     */

    protected function parseUrlParams($options = array()) {
        $likeL = $likeR = $likeA = array();
        $modelName = $options['modelname'];
        if (!empty($options['likel'])) {
            $likeL = $options['likel'];
        }
        if (!empty($options['liker'])) {
            $likeR = $options['liker'];
        }
        if (!empty($options['likea'])) {
            $likeA = $options['likea'];
        }
        /**
         * Thực hiện tìm kiếm dựa vào bảng phân tách quan hệ n-n như ProductDanhMuc, TheLoaiRelation
         * BEGIN
         */
        if (!empty($options['associated'])) {
            $associatedModel = $options['associated'];
            $joins = array();
            // khi liên kết với ProductDanhMuc thì join với modelName hiện tới với bảng ProductDanhMuc
            // thực hiện tìm kiếm Search.danh_muc_id trong bảng ProductDanhMuc
            if ($associatedModel == self::ProductDanhMuc) {
                $baseField = 'danh_muc_id';
                switch ($modelName):
                    case 'ProductDistribution':
                        $associatedField = 'distributor_id';
                        break;
                    default :
                        return 0;
                endswitch;

                $joins = array(
                    array(
                        'table' => 'product_danh_muc',
                        'alias' => self::ProductDanhMuc,
                        'type' => 'INNER',
                        'conditions' => array(
                            $modelName . '.id' . ' = ' . self::ProductDanhMuc . '.' . $associatedField,
                        ),
                    )
                );
            }

            // khi liên kết với ProductDanhMuc thì join với modelName hiện tới với bảng TheLoaiRelation
            // thực hiện tìm kiếm Search.danh_muc_id trong bảng TheLoaiRelation
            elseif ($associatedModel == self::TheLoaiRelation) {
                $baseField = 'the_loai_id';
                switch ($modelName):
                    case 'GameApp':
                        $associatedField = 'game_app_id';
                        break;
                    case 'News':
                        $associatedField = 'news_id';
                        break;
                endswitch;
                $joins = array(
                    array(
                        'table' => 'the_loai_relation',
                        'alias' => self::TheLoaiRelation,
                        'type' => 'INNER',
                        'conditions' => array(
                            $modelName . '.id' . ' = ' . self::TheLoaiRelation . '.' . $associatedField,
                        ),
                    )
                );
            }

            /**
             * Thực hiện joins kết nối với bảng phân tách quan hệ ProductDanhMuc hoặc TheLoaiRelation
             * BEGIN
             */
            if (!empty($this->passedArgs['Search.' . $baseField])) {
                $this->paginate[$modelName]['joins'] = $joins;
                if (!empty($options['subcategories'])) {
                    $danh_muc_id = $this->passedArgs['Search.' . $baseField];
                    /**
                     * Thực hiện tìm kiếm toàn bộ subcategory có trong Danh Mục hiện tại
                     * BEGIN
                     */
                    $danhMucIDs = $this->parseDanhMucID($danh_muc_id);
                    /**
                     * END
                     */
                    $this->paginate[$modelName]['conditions'][$associatedModel . '.' . $baseField] = $danhMucIDs;
                } else {
                    $this->paginate[$modelName]['conditions'][$associatedModel . '.' . $baseField] = $this->passedArgs['Search.' . $baseField];
                }
                $this->request->data['Search'][$baseField] = $this->passedArgs['Search.' . $baseField];
            }
            unset($this->passedArgs['Search.' . $baseField]);
            /**
             * END
             */
        }
        /**
         * END
         */
        if (!empty($this->passedArgs)) {
            foreach ($this->passedArgs as $key => $value) {
                if (strpos($key, 'Search.') !== FALSE) {
                    $convertName = explode('.', $key);
                    $fieldName = $convertName[1];
                    if (@strlen($value)) {
                        if (in_array($fieldName, $likeL)) {
                            $this->paginate[$modelName]['conditions']['LOWER(' . $modelName . '.' . $fieldName . ') LIKE '] = '%' . strtolower($value);
                        } elseif (in_array($fieldName, $likeR)) {
                            $this->paginate[$modelName]['conditions']['LOWER(' . $modelName . '.' . $fieldName . ') LIKE '] = strtolower($value) . '%';
                        } elseif (in_array($fieldName, $likeA)) {
                            $this->paginate[$modelName]['conditions']['LOWER(' . $modelName . '.' . $fieldName . ') LIKE '] = '%' . strtolower($value) . '%';
                        }
                        // nếu có tồn tại tìm kiếm theo subcategories và trường field hiện tại trùng với danh_muc_id
                        elseif (!empty($options['subcategories']) && $fieldName == $options['subcategories']) {
                            /**
                             * Thực hiện tìm kiếm toàn bộ subcategory có trong Danh Mục hiện tại
                             * BEGIN
                             */
                            $danhMucIDs = $this->parseDanhMucID($value);
                            /**
                             * END
                             */
                            $this->paginate[$modelName]['conditions'][$modelName . '.' . $fieldName] = $danhMucIDs;
                        } else {
                            $this->paginate[$modelName]['conditions'][$modelName . '.' . $fieldName] = $value;
                        }

                        $this->request->data['Search'][$fieldName] = $value;
                    }
                }
            }
        }
    }

    /**
     * Phương thức lấy ra toàn bộ id cấp con dựa vào $danh_muc_id
     * @param int $danh_muc_id 
     * @return array 
     */
    public function parseDanhMucID($danh_muc_id) {
        $DanhMuc = self::Category;
        $parent_refs = array();
        $child_list = array();
        $target = array();
        $findSub = $this->$DanhMuc->find('all', array(
            'fields' => array($DanhMuc . '.id', $DanhMuc . '.parent_id'),
            'recursive' => -1,
        ));
        if (!empty($findSub)) {
            foreach ($findSub as $data) {
                $id = (int) $data[$DanhMuc]['id'];
                $parent_id = (int) $data[$DanhMuc]['parent_id'];
                $thisitem = &$parent_refs[$id];
//            $thisitem['parent_id'] = $parent_id;
//            $thisitem['id'] = $id;
                if ($parent_id == $thisitem) {
                    $child_list[$id] = &$thisitem;
                } else {
                    $parent_refs[$parent_id][$id] = &$thisitem;
                }
            }
            // loại bỏ trường hợp khi category là cấp cha cao nhất - tức là có $parent_id  = 0
            if (!empty($parent_refs[$danh_muc_id])) {
                $target = $this->array_keys_multi($parent_refs[$danh_muc_id]);
            }
            $target[] = $danh_muc_id;
        }
        return $target;
    }

    /**
     * Phương thức lấy toàn bộ chỉ mục keys trong mảng array đa cấp (nhiều chiều)
     * @param array $array - mảng array đa cấp cần lấy ra toàn bộ chỉ mục keys
     * @return array
     */
    public function array_keys_multi(array $array) {
        $keys = array();

        foreach ($array as $key => $value) {
            $keys[] = $key;

            if (is_array($array[$key])) {
                $keys = array_merge($keys, $this->array_keys_multi($array[$key]));
            }
        }

        return $keys;
    }

    /*
     * Thực hiện phân tích tên names của các tham số Params có trong URL
     * biến đổi chúng sang dạng mảng array cấu trúc lồng nhau, phù hợp với cấu trúc array 
     * trong CakePHP dùng để lưu trong phương thức saveAll hay saveMany
     * @tham số: (array) 1 mảng cấu hình $urlParams
     * (tham chiếu) &$target
     * @trả về: kết quả được biến đổi sẽ được lưu trong tham chiếu $target
     */

    protected function parseSaveData($options = array(), &$target) {
        $modelName = $options['modelname'];
        if (!empty($this->passedArgs)) {
            foreach ($this->passedArgs as $key => $value) {
                if (strpos($key, '.' . $modelName) !== FALSE) {
                    $target = Hash::insert($target, $key, $value);
                }
            }
        }
    }

    /**
     * convert_vi_to_en method
     * hàm chuyền đổi tiếng việt có dấu sang tiếng việt không dấu
     * @param string $str
     * @return string
     */
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

    /**
     * delete action 
     * Thực hiện xóa logic - thiết lập status thành -1
     * Giả lập xóa theo phương thức POST - kết hợp với đoạn mã JS trong default.ctp
     * @param int $id
     * @return boolean
     * @throws MethodNotAllowedException
     */
    public function delete($id = null) {
        $response = array();
        $modelName = $this->modelClass;

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('Bạn không có quyền thực hiện thao tác này');
        }
        // giới hạn quyền delete đối với các user thường: không được xóa các record hiện đang ở
        // trạng thái public
        $userType = $this->Auth->user('type');
        if ($userType != 1) {
            $public = $this->$modelName->find('list', array(
                'conditions' => array($modelName . '.status' => 2),
                'fields' => array($modelName . '.id'),
            ));
            $public = array_values($public);
            if (in_array($id, $public) !== FALSE) {
                $this->autoRender = FALSE;
                $response['error'] = 'Bạn không có quyền thực hiện thao tác này';
                echo json_encode($response);
                return FALSE;
            }
        }
        $this->autoRender = FALSE;
        $this->$modelName->id = $id;
        if (!$this->$modelName->exists()) {
            $response['error'] = 'Dữ liệu không tồn tại';
            echo json_encode($response);
            return FALSE;
        }
        if ($this->$modelName->save(array('status' => -1))) {
            $this->Session->setFlash(__('Dữ liệu đã được xóa'));
            $response['redirect'] = Router::url(array('action' => 'index'));
            echo json_encode($response);
            return FALSE;
        } else {
            $response['error'] = 'Dữ liệu không được xóa thành công!';
            echo json_encode($response);
            return FALSE;
        }
    }

    public function getOptsFromTheLoaiRelation($ids = array()) {
        $controller = $this->name;
        $opts = array();
        switch ($controller):
//            case 'ProductDistribution':
//                $this->subjectID = 'distributor_id';
//                break;
            case 'GameApp':
                $this->subjectID = 'game_app_id';
                break;
            case 'News':
                $this->subjectID = 'news_id';
                break;
        endswitch;
        if (!empty($this->subjectID)) {
            $this->TheLoaiRelation->recursive = -1;
            foreach ($ids as $id) {
                $id = (int) $id;
                $opts[$id] = $this->TheLoaiRelation->find('list', array(
                    'fields' => array('TheLoaiRelation.id', 'TheLoaiRelation.the_loai_id'),
                    'conditions' => array('TheLoaiRelation.' . $this->subjectID => $id),
                ));
            }
        }
        return $opts;
    }

    /**
     * getOptsFromProductDanhMuc action
     * Thực hiện lấy về các options đã được thiết lập của 1 kiểu nào đó và 
     * set chúng là selected trong thẻ selectbox multiple, 
     * ví dụ như ProductDistribution
     * do ProductDistribution có quan hệ n-n với DanhMuc
     * 
     * @param array $ids 
     * @return array
     */
    public function getOptsFromProductDanhMuc($ids = array()) {
        $controller = $this->name;
        $opts = array();
        switch ($controller):
            case 'ProductDistribution':
                $this->subjectID = 'distributor_id';
                break;
        endswitch;
        if (!empty($this->subjectID)) {
            $this->ProductDanhMuc->recursive = -1;
            foreach ($ids as $id) {
                $id = (int) $id;
                $opts[$id] = $this->ProductDanhMuc->find('list', array(
                    'fields' => array('ProductDanhMuc.id', 'ProductDanhMuc.danh_muc_id'),
                    'conditions' => array('ProductDanhMuc.' . $this->subjectID => $id),
                ));
            }
        }
        return $opts;
    }

    /**
     * getDanhMuc action
     * dùng để lấy về danh mục phù hợp với tưng kiểu type
     * danh sách danh mục có nhãn được đính thêm trạng thái status của chính nó
     * @param int $type 
     * @return array - mảng array(id => label.status)
     */
    public function getDanhMuc($type = null) {
        $this->DanhMuc->recursive = -1;
        $status = Configure::read('gom.status');
        $options = array();
        $options['fields'] = array('DanhMuc.id', 'DanhMuc.name', 'DanhMuc.status');
        if (!empty($type)) {
            $options['conditions']['DanhMuc.type'] = $type;
        }
        $findDanhMuc = $this->DanhMuc->find('all', $options);
        $danhmuc = array();
        /**
         * Gán nhãn status vào label
         * BEGIN
         */
        if (!empty($findDanhMuc)) {
            foreach ($findDanhMuc as $item) {
                $id = (int) $item['DanhMuc']['id'];
                $label = $item['DanhMuc']['name'] . '(' . $status[$item['DanhMuc']['status']] . ')';
                $danhmuc[$id] = $label;
            }
        }
        /**
         * END
         */
        return $danhmuc;
    }

    /**
     * getTheLoai action
     * dùng để lấy về danh mục phù hợp với tưng kiểu type
     * danh sách danh mục có nhãn được đính thêm trạng thái status của chính nó
     * @return array - mảng array(id => label.status)
     * 
     */
    public function getTheLoai() {
        $this->TheLoai->recursive = -1;
        $status = Configure::read('gom.status');
//        $joins = array(
//            array(
//                'table' => 'the_loai_relation',
//                'alias' => 'TheLoaiRelation',
//                'type' => 'LEFT',
//                'conditions' => array(
//                    'TheLoaiRelation.the_loai_id = TheLoai.id',
//                    'TheLoaiRelation.status !=' => -1,
//                ),
//            )
//        );
        $findTheLoai = $this->TheLoai->find('all', array(
            'fields' => array('TheLoai.id', 'TheLoai.name', 'TheLoai.status'),
//            'joins' => $joins,
            'conditions' => array(
            // chỉ hiện thị các danh mục có loại dành cho PRODUCT DISTRIBUTION
//                'TheLoaiRelation.type' => $product_type,
            )
        ));
        $theloai = array();
        /**
         * Gán nhãn status vào label
         * BEGIN
         */
        if (!empty($findTheLoai)) {
            foreach ($findTheLoai as $item) {
                $id = (int) $item['TheLoai']['id'];
                $label = $item['TheLoai']['name'] . '(' . $status[$item['TheLoai']['status']] . ')';
                $theloai[$id] = $label;
            }
        }
        /**
         * END
         */
        return $theloai;
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
    public function getTreeDanhMuc($type = null, $options = array()) {
        $DanhMuc = self::Category;
        $options['fields'] = array($DanhMuc . '.id', $DanhMuc . '.name', $DanhMuc . '.status', $DanhMuc . '.parent_id', $DanhMuc . '.order',);
        $options['recursive'] = -1;
        $options['order'] = array($DanhMuc . '.order');
        if (!empty($type)) {
            $options['conditions'][$DanhMuc . '.type'] = $type;
        }
        // nếu có thiết lập tìm kiếm theo parent_id và các điều kiện tìm kiếm
        /**
         * Thực hiện tạo ra điều kiện 
         * BEGIN
         */
        if (!empty($options['conditions'][$DanhMuc . '.parent_id'])) {
            $parent_id = $options['conditions'][$DanhMuc . '.parent_id'];

            // thực hiện lấy ra toàn bộ ids của các subcategory thuộc danh mục cấp cha này
            // đề phòng trường hợp các subcategory cũng có các subcategory con thuộc nó
            $ids = $this->parseDanhMucID($parent_id);
            $options['conditions'][$DanhMuc . '.parent_id'] = $ids;

            $conditions = $options['conditions'];
            unset($options['conditions']);

            $options['conditions']['OR'] = array(
                $conditions,
                // thực hiện cộng cả danh mục cha hiện tại vào kết quả tìm kiếm
                // để bảo toàn cấu trúc phân cấp của tree danh mục
                $DanhMuc . '.id' => $parent_id,
            );
        }
        /**
         * END
         */
        $findSub = $this->$DanhMuc->find('all', $options);

        $childs = array();

        if (!empty($findSub)) {

            // thực hiện chuyển đổi mảng array đa chiều thành mảng chứa đối tượng stdclass
            foreach ($findSub as $key => $item) {
                $findSub[$key] = (object) $item[$DanhMuc];
            }
            unset($item);
            unset($key);

            //thực hiện cấu trúc hóa cây tree danh mục dựa vào parent_id và id
            /**
             * BEGIN
             */
            foreach ($findSub as $item) {
                $childs[$item->parent_id][] = $item;
            }
            unset($item);
            foreach ($findSub as $item) {
                if (isset($childs[$item->id])) {
                    $item->childs = $childs[$item->id];
                }
            }
            unset($item);
            /**
             * END
             */
        }


        /**
         * Cách xử lý khi người dùng không chọn vào $parent_id, thì cách xử lý giống như lúc
         * Không có điều kiện search
         */
        if (empty($parent_id)) {
            return isset($childs[0]) ? $childs[0] : array();
        }
        /**
         * Phần xử lý tạo ra cây Tree danh mục dành cho việc search
         * Ta sẽ lấy về nhánh Tree có độ cao (độ sâu) depth lớn nhất
         * BEGIN
         */ else {
            // tạp ra mảng chứa độ cao depth của cấu trúc trees
            $depth = array();

            // thực hiện tính toán, lấy ra độ cao cho mỗi nhánh tree
            foreach ($childs as $key => $item) {
                $depth[$key] = $this->array_depth($item);
            }

            // lấy ra nhánh tree có độ cao lớn nhất
            $target = array_search(max($depth), $depth);
            if ($target >= 0) {
                return $childs[$target];
            }
            /**
             * END
             */
            return array();
        }
    }

    /**
     * array_depth method
     * Xác định số chiều lớn nhất (độ sâu nhất) của mảng đa chiều - n cấp
     * @param array $array
     * @return int
     */
    public function array_depth($array) {
        $max_indentation = 1;

        $array_str = print_r($array, true);
        $lines = explode("\n", $array_str);

        foreach ($lines as $line) {
            $indentation = (strlen($line) - strlen(ltrim($line))) / 4;

            if ($indentation > $max_indentation) {
                $max_indentation = $indentation;
            }
        }

        return ceil(($max_indentation - 1) / 2) + 1;
    }

    /**
     * buildTreeDanhMuc action
     * @param array $trees - mảng có cấu trúc được trả về từ getTreeDanhMuc action
     * @see getTreeDanhMuc action
     * @return string - chuỗi <ol> và <li> lồng nhau
     */
    public $firstOl = 0; // dùng xác địn xem đâu là <ol> đầu tiên (cấp cha cao nhất)

    public function buildTreeDanhMuc($trees, $type = null) {
        $status = Configure::read('gom.status');
        if (!is_array($trees)) {
            return '';
        }
        if ($this->firstOl == 0) {
            $output = '<ol class = "sortable ui-sortable">';
        } else {
            $output = '<ol>';
        }
        $this->firstOl++;
        foreach ($trees as $item) {
            $edit_link = Router::url(array('action' => 'edit', $item->id, $type));
            $delete_link = Router::url(array('action' => 'delete', $item->id, $type));
            $output .= '<li id="list_' . $item->id . '"><div>' . $item->name . '(' . $status[$item->status] . ')';
            $output .= "<a class = 'icon-trash remove pull-right' title = 'Xóa' href = '" . $delete_link . "'></a>";
            $output .= "<a class = 'icon-edit pull-right' title = 'Chỉnh sửa' href = '" . $edit_link . "'></a>";
            $output .= "</div>";
            if (property_exists($item, 'childs')) {
                $output .= $this->buildTreeDanhMuc($item->childs, $type);
            }
            $output .= '</li>';
        }
        $output .= '</ol>';
        return $output;
    }

    /**
     * buildOptsDanhMuc method
     * xây dựng các nhãn Options cho selectbox, có thể nhìn thấy được phân cấp trong danh mục
     * @param array $trees - mảng có cấu trúc được trả về từ getTreeDanhMuc action
     * @see getTreeDanhMuc action
     * @return array
     */
    public function buildOptsDanhMuc($trees) {
        $flag = Configure::read('gom.status');
        $arrayiter = new RecursiveArrayIterator($trees);
        $iteriter = new RecursiveIteratorIterator($arrayiter);
        $list = array();
        foreach ($iteriter as $key => $value) {
            $id = $iteriter->current();
            $iteriter->next();

            $depth = $iteriter->getDepth();
            $name = $iteriter->current();
            $iteriter->next();

            $status = $iteriter->current();
            $label = str_repeat('-', $depth - 1) . $name . '(' . $flag[$status] . ')';
            $iteriter->next();

            $list[$id] = $label;
            $iteriter->next();
        }
        return $list;
    }

    /**
     * updateList action
     * Phương thức thực hiện update hàng loạt từ trang danh sách index
     * @throws MethodNotAllowedException
     */
    public function updateList() {
        $modelName = $this->name;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('Bạn không có quyền thực hiện thao tác này');
        }
        $target = $this->request->data['UpdateList'];
        if ($this->$modelName->saveAll($target)) {
            $this->Session->setFlash('Dữ liệu đã được cập nhât thành công');
        } else {
            $this->Session->setFlash('Lỗi, Dữ liệu chưa được cập nhật thành công, hãy thử lại!');
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * jqueryFileUpload action
     * Hàm response lại sự kiện upload file thông qua jQuery-File-Upload vendor
     * Hàm response này sử dụng kết hợp với jquery_file_upload.ctp 
     * và jquery_file_upload_input.ctp trong Element View
     * @return JSON string  - đối tượng UploadHandler khi khởi tạo xong tự tạo ra 1 JSON String
     * @see app\Vendor\jQuery-File-Upload\server\php\UploadHandler.php
     */
    public function jqueryFileUpload() {
        $this->autoRender = FALSE;
        App::import('Vendor', 'jQuery-File-Upload', array('file' => 'jQuery-File-Upload/server/php' . DS . 'UploadHandler.php'));
        $action_link = Router::url(array('action' => 'jqueryFileUpload'));
        /**
         * lấy về liên kết $delete_link
         * link dùng để xóa file được truyền vào nút delete trong view
         */
        $delete_link = empty($this->request->query['detele_link']) ? null : $this->request->query['detele_link'];
        if (!empty($delete_link)) {
            unlink($delete_link);
        }

        $upload_handler = new UploadHandler($action_link);
    }

    /**
     * copyFile method
     * dùng để sao chép file trong thư mục tạm tmp vào thư mục target
     * @param string $tmp
     * @param string $target
     */
    public function copyFile($tmp, $target) {
        if (file_exists($tmp)) {
            copy($tmp, $target);
        }
    }

    /**
     * getDirPath method
     * Dùng để lấy về đường dẫn tới thư mục sau khi nó được tự tạo ra dựa vào name input mà 
     * user nhập vào
     * @param string $name_input
     * @return string
     */
    public function getDirPath($name_input) {
        $flag = $this->name;
        $folder = Configure::read('gom.' . $flag . '.folder');
        $path = $folder['dir'];
        // xác định tên thư mục sẽ được tạo ra dựa vào tên game
        $dirname = $this->request->data[$flag][$name_input];
        // chuyển từ tiếng việt có dấu sang tiếng việt không dấu
        $dirname = $this->convert_vi_to_en($dirname);
        if (!file_exists($path . $dirname) || !is_dir($path . $dirname)) {
            mkdir($path . $dirname); // tạo 1 thư mục mới
        }
        $dirpath = $path . $dirname . '/';

        return $dirpath;
    }

}

