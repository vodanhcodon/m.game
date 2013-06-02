<?php

App::uses('AppController', 'Controller');

class WebServiceController extends AppController {

    public $uses = array(
        'GameApp', 'News', 'DanhMuc', 'GameEvent', 'TheLoai',
        'NewsImage', 'Company', 'ProductDistribution'
    );
    public $deviceModel = '';
    public $determineDevice = 0;

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
    const Limit = 15;

    /**
     *
     * kiểu join dành cho GET_CATEGORY
     * BEGIN
     */
    public $joinsDanhMuc2GameApp = array(
        array(
            'table' => 'game_app',
            'alias' => 'GameApp',
            'type' => 'LEFT',
            'conditions' => array(
                'DanhMuc.id = GameApp.danh_muc_id',
                'GameApp.status' => 2,
            ),
        )
    );
    public $joinsDanhMuc2News = array(
        array(
            'table' => 'news',
            'alias' => 'News',
            'type' => 'LEFT',
            'conditions' => array(
                'DanhMuc.id = News.danh_muc_id',
                'News.status' => 2,
            ),
        )
    );
    public $joinsDanhMuc2Product = array(
        array(
            'table' => 'product_danh_muc',
            'alias' => 'ProductDanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'ProductDanhMuc.danh_muc_id = DanhMuc.id',
//                'ProductDanhMuc.status' => 2,
            ),
        ),
        array(
            'table' => 'product_distribution',
            'alias' => 'ProductDistribution',
            'type' => 'LEFT',
            'conditions' => array(
                'ProductDistribution.id = ProductDanhMuc.distributor_id',
                'ProductDistribution.status' => 2,
            ),
        ),
    );
    // kiểu join dùng việc đếm số product distribution thuộc trong 1 danh muc cha cấp cao nào đó
    public $joinsProduct2ProductDanhMuc = array(
        array(
            'table' => 'product_danh_muc',
            'alias' => 'ProductDanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'ProductDanhMuc.distributor_id = ProductDistribution.id',
//                'ProductDanhMuc.status' => 2,
            ),
        ),
    );

    /**
     *
     * END
     */

    /**
     *
     * kiểu join dành cho GET_THE_LOAI
     * BEGIN
     */
    protected $joinsTheLoai2GameApp = array(
        array(
            'table' => 'danh_muc',
            'alias' => 'DanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoai.danh_muc_id = DanhMuc.id',
                'DanhMuc.status' => 2,
            ),
        ),
        array(
            'table' => 'the_loai_relation',
            'alias' => 'TheLoaiRelation',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoai.id = TheLoaiRelation.the_loai_id',
                'TheLoaiRelation.status' => 2
            ),
        ),
        array(
            'table' => 'game_app',
            'alias' => 'GameApp',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoaiRelation.game_app_id = GameApp.id',
                'GameApp.status' => 2
            ),
        ),
    );
    protected $joinsTheLoai2News = array(
        array(
            'table' => 'danh_muc',
            'alias' => 'DanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoai.danh_muc_id = DanhMuc.id',
                'DanhMuc.status' => 2
            ),
        ),
        array(
            'table' => 'the_loai_relation',
            'alias' => 'TheLoaiRelation',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoai.id = TheLoaiRelation.the_loai_id',
                'TheLoaiRelation.status' => 2
            ),
        ),
        array(
            'table' => 'news',
            'alias' => 'News',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoaiRelation.news_id = News.id',
                'News.status' => 2
            ),
        ),
    );

    /**
     *
     * END
     */

    /**
     * Kiểu join dành cho GET_GOM_EVENT
     * BEGIN
     */
    protected $joinsGameEvent2GameApp = array(
        array(
            'table' => 'game_app',
            'alias' => 'GameApp',
            'type' => 'LEFT',
            'conditions' => array(
                'GameApp.id = GameEvent.game_app_id',
                'GameApp.status' => 2
            ),
        ),
    );
    /**
     * END
     */

    /**
     *
     * kiểu join dành cho GET_ITEMS
     * BEGIN
     */
    protected $joinsItems2GameApp = array(
        array(
            'table' => 'danh_muc',
            'alias' => 'DanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'GameApp.danh_muc_id = DanhMuc.id',
                'DanhMuc.status' => 2
            ),
        ),
        array(
            'table' => 'the_loai_relation',
            'alias' => 'TheLoaiRelation',
            'type' => 'LEFT',
            'conditions' => array(
                'GameApp.id = TheLoaiRelation.game_app_id',
                'TheLoaiRelation.status' => 2,
            ),
        ),
        array(
            'table' => 'the_loai',
            'alias' => 'TheLoai',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoaiRelation.the_loai_id = TheLoai.id',
                'TheLoai.status' => 2
            ),
        ),
        array(
            'table' => 'company',
            'alias' => 'Company',
            'type' => 'LEFT',
            'conditions' => array(
                'GameApp.company_id = Company.id',
            ),
        ),
    );
    protected $joinsItems2News = array(
        array(
            'table' => 'danh_muc',
            'alias' => 'DanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'News.danh_muc_id = DanhMuc.id',
                'DanhMuc.status' => 2
            ),
        ),
        array(
            'table' => 'the_loai_relation',
            'alias' => 'TheLoaiRelation',
            'type' => 'LEFT',
            'conditions' => array(
                'News.id = TheLoaiRelation.news_id',
                'TheLoaiRelation.status' => 2,
                'TheLoaiRelation.type' => 2,
            ),
        ),
        array(
            'table' => 'the_loai',
            'alias' => 'TheLoai',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoaiRelation.the_loai_id = TheLoai.id',
                'TheLoai.status' => 2
            ),
        ),
//        array(
//            'table' => 'news_image',
//            'alias' => 'NewsImage',
//            'type' => 'LEFT',
//            'conditions' => array(
//                'News.id = NewsImage.news_id',
//            ),
//        ),
    );

    /**
     *
     * END
     */

    /**
     *
     * kiểu join dành cho GET_NEWS
     * BEGIN
     */
    protected $joinsNews = array(
        array(
            'table' => 'the_loai_relation',
            'alias' => 'TheLoaiRelation',
            'type' => 'LEFT',
            'conditions' => array(
                'News.id = TheLoaiRelation.news_id',
                'TheLoaiRelation.status' => 2,
                'TheLoaiRelation.type' => 2,
            ),
        ),
        array(
            'table' => 'the_loai',
            'alias' => 'TheLoai',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoaiRelation.the_loai_id = TheLoai.id',
                'TheLoai.status' => 2
            ),
        ),
        array(
            'table' => 'danh_muc',
            'alias' => 'DanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'News.danh_muc_id = DanhMuc.id',
                'DanhMuc.status' => 2
            ),
        ),
    );

    /**
     * END
     */

    /**
     * kiểu join dành cho GET_GAME
     * BEGIN
     */
    protected $joinsGameApp2TheLoaiRelation = array(
        array(
            'table' => 'the_loai_relation',
            'alias' => 'TheLoaiRelation',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoaiRelation.game_app_id = GameApp.id',
                'TheLoaiRelation.type' => 1,
            ),
        ),
        array(
            'table' => 'the_loai',
            'alias' => 'TheLoai',
            'type' => 'LEFT',
            'conditions' => array(
                'TheLoaiRelation.the_loai_id = TheLoai.id',
                'TheLoai.status' => 2
            ),
        ),
        array(
            'table' => 'danh_muc',
            'alias' => 'DanhMuc',
            'type' => 'LEFT',
            'conditions' => array(
                'DanhMuc.id = GameApp.danh_muc_id',
                'DanhMuc.status' => 2,
                'DanhMuc.type' => 1,
            ),
        ),
        array(
            'table' => 'company',
            'alias' => 'Company',
            'type' => 'LEFT',
            'conditions' => array(
                'GameApp.company_id = Company.id',
            ),
        ),
    );

    /**
     * END
     */

    /**
     * phương thức getCategory - trả về JSON OBJECT khi có 1 request tới
     * request gồm 3 param: 
     * GET_CATEGORY?type=xx&page=xx&number_per_page=xxx
      - type: loại content:
      + 1 - Game
      + 2 - News
      + 3 - App
      + 4 - Audio
      + 5- Book
      - page: Là số trang cần xem
      - number_per_page: số phần tử 1 trang, nết không có tham số này, thì trả về tất cả.
     */
    public function getCategory() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
//        if ($this->request->data) {
        $modelName = self::Category;
        $modelJoin = '';
        $determineDevice = 0;
        $this->$modelName->recursive = -1;
        $response = array();
        $options = array();

        $type = isset($this->request->query['type']) ? $this->request->query['type'] : null;
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $number_per_page = isset($this->request->query['number_per_page']) ? $this->request->query['number_per_page'] : null;

        // chỉ thực hiện liệt kê ra các danh mục có status = 2
        $options['conditions'][$modelName . '.status'] = 2;

        // chỉ thực hiện lây ra các danh mục cha cấp 1 với parent_id = 0
        $options['conditions'][$modelName . '.parent_id'] = 0;

        /**
         * các giá trị $type có thể nhận về 
         * 1 game, 
          2 news,
          3 app,
          4 audio,
          5 book,
          6 product distribution
         */
        if (!empty($type)) {
            $options['conditions'][$modelName . '.type'] = $type;
            switch ($type):
                case 1:// nếu $type = 1 hoặc 3 thì join với bảng gam_app
                    $modelJoin = self::Game;
                    $determineDevice = 'joinsDanhMuc2GameApp';
                    $options['joins'] = $this->joinsDanhMuc2GameApp;
                    $this->joinsDanhMuc2GameApp[0]['conditions'][$modelJoin . '.type'] = 1;
                    break;
                case 2:// nếu $type = 2 thì join với bảng news
                    $modelJoin = self::News;
                    $options['joins'] = $this->joinsDanhMuc2News;
                    break;
                case 3: // nếu $type = 1 hoặc 3 thì join với bảng gam_app
                    $modelJoin = self::App;
                    $determineDevice = 'joinsDanhMuc2GameApp';
                    $options['joins'] = $this->joinsDanhMuc2GameApp;
                    $this->joinsDanhMuc2GameApp[0]['conditions'][$modelJoin . '.type'] = 2;
                    break;
                // nếu $type = 6 thì join với 2 bảng gom_product_danh_muc và gom_product_distribution
                case 6:
                    $modelJoin = self::ProductDistribution;
                    $determineDevice = 'joinsDanhMuc2Product';
                    $options['joins'] = $this->joinsDanhMuc2Product;
                    break;

                default :// nếu không có $type thì điều hướng tới notFound
                    $this->redirect(array('action' => 'notFound'));
            endswitch;
        }
        else {
            $this->redirect(array('action' => 'notFound'));
        }
        $this->determineDevice = $determineDevice;
        // nếu ko có thì tham số page, thì lấy tất cả danh mục tương ứng với type;
        if (empty($page)) {
            unset($options['page']);
            unset($options['limit']);
        }
        // nếu không có tham số number_per_page, thì trả về mặc định 15 phần record
        elseif (empty($number_per_page)) {
            $options['limit'] = self::Limit;
            $number_per_page = self::Limit;
        } elseif (!empty($page) && !empty($number_per_page)) {
            $options['page'] = $page;
            $options['limit'] = $number_per_page;
        }
        // xác định thông tin HTTP_USER_AGENT để xác định thiết bị device đang truy cập
        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents);
        $deviceModel = $findDeviceModel['deviceModel'];
        $this->deviceModel = $deviceModel;

        // chỉ khi nào xác định được tên model của thiết bị mới truy vấn vào DB để lấy dữ liệu 
        if ($deviceModel) {
            // nếu cần phải xác dịnh rõ loại thiết bị khi $determineDevice khác 0
//            if ($determineDevice) {
//                // tự động tạo ra điều kiện condition device_support = với mẫu model của thiết bị
//                $this->joinConditions($modelJoin, $determineDevice, $deviceModel);
//            }
//            $options['fields'] = array($modelName . '.*', 'Count(' . $modelJoin . '.id) AS counter');
//            $options['order'] = array($modelName . '.order ASC');
            $options['group'] = array($modelName . '.id');
            $findCategory = $this->$modelName->find('all', $options);
            if (!empty($findCategory)) {
                foreach ($findCategory as $item) {
                    /**
                     * xác định xem danh mục có subcategory hay không
                     * BEGIN
                     */
                    $parent_id = (int) $item[$modelName]['parent_id'];
                    $id = (int) $item[$modelName]['id'];

                    // Thực hiện tìm ra các subcategory id thuộc danh mục cha cấp cao này
                    $findSubCategory = $this->parseDanhMucID($id);

                    // khi $parent_id = 0 hoặc $parent_id = null thì danh mục luôn là cấp cha 
                    // thực hiện tìm xem cấp cha này có subcateory hay không?
                    if (empty($parent_id)) {
                        if (count($findSubCategory) <= 1) {
                            $subCategory = FALSE;
                        } else {

                            $subCategory = TRUE;
                        }
                    } else {
                        // khi có $parent_id khác 0 thì danh mục luôn có cấp cha cao hơn
                        $subCategory = FALSE;
                    }
                    /**
                     * END
                     */
                    /**
                     * Thực hiện tìm ra tổng số item tương ứng với danh_muc_id cha cấp cao, 
                     * cùng với tổng số item tương ứng với toàn bô subcatgory con thuộc danh_muc cấp cha này
                     * BEGIN
                     */
                    $number = $this->countItemInCategory($modelJoin, $findSubCategory);
                    /**
                     * END
                     */
                    $response[] = array(
                        'id' => (int) $item[$modelName]['id'],
                        'type' => $item[$modelName]['type'],
                        'name' => $item[$modelName]['name'],
                        'thumbnail_image_link' => $item[$modelName]['thumbnail_image_path'],
                        'number' => $number,
                        'description' => $item[$modelName]['description'],
                        'forum_link' => $item[$modelName]['forum_link'],
                        'total_page' => ceil($number / $number_per_page),
                        'sub_category' => $subCategory,
                    );
                }
            }
        }
        echo json_encode($response);

//        }
    }

    /**
     * countItemInCategory method
     * @param string $countModel - tên Model cần thực hiện count
     * @param array $danh_muc_id - mảng array chứa các id của các Danh mục 
     * @return int - trả về tổng số phần tử
     */
    protected function countItemInCategory($countModel, $danh_muc_id) {
        $countItem = 0;
        $options = array();
        $this->$countModel->recursive = -1;
        $options['fields'] = 'DISTINCT ' . $countModel . '.id';
        $options['conditions'][$countModel . '.status'] = 2;

        if ($countModel == self::Game) {
            $options['conditions'][$countModel . '.danh_muc_id'] = $danh_muc_id;

            // thực hiện đếm các item chỉ liên quan tới thiết bị device đang truy cập hiện tại
            $this->parseDeviceSup($options, $countModel);

            $countItem = $this->$countModel->find('count', $options);
        } elseif ($countModel == self::ProductDistribution) {
            $options['joins'] = $this->joinsProduct2ProductDanhMuc;
            $options['conditions'][self::ProductDanhMuc . '.danh_muc_id'] = $danh_muc_id;

            // thực hiện đếm các item chỉ liên quan tới thiết bị device đang truy cập hiện tại
            $this->parseDeviceSup($options, $countModel);

            $countItem = $this->$countModel->find('count', $options);
        } elseif ($countModel == self::News) {
            $options['conditions'][$countModel . '.danh_muc_id'] = $danh_muc_id;

            $countItem = $this->$countModel->find('count', $options);
        }

        return $countItem;
    }

    /**
     * GET_THE_LOAI?type=xx&danh_muc_id=xx&page=xx&number_per_page=xxx
      - danh_muc_id: id của danh mục
      - page: Là trang cụ thể  cần lấy dữ liệu, nếu ko có thì tham số này, thì lấy tất cả thể loại tương ứng với danh mục id;
      - number_per_page: số phần tử 1 trang, nếu không có tham số này, thì trả về mặc định 15 phần record. (thường thể loại ko có nhiều, tối đa là 15, còn đa số là dưới 10).
     */
    public function getTheLoai() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
        $modelName = self::TheLoai;
        $modelJoin = '';
        $determineDevice = 0;
        $this->$modelName->recursive = -1;
        $response = array();
        $options = array();

        $type = isset($this->request->query['type']) ? $this->request->query['type'] : null;
        $danh_muc_id = isset($this->request->query['danh_muc_id']) ? $this->request->query['danh_muc_id'] : null;
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $number_per_page = isset($this->request->query['number_per_page']) ? $this->request->query['number_per_page'] : null;

        $options['conditions'][$modelName . '.status'] = 2;

        if (!empty($type)) {
            switch ($type):
                case 1:// nếu $type = 1 hoặc 3 thì join với bảng game_app
                    $modelJoin = self::Game;
                    $determineDevice = 'joinsTheLoai2GameApp';
                    $options['joins'] = $this->joinsTheLoai2GameApp;
                    $options['conditions'][$modelJoin . '.type'] = 1;
                    break;
                case 2:// nếu $type = 2 thì join với bảng news
                    $modelJoin = self::News;
                    $options['joins'] = $this->joinsTheLoai2News;
                    break;
                case 3:// nếu $type = 1 hoặc 3 thì join với bảng game_app
                    $modelJoin = self::App;
                    $determineDevice = 'joinsTheLoai2GameApp';
                    $options['joins'] = $this->joinsTheLoai2GameApp;
                    $options['conditions'][$modelJoin . '.type'] = 2;
                    break;
                default :// nếu không có $type thì điều hướng tới notFound
                    $this->redirect(array('action' => 'notFound'));
            endswitch;
        }
        else {
            $this->redirect(array('action' => 'notFound'));
        }

        $options['conditions'][self::TheLoaiRelation . '.type'] = $type;
        $this->determineDevice = $determineDevice;

        if (empty($page)) {
            unset($options['page']);
            unset($options['limit']);
        } elseif (empty($number_per_page)) {
            $options['limit'] = self::Limit;
            $number_per_page = self::Limit;
        } elseif (!empty($page) && !empty($number_per_page)) {
            $options['page'] = $page;
            $options['limit'] = $number_per_page;
        }
        if (!empty($danh_muc_id)) {
            // thực hiện tìm kiếm toàn bộ sub category trong trường hợp $danh_muc_id là danh mục cấp cha
            $danhMucIDs = $this->parseDanhMucID($danh_muc_id);

            $options['conditions'][$modelName . '.danh_muc_id'] = $danhMucIDs;
        } else {
            $this->redirect(array('action' => 'notFound'));
        }

        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents); // thực hiện xác định model name của thiết bị
        // chỉ khi nào xác định được tên model của thiết bị mới truy vấn vào DB để lấy dữ liệu 
        $deviceModel = $findDeviceModel['deviceModel'];
        $this->deviceModel = $deviceModel;
        if ($deviceModel) {
            if ($determineDevice) {
                $this->joinConditions($modelJoin, $determineDevice, $deviceModel);
            }
            $options['fields'] = array($modelName . '.*', 'Count(' . $modelJoin . '.id) AS counter', $modelJoin . '.*', self::Category . '.*');
            $options['order'] = array($modelName . '.order ASC');
            $options['group'] = array($modelName . '.id');

            $findTheLoai = $this->$modelName->find('all', $options);
            if (!empty($findTheLoai)) {
                foreach ($findTheLoai as $item) {
                    $response[] = array(
                        'id' => (int) $item[$modelName]['id'],
                        'name' => $item[$modelName]['name'],
                        'description' => $item[$modelName]['description'],
                        'type' => $type,
                        'danh_muc_id' => $danh_muc_id,
                        'danh_muc_name' => $item[self::Category]['name'],
                        'number' => $item[0]['counter'],
                        'forum_link' => $item[$modelName]['forum_link'],
                        'total_page' => ceil($item[0]['counter'] / $number_per_page),
                    );
                }
            }
        }
        echo json_encode($response);
    }

    /**
     * GET_GOM_EVENT?type=xxx&page=xx&number_per_page=xxx&game_id=xxx&distributor_id=xxx
      - type: loại content có event tương ứng
      - page: Là trang cụ thể cần lấy dữ liệu
      - number_per_page: số phần tử 1 trang, nếu không có tham số này, thì trả về 15 record.
      - game_id: lấy sự kiện tương ứng với game, còn nếu không có trường game id này, thì lấy tất cả các sự kiện và sắp xếp theo thứ thự order và time.
      - distributor_id: là phân phối game, trường hợp ko có tham số này, thì mặc định là distrubutor id = 1.
     */
    public function getGomEvent() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
        $modelName = self::Event;
        $this->$modelName->recursive = -1;
        $response = array();
        $options = array();

        $type = isset($this->request->query['type']) ? $this->request->query['type'] : null;
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $number_per_page = isset($this->request->query['number_per_page']) ? $this->request->query['number_per_page'] : null;
        $game_id = isset($this->request->query['game_id']) ? $this->request->query['game_id'] : null;
        $distributor_id = isset($this->request->query['distributor_id']) ? $this->request->query['distributor_id'] : 1;

        $options['conditions'][$modelName . '.status'] = 2;

        if (!empty($type)) { // chưa có xử lý trong thời điểm hiện tại
        }
        if (empty($page)) {
            unset($options['page']);
            unset($options['limit']);
        } elseif (empty($number_per_page)) {
            $options['limit'] = self::Limit;
            $number_per_page = self::Limit;
        } elseif (!empty($page) && !empty($number_per_page)) {
            $options['page'] = $page;
            $options['limit'] = $number_per_page;
        }
        if (!empty($game_id)) {
            $options['conditions'][$modelName . '.game_app_id'] = $game_id;
        }
        if (!empty($distributor_id)) {
            $options['joins'] = $this->joinsGameEvent2GameApp;
            $options['conditions'][self::Game . '.distributor_id'] = $distributor_id;
        }

        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents); // thực hiện xác định model name của thiết bị
        // chỉ khi nào xác định được tên model của thiết bị mới truy vấn vào DB để lấy dữ liệu 
        $deviceModel = $findDeviceModel['deviceModel'];
        $this->deviceModel = $deviceModel;
        if ($deviceModel) {
            $options['fields'] = array($modelName . '.*', self::Game . '.*');
            // sắp xếp theo thứ thự order và time.
            $options['order'] = array($modelName . '.order ASC', $modelName . '.last_update DESC');

            $findGomEvent = $this->$modelName->find('all', $options);

            // tìm tổng số các sự kiện Gom Event
            $totalGomEvent = $this->$modelName->find('count', array(
                'conditions' => array(
                    $modelName . '.status' => 2
                ),
                'fields' => array($modelName . '.id'),
            ));
            $total_page = ceil($totalGomEvent / $number_per_page);

            if (!empty($findGomEvent)) {
                foreach ($findGomEvent as $item) {
                    $start_date = date('d/m/Y h:s', strtotime($item[$modelName]['start_date']));
                    $end_date = date('d/m/Y h:s', strtotime($item[$modelName]['end_date']));
                    $company_id = $item[self::Game]['company_id'];

                    // truy cập vào bảng game_app, lấy ra các thông tin về link_game_logo, game_download_link dựa vào game_app_id
                    $info = $this->getInfoFromGameApp($item[$modelName]['game_app_id'], $findDeviceModel);
                    $response[] = array(
                        'id' => (int) $item[$modelName]['id'],
                        'name' => $item[$modelName]['name'],
                        'short_desciption' => $item[$modelName]['short_decription'],
                        'description' => $item[$modelName]['description'],
                        'game_app_id' => $item[$modelName]['game_app_id'],
                        'link_game_logo' => $info['game_logo_link'],
                        'game_download_link' => $info['game_download_link'],
                        'img_path_1' => $item[$modelName]['image_path_1'],
                        'img_path_2' => $item[$modelName]['image_path_2'],
                        'img_path_3' => $item[$modelName]['image_path_3'],
                        'event_forum_link' => $item[$modelName]['event_forum_link'],
                        'game_forum_link' => $item[$modelName]['game_forum_link'],
                        'company_id' => $company_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'total_page' => $total_page,
                    );
                }
            }
        }
        echo json_encode($response);
    }

    /**
     * Hàm phụ trợ getInfoFromGameApp
     * Hàm lấy các thông tin thêm của getGomEvent, 
     * từ bảng game_event dựa vào game_app_id truy xuất vào bảng game_app, 
     * lấy ra link_game_logo, game_download_link
     * @param int $game_app_id
     * @param array $findDeviceModel
     * @return array
     */
    protected function getInfoFromGameApp($game_app_id, $findDeviceModel) {
        $info = $this->GameApp->find('first', array(
            'conditions' => array(
                'GameApp.id' => $game_app_id,
                'GameApp.status' => 2,
                'LOWER(GameApp.device_support) LIKE ' => '%' . $findDeviceModel['deviceModel'] . '%',
            ),
            'recursive' => -1,
        ));
        if (!empty($info)) {
            $link_game_logo = $info['GameApp']['logo'];
            if ($findDeviceModel['j2meSupport']) {
                $game_download_link = $info['GameApp']['j2me_jar_file_path'];
            } elseif ($findDeviceModel['deviceOS'] == 'android') {
                $game_download_link = $info['GameApp']['android_apk_file_path'];
            } else {
                $game_download_link = '';
            }
            return array(
                'game_logo_link' => $link_game_logo,
                'game_download_link' => $game_download_link,
            );
        } else {
            return array(
                'game_logo_link' => '',
                'game_download_link' => '',
            );
        }
    }

    /**
     * GET_ITEMS?type=xx&danh_muc_id=xx&the_loai_id=xxx&page=xx&distributor_id=xxx&product_id=xxx&page=xx&number_per_page=xxx
      - type: loại content:
      + 1 - Game
      + 2 - News
      + 3 - App
      + 4 - Audio
      + 5 - Book
      - page: Là trang cụ thể  cần lấy dữ liệu.
      - number_per_page: số phần tử 1 trang, nết không có tham số này, thì mặc định là 15 record
      - distributor_id: id công ty phân phối, nếu không có, mặc định nhận giá trị = 1.
      - product_id: id sản phẩm
      - the_loai_id: id của thể loại, nếu không có thì nếu không có, thì trả về game của tất cả thể loại và sắp xếp theo thời gian và order,
      - danh_muc_id: id của danh mục, nếu không có tham số này, thì trả về theo thời gian và order
     * 
     */
    public function getItem() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
        $options = array();
        $response = array();
        $newsImage = array(); // giá trị mặc định của image_link

        $type = isset($this->request->query['type']) ? $this->request->query['type'] : null;
        $danh_muc_id = isset($this->request->query['danh_muc_id']) ? $this->request->query['danh_muc_id'] : null;
        $the_loai_id = isset($this->request->query['the_loai_id']) ? $this->request->query['the_loai_id'] : null;
        $distributor_id = isset($this->request->query['distributor_id']) ? $this->request->query['distributor_id'] : 1;
        $product_distribution_id = isset($this->request->query['product_distribution_id']) ? $this->request->query['product_distribution_id'] : null;
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $number_per_page = isset($this->request->query['number_per_page']) ? $this->request->query['number_per_page'] : null;

// xác định thông tin HTTP_USER_AGENT để xác định thiết bị device đang truy cập
        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents);
        $deviceModel = $findDeviceModel['deviceModel'];

        if (!empty($type)) {
            switch ($type):
                case 1:
                    $modelName = self::Game;
                    if (!empty($danh_muc_id)) {
                        $danhMucIDs = $this->parseDanhMucID($danh_muc_id);
                        $options['conditions'][$modelName . '.danh_muc_id'] = $danhMucIDs;
                    }
                    $options['conditions'][$modelName . '.type'] = 1;
                    if (!empty($the_loai_id)) {
                        $options['conditions'][$modelName . '.the_loai_id'] = $the_loai_id;
                    }
                    $options['conditions'][$modelName . '.distributor_id'] = $distributor_id;
                    $options['joins'] = $this->joinsItems2GameApp;
                    $options['fields'] = array($modelName . '.*', self::Category . '.name', self::TheLoai . '.name', self::Company . '.name');
                    $options['fileds'][] = $modelName . '.download';
                    $this->parseDeviceSup($options, $modelName, $deviceModel);
                    break;
                case 2:
                    $modelName = self::News;
                    if (!empty($danh_muc_id)) {
                        $danhMucIDs = $this->parseDanhMucID($danh_muc_id);
                        $options['conditions'][$modelName . '.danh_muc_id'] = $danhMucIDs;
                    }
                    if (!empty($the_loai_id)) {
                        $options['conditions'][$modelName . '.the_loai_id'] = $the_loai_id;
                    }
                    $options['conditions'][$modelName . '.product_distribution_id'] = $product_distribution_id;
                    $options['joins'] = $this->joinsItems2News;
                    $options['fields'] = array($modelName . '.*', self::Category . '.name', self::TheLoai . '.name');
                    $options['fileds'][] = $modelName . '.number_read';

// nếu là Get_item cho dạng News, thì lấy được về mảng NewsImage tương ứng với từng News.id
                    $newsImage = $this->getNewsImageFromNews();
                    break;
                case 3:
                    $modelName = self::App;
                    if (!empty($danh_muc_id)) {
                        $danhMucIDs = $this->parseDanhMucID($danh_muc_id);
                        $options['conditions'][$modelName . '.danh_muc_id'] = $danhMucIDs;
                    }
                    $options['conditions'][$modelName . '.type'] = 2;
                    if (!empty($the_loai_id)) {
                        $options['conditions'][$modelName . '.the_loai_id'] = $the_loai_id;
                    }
                    $options['conditions'][$modelName . '.distributor_id'] = $distributor_id;
                    $options['joins'] = $this->joinsItems2GameApp;
                    $options['fields'] = array($modelName . '.*', self::Category . '.name', self::TheLoai . '.name', self::Company . '.name');
                    $options['fileds'][] = $modelName . '.download';
                    $this->parseDeviceSup($options, $modelName, $deviceModel);
                    break;
                default :
                    $this->redirect(array('action' => 'notFound'));
            endswitch;
        } else {
            $this->redirect(array('action' => 'notFound'));
        }
        $options['conditions'][$modelName . '.status'] = 2;

        $this->$modelName->recursive = -1;
        if (empty($page)) {
            unset($options['page']);
            unset($options['limit']);
        } elseif (empty($number_per_page)) {
            $options['limit'] = self::Limit;
            $number_per_page = self::Limit;
        } elseif (!empty($page) && !empty($number_per_page)) {
            $options['page'] = $page;
            $options['limit'] = $number_per_page;
        }

// chỉ khi nào xác định được tên model của thiết bị mới truy vấn vào DB để lấy dữ liệu 
        if ($deviceModel) {
            $options['order'] = array($modelName . '.last_update DESC', $modelName . '.order ASC');
            $findItems = $this->$modelName->find('all', $options);
            unset($options['page']);
            unset($options['limit']);
            unset($options['fields']);
            $options['fields'] = $modelName . '.id';
            $totalItems = $this->$modelName->find('count', $options);
            $total_page = ceil($totalItems / $number_per_page);
            if (!empty($findItems)) {
                foreach ($findItems as $item) {
                    $id = (int) $item[$modelName]['id'];
                    if (isset($item[$modelName]['name'])) {
                        $name = $item[$modelName]['name'];
                    } elseif (isset($item[$modelName]['subject'])) {
                        $name = $item[$modelName]['subject'];
                    } else {
                        $name = '';
                    }
                    if (isset($item[$modelName]['short_description'])) {
                        $short_description = $item[$modelName]['short_description'];
                    } elseif (isset($item[$modelName]['short_body'])) {
                        $short_description = $item[$modelName]['short_body'];
                    } else {
                        $short_description = '';
                    }
                    if (isset($item[$modelName]['description'])) {
                        $description = $item[$modelName]['description'];
                    } elseif (isset($item[$modelName]['body'])) {
                        $description = $item[$modelName]['body'];
                    } else {
                        $description = '';
                    }
                    if (isset($item[self::Category]['name'])) {
                        $danh_muc_name = $item[self::Category]['name'];
                    } else {
                        $danh_muc_name = '';
                    }
                    if (isset($item[self::TheLoai]['name'])) {
                        $the_loai_name = $item[self::TheLoai]['name'];
                    } else {
                        $the_loai_name = '';
                    }
                    if (isset($item[$modelName]['download'])) {
                        $used_number = $item[$modelName]['download'];
                    } elseif (isset($item[$modelName]['number_read'])) {
                        $used_number = $item[$modelName]['number_read'];
                    } else {
                        $used_number = '';
                    }
                    $logo_link = isset($item[$modelName]['logo']) ? $item[$modelName]['logo'] : '';
                    $img_path_1 = isset($item[$modelName]['img_path_1']) ? $item[$modelName]['img_path_1'] : '';
                    $img_path_2 = isset($item[$modelName]['img_path_2']) ? $item[$modelName]['img_path_2'] : '';
                    $img_path_3 = isset($item[$modelName]['img_path_3']) ? $item[$modelName]['img_path_3'] : '';

// nếu là Get Item cho News
                    if (is_array($newsImage) && !empty($newsImage)) {
// thực hiện trích xuất ra các dữ liệu cần thiết cần có trong image_link
                        if (!empty($newsImage[$id])) {
                            $image_link['total_link'] = count($newsImage[$id]);
                            foreach ($newsImage[$id] as $key => $value) {
                                $image_link['link_' . ((int) $key + 1)] = $value;
                            }
                        } else {
                            $image_link = -1;
                        }
                    } else {
                        $image_link = -1;
                    }

                    $download_link = '';
                    $total_comment = 0;
                    $forum_link = isset($item[$modelName]['forum_link']) ? $item[$modelName]['forum_link'] : '';
                    $company_id = isset($item[$modelName]['company_id']) ? $item[$modelName]['company_id'] : '';
                    $company_name = isset($item[self::Company]['name']) ? $item[self::Company]['name'] : '';
                    $version = isset($item[$modelName]['version']) ? $item[$modelName]['version'] : '';
                    $device_support = isset($item[$modelName]['device_support']) ? $item[$modelName]['device_support'] : '';

                    $response[] = array(
                        'id' => $id,
                        'name' => $name,
                        'short_description' => $short_description,
                        'description' => $description,
                        'danh_muc_id' => $danh_muc_id,
                        'danh_muc_name' => $danh_muc_name,
                        'the_loai_id' => $the_loai_id,
                        'the_loai_name' => $the_loai_name,
                        'used_number' => $used_number,
                        'logo_link' => $logo_link,
                        'img_path_1' => $img_path_1,
                        'img_path_2' => $img_path_2,
                        'img_path_3' => $img_path_3,
                        'image_link' => $image_link,
                        'download_link' => $download_link,
                        'total_page' => $total_page,
                        'total_comment' => $total_comment,
                        'forum_link' => $forum_link,
                        'company_id' => $company_id,
                        'company_name' => $company_name,
                        'version' => $version,
                        'device_support' => $device_support
                    );
                }
            }
        }
        return json_encode($response);
    }

    /**
     * GET_GOM_NEWS?danh_muc_id=xx&the_loai=xxx&page=xx&number_per_page=xxx&product_distribution_id=xxx
      - page: Là trạng cụ thể cần lấy dữ liệu.
      - product_distribution_id: id sản phẩm, nếu không có giá trị này, thì trả về toàn bộ danh sách news theo thứ tự thời gian.
      - number_per_page: số phần tử 1 trang, nết không có tham số này, thì trả về tất cả.
      - the_loai_id: id của thể loại, nếu không có thì trả về tất cả tức điều kiện search ko có trường này.
      - danh_muc_id: id của danh mục, nếu không có tham số này thỉ trả về tât cả tức ko có điều kiện search theo danh mục, và sắp xếp theo theo thời gian và order
     */
    public function getNews() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
        $options = array();
        $response = array();
        $modelName = self::News;

        $danh_muc_id = isset($this->request->query['danh_muc_id']) ? $this->request->query['danh_muc_id'] : null;
        $the_loai_id = isset($this->request->query['the_loai_id']) ? $this->request->query['the_loai_id'] : null;
        $product_distribution_id = isset($this->request->query['product_distribution_id']) ? $this->request->query['product_distribution_id'] : null;
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $number_per_page = isset($this->request->query['number_per_page']) ? $this->request->query['number_per_page'] : null;

        $options['conditions'][$modelName . '.status'] = 2;
        $options['order'] = array($modelName . '.last_update DESC', $modelName . '.order');
        $options['fields'] = array($modelName . '.*', self::Category . '.*', self::TheLoai . '.*', self::TheLoaiRelation . '.*');

        $this->$modelName->recursive = -1;
        if (empty($page)) {
            unset($options['page']);
            unset($options['limit']);
        } elseif (empty($number_per_page)) {
            $options['limit'] = self::Limit;
            $number_per_page = self::Limit;
        } elseif (!empty($page) && !empty($number_per_page)) {
            $options['page'] = $page;
            $options['limit'] = $number_per_page;
        }
        /**
         * Xử lý liên quan tới danh mục - danh mục có thể phân thành nhiều cấp
         * BEGIN
         */
        if (!empty($danh_muc_id)) {
            // thực hiện lấy ra toàn bộ danh_muc_id có liên quan tới danh_muc_id hiện tại, do danh_muc_id hiện tại có thể là danh mục cấp cha
            $danhMucIDS = $this->parseDanhMucID($danh_muc_id);
            $options['conditions'][$modelName . '.danh_muc_id'] = $danhMucIDS;
        }
        /**
         * END
         */
        if (!empty($the_loai_id)) {
            $options['conditions'][self::TheLoaiRelation . '.the_loai_id'] = $the_loai_id;
        }
        if (!empty($product_distribution_id)) {
            $options['conditions'][$modelName . '.product_distribution_id'] = $product_distribution_id;
        }
        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents); // thực hiện xác định model name của thiết bị
        // chỉ khi nào xác định được tên model của thiết bị mới truy vấn vào DB để lấy dữ liệu 
        $deviceModel = $findDeviceModel['deviceModel'];
        $this->deviceModel = $deviceModel;
        if ($deviceModel) {
            $options['joins'] = $this->joinsNews;
            $findNews = $this->$modelName->find('all', $options);
//            debug($findNews);

            /**
             * Tính tổng số tin News
             * BEGIN
             */
            unset($options['page']);
            unset($options['limit']);
            unset($options['fields']);
            unset($options['joins']);
            unset($options['conditions'][self::TheLoaiRelation . '.the_loai_id']);
            $options['fields'] = $modelName . '.id';
            $totalNews = $this->$modelName->find('count', $options);
//            debug($options);
//            debug($totalNews);
            $total_page = ceil($totalNews / $number_per_page);
            /**
             * END
             */
            // lấy các ảnh news images có liên quan tới từng news
            $newsImage = $this->getNewsImageFromNews();

            if (!empty($findNews)) {
                foreach ($findNews as $item) {
                    $id = $item[$modelName]['id'];
                    $name = isset($item[$modelName]['subject']) ? $item[$modelName]['subject'] : '';
                    $short_desciption = isset($item[$modelName]['short_body']) ? $item[$modelName]['short_body'] : '';
                    $description = isset($item[$modelName]['body']) ? $item[$modelName]['body'] : '';
                    if (isset($item[self::Category]['name'])) {
                        $danh_muc_name = $item[self::Category]['name'];
                    } else {
                        $danh_muc_name = '';
                    }
                    if (isset($item[self::TheLoai]['name'])) {
                        $the_loai_name = $item[self::TheLoai]['name'];
                    } else {
                        $the_loai_name = '';
                    }
                    if (empty($danh_muc_id)) {
                        $danh_muc_id = (int) $item[$modelName]['danh_muc_id'];
                    }
                    if (empty($the_loai_id)) {
                        $the_loai_id = (int) $item[self::TheLoai]['id'];
                    }
                    $thumbnail_image_link = '';
                    $content_image_link = array();
                    /**
                     * Lấy các links liên quan tới từng news từ trong bảng gom_news_image
                     * BEGIN
                     */
                    if (is_array($newsImage) && !empty($newsImage)) {
                        // thực hiện trích xuất ra các dữ liệu cần thiết cần có trong image_link
                        $key = (int) $item[$modelName]['id'];

                        if (!empty($newsImage[$key])) {

                            // lấy về news_logo_link
                            $thumbnail_image_link = isset($newsImage[$key]['thumbnail']) ? $newsImage[$key]['thumbnail'] : -1;

                            if (!empty($newsImage[$key]['images'])) {
                                // lấy về tập các ảnh image_link thông thường
                                $content_image_link['total_link'] = count($newsImage[$key]['images']);

                                if (!empty($newsImage[$key]['images'])) {
                                    foreach ($newsImage[$key]['images'] as $index => $value) {
                                        $content_image_link['link_' . ((int) $index + 1)] = $value;
                                    }
                                } else {
                                    unset($content_image_link);
                                    $content_image_link = -1;
                                }
                            } else {
                                unset($content_image_link);
                                $content_image_link = -1;
                            }
                        } else {
                            unset($content_image_link);
                            $content_image_link = -1;
                        }
                    }
                    /**
                     * END
                     */
                    $created_date = isset($item[$modelName]['created_date']) ? date('h:s d/m/Y', strtotime($item[$modelName]['created_date'])) : '';
                    $response[] = array(
                        'id' => (int) $id,
                        'name' => $name,
                        'short_desciption' => $short_desciption,
                        'description' => $description,
                        'danh_muc_id' => $danh_muc_id,
                        'danh_muc_name' => $danh_muc_name,
                        'the_loai_id' => $the_loai_id,
                        'the_loai_name' => $the_loai_name,
                        'thumbnail_image_link' => $thumbnail_image_link,
                        'content_image_link' => $content_image_link,
                        'created_date' => $created_date,
                        'total_page' => $total_page,
                    );
                }
            }
        }

        return json_encode($response);
    }

    /**
     * DOWNLOAD_GOM_ITEM?type=xxx&id=xx&distributor=xxx
      type: 1 - game, 3 - app
      id: là id game hoặc app
      distributor_id: nhà phát hành, nếu ko có tham số này, giá trị mặc định = 1
     */
    public function downloadGomItem() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
        $options = array();
        $linkDownload = '';

        $type = isset($this->request->query['type']) ? $this->request->query['type'] : null;
        $id = isset($this->request->query['id']) ? $this->request->query['id'] : null;
        $distributor_id = isset($this->request->query['distributor_id']) ? $this->request->query['distributor_id'] : 1;

        switch ($type):
            case 1:
                $modelName = self::Game;
                $options['conditions'][$modelName . '.type'] = 1;
                break;
            case 3:
                $modelName = self::App;
                $options['conditions'][$modelName . '.type'] = 2;
                break;
            default :
                $this->redirect(array('action' => 'notFound'));
        endswitch;

        $this->$modelName->recursive = -1;
        $options['conditions'][$modelName . '.status'] = 2;

        if (!empty($id)) {
            $options['conditions'][$modelName . '.id'] = $id;
        } else {
            $this->redirect(array('action' => 'notFound'));
        }
        if (!empty($distributor_id)) {
            $options['conditions'][$modelName . '.distributor_id'] = $distributor_id;
        }

        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents); // thực hiện xác định model name của thiết bị
        // chỉ khi nào xác định được tên model của thiết bị mới truy vấn vào DB để lấy dữ liệu 
        $deviceModel = $findDeviceModel['deviceModel'];
        $this->deviceModel = $deviceModel;
        $this->determineDevice = 1;
        if ($deviceModel) {
            $this->parseDeviceSup($options, $modelName);
            $findItem = $this->$modelName->find('first', $options);
            if ($findDeviceModel['j2meSupport']) {
                $linkDownload = $findItem[$modelName]['j2me_jar_file_path'];
            } elseif ($findDeviceModel['deviceOS'] == 'android') {
                $linkDownload = $findItem[$modelName]['android_apk_file_path'];
            }
        }
        echo $linkDownload;
    }

    /**
     * GET_SUB_CATEGORY?type=xx&page=xx&number_per_page=xxx&danh_muc_id=xxx
      - type: loại content:
      + 1 - Game
      + 2 - News
      + 3 - App
      + 4 - Audio
      + 5- Book
      - page: Là trang cụ thể  cần lấy dữ liệu, nếu ko có thì tham số này, thì lấy tất cả danh mục tương ứng với type;
      - number_per_page: số phần tử 1 trang, nếu không có tham số này, thì trả về mặc định 15 phần record. (thường danh mục ko có nhiều, tối đa là 15, còn đa số là dưới 10)
     */
    public function getSubCategory() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
//        if ($this->request->data) {
        $modelName = self::Category;
        $modelJoin = '';
        $determineDevice = 0;
        $this->$modelName->recursive = -1;
        $response = array();
        $options = array();

        $type = isset($this->request->query['type']) ? $this->request->query['type'] : null;
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $number_per_page = isset($this->request->query['number_per_page']) ? $this->request->query['number_per_page'] : null;
        $danh_muc_id = isset($this->request->query['danh_muc_id']) ? $this->request->query['danh_muc_id'] : null;

        $options['conditions'][$modelName . '.status'] = 2;
        $options['conditions'][$modelName . '.parent_id !='] = 0;
        /**
         * các giá trị type có thể nhận về 
         * 1 game, 
          2 news,
          3 app,
          4 audio,
          5 book,
          6 product distribution

         */
        if (!empty($type)) {
            $options['conditions'][$modelName . '.type'] = $type;
            switch ($type):
                case 1:// nếu $type = 1 hoặc 3 thì join với bảng gam_app
                    $modelJoin = self::Game;
                    $determineDevice = 'joinsDanhMuc2GameApp';
                    $options['joins'] = $this->joinsDanhMuc2GameApp;
                    $this->joinsDanhMuc2GameApp[0]['conditions'][$modelJoin . '.type'] = 1;
                    break;
                case 2:// nếu $type = 2 thì join với bảng news
                    $modelJoin = self::News;
                    $options['joins'] = $this->joinsDanhMuc2News;
                    break;
                case 3:
                    $modelJoin = self::App;
                    $determineDevice = 'joinsDanhMuc2GameApp';
                    $options['joins'] = $this->joinsDanhMuc2GameApp;
                    $this->joinsDanhMuc2GameApp[0]['conditions'][$modelJoin . '.type'] = 2;
                    break;
                default :// nếu không có $type thì điều hướng tới notFound
                    $this->redirect(array('action' => 'notFound'));
            endswitch;
        }
        $this->determineDevice = $determineDevice;
        // nếu ko có thì tham số page, thì lấy tất cả danh mục tương ứng với type;
        if (empty($page)) {
            unset($options['page']);
            unset($options['limit']);
        }
        // nếu không có tham số number_per_page, thì trả về mặc định 15 phần record
        elseif (empty($number_per_page)) {
            $options['limit'] = self::Limit;
            $number_per_page = self::Limit;
        } elseif (!empty($page) && !empty($number_per_page)) {
            $options['page'] = $page;
            $options['limit'] = $number_per_page;
        }

        /**
         * Thực hiện lấy ra toàn bộ subcategory mọi cấp thuộc $danh_muc_id cha này
         * BEGIN
         */
        if (!empty($danh_muc_id)) {
            $danhMucIDs = $this->parseDanhMucID($danh_muc_id);
            array_pop($danhMucIDs);
            $options['conditions'][$modelName . '.id'] = $danhMucIDs;
        } else {
            $this->redirect(array('action' => 'notFound'));
        }
        /**
         * END
         */
        // xác định thông tin HTTP_USER_AGENT để xác định thiết bị device đang truy cập
        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents);
        $deviceModel = $findDeviceModel['deviceModel'];
        $this->deviceModel = $deviceModel;
        // chỉ khi nào xác định được tên model của thiết bị mới truy vấn vào DB để lấy dữ liệu 
        if ($deviceModel) {
            // nếu cần phải xác dịnh rõ loại thiết bị khi $determineDevice khác 0
//            if ($determineDevice) {
//                $this->joinConditions($modelJoin, $determineDevice, $deviceModel);
//            }
//            $options['fields'] = array($modelName . '.*', 'Count(' . $modelJoin . '.id) AS counter');
//            $options['order'] = array($modelName . '.order ASC');
            $options['group'] = array($modelName . '.id');
            $findCategory = $this->$modelName->find('all', $options);
            if (!empty($findCategory)) {
                foreach ($findCategory as $item) {
                    /**
                     * xác định xem danh mục có subcategory hay không
                     * BEGIN
                     */
//                    $parent_id = $item[$modelName]['parent_id'];
                    $id = (int) $item[$modelName]['id'];

                    $findSubCategory = $this->parseDanhMucID($id);
                    if (count($findSubCategory) <= 1) {
                        $subCategory = FALSE;
                    } else {
                        $subCategory = TRUE;
                    }

                    /**
                     * END
                     */
                    /**
                     * Thực hiên đếm số phần tử trong category
                     * nếu category này có subcategory, thì thực hiện đếm item có trong các subcategory của nó
                     * BEGIN
                     */
                    $number = $this->countItemInCategory($modelJoin, $findSubCategory);
                    /**
                     * END
                     */
                    $response[] = array(
                        'id' => (int) $item[$modelName]['id'],
                        'type' => $item[$modelName]['type'],
                        'name' => $item[$modelName]['name'],
                        'number' => $number,
                        'description' => $item[$modelName]['description'],
                        'forum_link' => $item[$modelName]['forum_link'],
                        'total_page' => ceil($number / $number_per_page),
                        'sub_category' => $subCategory,
                    );
                }
            }
        }
        echo json_encode($response);

//        }
    }

    /**
     * GET_GAME?danh_muc_id=xx&the_loai_id=xxx&page=xx&distributor_id=xxx&page=xx&number_per_page=xxx
      - page: Là trang cụ thể  cần lấy dữ liệu.
      - number_per_page: số phần tử 1 trang, nết không có tham số này, thì mặc định là 15 record
      - distributor_id: id công ty phân phối, nếu không có, mặc định nhận giá trị = 1.
      - the_loai_id: id của thể loại, nếu không có thì trả về tất cả tức điều kiện search ko có trường này.
      - danh_muc_id: id của danh mục, nếu không có tham số này thỉ trả về tât cả tức ko có điều kiện search theo danh mục, và sắp xếp theo theo thời gian và order
     */
    public function getGame() {
        header('Access-Control-Allow-Origin: *');
        $this->autoRender = FALSE;
        $options = array();
        $response = array();
        $modelName = self::Game;
        $this->$modelName->recursive = -1;

        $danh_muc_id = isset($this->request->query['danh_muc_id']) ? $this->request->query['danh_muc_id'] : null;
        $the_loai_id = isset($this->request->query['the_loai_id']) ? $this->request->query['the_loai_id'] : null;
        $distributor_id = isset($this->request->query['distributor_id']) ? $this->request->query['distributor_id'] : 1;
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $number_per_page = isset($this->request->query['number_per_page']) ? $this->request->query['number_per_page'] : null;

        // nếu ko có thì tham số page, thì lấy tất cả danh mục tương ứng với type;
        if (empty($page)) {
            unset($options['page']);
            unset($options['limit']);
        }
        // nếu không có tham số number_per_page, thì trả về mặc định 15 phần record
        elseif (empty($number_per_page)) {
            $options['limit'] = self::Limit;
            $number_per_page = self::Limit;
        } elseif (!empty($page) && !empty($number_per_page)) {
            $options['page'] = $page;
            $options['limit'] = $number_per_page;
        }
        $options['conditions'][$modelName . '.status'] = 2;
        $options['conditions'][$modelName . '.type'] = 1;
        $options['conditions'][$modelName . '.distributor_id'] = $distributor_id;
        $options['joins'] = $this->joinsGameApp2TheLoaiRelation;
        $options['fields'] = array($modelName . '.*', self::TheLoai . '.*',
            self::Category . '.*', self::Company . '.*', self::TheLoaiRelation . '.*',
        );
        if (!empty($danh_muc_id)) {
            $danhMucIDs = $this->parseDanhMucID($danh_muc_id);
            $options['conditions'][$modelName . '.danh_muc_id'] = $danhMucIDs;
        }
        if (!empty($the_loai_id)) {
            $modelJoin = self::TheLoaiRelation;
            $options['conditions'][$modelJoin . '.the_loai_id'] = $the_loai_id;
        }

        // xác định thông tin HTTP_USER_AGENT để xác định thiết bị device đang truy cập
        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        $findDeviceModel = $this->getDeviceModel($userAgents);
        $deviceModel = $findDeviceModel['deviceModel'];
        $this->deviceModel = $deviceModel;
        $this->determineDevice = 1;
        if ($deviceModel) {
            $this->parseDeviceSup($options, $modelName);
            $findGame = $this->$modelName->find('all', $options);
            $total_page = ceil(count($findGame) / $number_per_page);
            if (!empty($findGame)) {
                foreach ($findGame as $item) {
                    $id = $item[$modelName]['id'];
                    $name = $item[$modelName]['name'];
                    $short_description = $item[$modelName]['short_decription'];
                    $description = $item[$modelName]['description'];
                    $danh_muc_id = !empty($danh_muc_id) ? $danh_muc_id : $item[$modelName]['danh_muc_id'];
                    $danh_muc_name = !empty($item[self::Category]['name']) ? $item[self::Category]['name'] : '';
                    $the_loai_id = !empty($the_loai_id) ? $the_loai_id : $item[self::TheLoaiRelation]['the_loai_id'];
                    $the_loai_name = !empty($item[self::TheLoai]['name']) ? $item[self::TheLoai]['name'] : '';
                    $total_download = $item[$modelName]['total_download'];
                    $logo_link = $item[$modelName]['logo'];
                    $image_path_1 = $item[$modelName]['image_path_1'];
                    $image_path_2 = $item[$modelName]['image_path_2'];
                    $image_path_3 = $item[$modelName]['image_path_3'];
                    if ($findDeviceModel['j2meSupport']) {
                        $download_link = $item[$modelName]['j2me_jar_file_path'];
                        $store_id = '';
                    } elseif ($findDeviceModel['deviceOS'] == 'android') {
                        $download_link = $item[$modelName]['android_apk_file_path'];
                        $store_id = $item[$modelName]['android_store_id'];
                    } elseif ($findDeviceModel['deviceOS'] == 'windows phone os') {
                        $download_link = '';
                        $store_id = $item[$modelName]['windows_store_id'];
                    } elseif ($findDeviceModel['deviceOS'] == 'ios') {
                        $download_link = '';
                        $store_id = $item[$modelName]['iphone_store_id'];
                    } else {
                        $download_link = '';
                        $store_id = '';
                    }
                    $total_comment = 0;
                    $forum_link = $item[$modelName]['forum_link'];
                    $company_id = $item[$modelName]['company_id'];
                    $company_name = $item[self::Company]['name'];
                    $version = $item[$modelName]['version'];
                    $device_support = $item[$modelName]['device_support'];

                    $response[] = array(
                        'id' => $id,
                        'name' => $name,
                        'short_description' => $short_description,
                        'description' => $description,
                        'danh_muc_id' => $danh_muc_id,
                        'danh_muc_name' => $danh_muc_name,
                        'the_loai_id' => $the_loai_id,
                        'the_loai_name' => $the_loai_name,
                        'total_download' => $total_download,
                        'logo_link' => $logo_link,
                        'image_path_1' => $image_path_1,
                        'image_path_2' => $image_path_2,
                        'image_path_3' => $image_path_3,
                        'download_link' => $download_link,
                        'store_id' => $store_id,
                        'total_page' => $total_page,
                        'total_comment' => $total_comment,
                        'forum_link' => $forum_link,
                        'company_id' => $company_id,
                        'company_name' => $company_name,
                        'version' => $version,
                        'device_support' => $device_support,
                    );
                }
            }
        }
        echo json_encode($response);
    }

    /**
     * notFound action
     * Khi tham số truyền vào không hợp lệ, sẽ bị điều hướng tới action này
     * @return string 
     */
    public function notFound() {
        $finNewsImage = $this->News->find('all', array(
            'conditions' => array(
                'News.status !=' => -1
            ),
//            'fields' => array('News.*', 'NewsImage.*')
        ));
//        debug($finNewsImage);
        $target = array();
        foreach ($finNewsImage as $item) {
            foreach ($item['NewsImage'] as $child) {
                $target[$item['News']['id']][] = $child['file_path'] . $child['name'];
            }
        }
        debug($target);
        die;
    }

    /**
     * phương thức lấy toàn bộ ảnh NewsImage theo từng bài News
     * 
     * @return array $target
     * có cấu trúc dạng sau:
     * array(
     * 'News.id1' => array(
     *                  'thumbail' => 'thumbail1',
     *                  'images' => array(    
     *                                    0 => 'newimage1.1',
     *                                    1 => 'newimage1.2'
     *                                    )
     *                     ),
     * 'News.id2' => array(
     *                  'thumbail' => 'thumbail2',
     *                  'images' => array(    
     *                                    0 => 'newimage2.1',
     *                                    1 => 'newimage2.2'
     *                                    )
     *                     ),
     * )
     */
    protected function getNewsImageFromNews() {
        $this->News->contain('NewsImage');
        $finNewsImage = $this->News->find('all', array(
            'conditions' => array(
                'News.status' => 2,
            ),
        ));
        $target = array();
        foreach ($finNewsImage as $item) {
            foreach ($item['NewsImage'] as $child) {
                $key = (int) $item['News']['id'];
                if ($child['is_thumbnail'] == 0) {
                    $target[$key]['images'][] = $child['file_path'] . $child['name'];
                } elseif ($child['is_thumbnail'] == 1) {
                    $target[$key]['thumbnail'] = $child['file_path'] . $child['name'];
                }
            }
        }
//        debug($target);
        return $target;
    }

    /**
     * beforeFilter kế thừa hàm beforeFilter callback của CakePHP
     * cho phép request 1 cách public tới các action mà sẽ cung cấp JSON API cho ứng dụng
     * Tức không bắt buộc phải login mới được truy cập
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getCategory', 'getTheLoai', 'getGomEvent', 'getItem', 'notFound', 'getNews', 'downloadGomItem', 'getSubCategory', 'getGame'); // tên các action được public
    }

    /**
     * lấy về tên model của thiết bị dựa vào bộ mã nguồn mở TeraWurfl
     * phương thức getDeviceModel
     * @param string $userAgents - chính là $_SERVER['HTTP_USER_AGENT']
     * @return string or không lấy được tên của thiết bị thì trả về FALSE
     */
    protected function getDeviceModel($userAgents) {
        App::import('Vendor', 'TeraWurfl');
        App::import('Vendor', 'TeraWurfl', array('file' => 'TeraWurfl' . DS . 'TeraWurfl.php'));
        $teraWURFL = new TeraWurfl();
        $userAgents = $_SERVER['HTTP_USER_AGENT'];
        if ($teraWURFL->getDeviceCapabilitiesFromAgent($userAgents)) {
            // xác định tên model của thiết bị, để thực hiện tìm kiếm trong device_support
            $deviceModel = $teraWURFL->getDeviceCapability("model_name");
            // xác định thiết bị có hỗ trợ j2me hay không
            $j2meSupport = $teraWURFL->getDeviceCapability("j2me_midp_1_0");
            // xác định hệ điều hành của thiết bị
            $deviceOS = $teraWURFL->getDeviceCapability('device_os');

            return array(
                'deviceModel' => strtolower($deviceModel),
                'j2meSupport' => $j2meSupport,
                'deviceOS' => strtolower($deviceOS),
            );
        } else {
            return FALSE;
        }
    }

    /**
     * Phương thức lấy ra toàn bộ id cấp con dựa vào $danh_muc_id
     * @param int $danh_muc_id 
     * @return array 
     */
//    protected function parseDanhMucID($danh_muc_id) {
//        $DanhMuc = self::Category;
//        $parent_refs = array();
//        $child_list = array();
//        $target = array();
//        $findSub = $this->$DanhMuc->find('all', array(
//            'fields' => array($DanhMuc . '.id', $DanhMuc . '.parent_id'),
//            'conditions' => array($DanhMuc . '.status' => 2),
//            'recursive' => -1,
//        ));
//        if (!empty($findSub)) {
//            foreach ($findSub as $data) {
//                $id = (int) $data[$DanhMuc]['id'];
//                $parent_id = (int) $data[$DanhMuc]['parent_id'];
//                $thisitem = &$parent_refs[$id];
////            $thisitem['parent_id'] = $parent_id;
////            $thisitem['id'] = $id;
//                if ($parent_id == $thisitem) {
//                    $child_list[$id] = &$thisitem;
//                } else {
//                    $parent_refs[$parent_id][$id] = &$thisitem;
//                }
//            }
//            // loại bỏ trường hợp khi category là cấp cha cao nhất - tức là có $parent_id  = 0
//            if (!empty($parent_refs[$danh_muc_id])) {
//                $target = $this->array_keys_multi($parent_refs[$danh_muc_id]);
//            }
//            $target[] = $danh_muc_id;
//        }
//        return $target;
//    }

    /**
     * parseDeviceSup method
     * thực hiện tự động tạo ra điều kiện conditions device_support gắn kết với
     * nhận dạng của thiết bị device đang truy cập hiện tại
     * @param array &$options
     * @param string $modelName
     */
    protected function parseDeviceSup(&$options, $modelName) {
        if ($this->determineDevice) {
            $options['conditions']['LOWER(' . $modelName . '.device_support) LIKE '] = '%' . $this->deviceModel . '%';
        }
    }

    /**
     * phương thức joinConditions
     * Thực hiện thêm các điều kiện join cần thiết giữa các bảng có quan hệ với nhau
     * mục đích để lọc ra các dữ liệu có device_support tương ứng với tên model của thiết bị
     * @param string $modelName - tên Model cần thao tác truy vấn
     * @param string $deviceModel - tên model của thiết bị
     */
    protected function joinConditions($modelName, $joinName, $deviceModel) {
        foreach ($this->$joinName as $key => $item) {
            if ($item['alias'] == $modelName) {
                $this->{$joinName}[$key]['conditions']['LOWER(' . $modelName . '.device_support) LIKE '] = '%' . $deviceModel . '%';
                break;
            }
        }
    }

}
