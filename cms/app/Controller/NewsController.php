<?php

App::uses('AppController', 'Controller');

class NewsController extends AppController {

    public $uses = array(
        'News', 'TheLoai', 'DanhMuc', 'ProductDistribution',
        'NewsImage', 'TheLoaiRelation'
    );

    public function index() {
        $this->setInit();
        
        // đoạn mã tự động xử lý các điều kiện search do người dùng nhập vào
        // can thiệp trực tiếp tới kết quả $this->paginate phân trang hiện tại
        $this->parseUrlParams(array(
            'likea' => array('title'),
            'modelname' => 'News',
            'associated' => 'TheLoaiRelation',
            'subcategories' => 'danh_muc_id', // có thực hiện liên kết với các subcategories của nó
        ));

        $this->paginate['News']['order'] = 'News.order ASC';
        $this->paginate['News']['recursive'] = -1;
        $this->paginate['News']['limit'] = 20;

        $news = $this->paginate('News');
        $this->set('news', $news);

        $ids = Hash::extract($news, '{n}.News.id');
        $opts_theloai = $this->getOptsFromTheLoaiRelation($ids);
        $this->set('opts_theloai', $opts_theloai);

        $this->News->recursive = -1;
        $orders = $this->News->find('list', array(
            'fields' => array('order', 'order'),
            'group' => array('News.order'),
        ));
        $this->set('orders', $orders);

        // lấy ra danh sách game đang là public
        $newsPublics = $this->News->find('all', array(
            'fields' => array('id'),
            'conditions' => array('status' => 2),
            'recursive' => -1,
        ));
        $newsPublics = Hash::extract($newsPublics, '{n}.News.id');
        $this->set('newsPublic', $newsPublics);

        // đếm số tổng số game theo trạng thái status
        $public = $this->News->find('count', array(
            'fields' => 'id',
            'conditions' => array('status' => 2),
        ));

        $waiting = $this->News->find('count', array(
            'fields' => 'id',
            'conditions' => array('status' => 1),
        ));

        $this->set('public', $public);
        $this->set('waiting', $waiting);
    }

    /*
     * phương thức dùng để biến đổi phương thức POST sang kiểu URL của  paginate
     */

    public function search() {
        parent::search();
    }

    public function add() {

        $this->setInit();

        $tmp = Configure::read('gom.tmp');

        // mảng dùng để lưu trữ cấu trúc dữ liệu quan hệ giữa bảng News và NewsImage
        // 2 bảng này có quan hệ 1-n
        $newsImage = array();
        if ($this->request->is('post') || $this->request->is('put')) {

            $dirpath = $this->getDirPath('title');

            // lấy các thông tin dữ liệu có trong bảng News
            if (!empty($this->request->data['News'])) {
                $newsImage['News'] = $this->request->data['News'];
            }

            // lấy các thông tin dữ liệu liên quan tới TheLoaiRelation
            if (!empty($this->request->data['TheLoaiRelation'])) {
                $newsImage['TheLoaiRelation'] = $this->request->data['TheLoaiRelation'];
            }

            if (!empty($this->request->data['NewsImage']['image_thumbnail'])) {
                $name = $this->request->data['NewsImage']['image_thumbnail'];
                $tmp_image_thumbnail = $tmp . $name;
                $target_image_thumbnail = $dirpath . $name;
                $this->copyFile($tmp_image_thumbnail, $target_image_thumbnail);

                $file_type = substr(strrchr($name, '.'), 1);
                $newsImage['NewsImage'][] = array(
                    'file_path' => $dirpath,
                    'file_type' => $file_type,
                    'is_thumbnail' => 1,
                    'name' => $name,
                );
            }
            if (!empty($this->request->data['NewsImage']['image_news'])) {
                $image_news = $this->request->data['NewsImage']['image_news'];
                foreach ($image_news as $item) {
                    $tmp_image_thumbnail = $tmp . $item;
                    $target_image_thumbnail = $dirpath . $item;
                    $this->copyFile($tmp_image_thumbnail, $target_image_thumbnail);

                    $file_type = substr(strrchr($item, '.'), 1);
                    $newsImage['NewsImage'][] = array(
                        'file_path' => $dirpath,
                        'file_type' => $file_type,
                        'is_thumbnail' => 0,
                        'name' => $item,
                    );
                }
            }

            if ($this->News->saveAssociated($newsImage)) {
                $this->Session->setFlash('Bài viết News đã được tạo thành công!');
                $this->deleteAllFile($tmp);
                $this->redirect($this->request->data['referer']);
            } else {
                debug($this->News->validationErrors);
                $this->Session->setFlash('Lỗi, Bài viết News chưa được tạo thành công!');
            }
        }
    }

    public function edit($id = null) {
        $this->News->id = $id;
        if (!$this->News->exists()) {
            throw new NotFoundException(__('Bài viết News không hợp lệ'));
        }
        $image_thumbnail = '';
        $image_news = array();

        $this->NewsImage->recursive = -1;

        $opts_theloai = $this->getOptsFromTheLoaiRelation(array($id));
        $this->set('opts_theloai', $opts_theloai);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->add();
        } else {
            $this->setInit();
            $this->request->data = $this->News->read(null, $id);
        }

        /**
         * Phân biệt xem đâu là ảnh thumbnail, đâu là những ảnh thường liên quan tới news
         * BEGIN
         */
        // tìm kiếm và lấy ra 1 ảnh thumbnail
        $findImageThumbnail = $this->NewsImage->find('first', array(
            'conditions' => array(
                'NewsImage.news_id' => $id,
                'NewsImage.is_thumbnail' => 1,
            ),
        ));
        if (!empty($findImageThumbnail)) {
            $image_thumbnail = $findImageThumbnail['NewsImage']['file_path'] . $findImageThumbnail['NewsImage']['name'];
        }

        // tìm kiếm và lấy ra tập ảnh thường
        $findImageNews = $this->NewsImage->find('all', array(
            'conditions' => array(
                'NewsImage.news_id' => $id,
                'NewsImage.is_thumbnail' => 0,
            ),
        ));
        if (!empty($findImageNews)) {
            foreach ($findImageNews as $item) {
                $image_news[] = $item['NewsImage']['file_path'] . $item['NewsImage']['name'];
            }
        }
        /**
         * END
         */
        $this->set('id', $id);
        $this->set(compact('image_thumbnail', 'image_news'));
        $this->render('add');
    }

    public function delete($id = null) {
        parent::delete($id);
    }

    /**
     * jqueryFileUpload action - hàm ghi đè lại hàm jqueryFileUpload action có sẵn trong AppController
     * Bởi News - NewsImage có xử lý riêng biệt so với hệ thống - cần xóa file vật lý và bản ghi record trong DB
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
            // xóa file ảnh ở thư mục trên ổ cứng
            unlink($delete_link);

            // xóa bản ghi lưu trữ file ảnh trong Database
            // dựa vào đường dẫn chỉ tới file ảnh luôn là duy nhất
            $this->NewsImage->deleteAll(array('CONCAT(NewsImage.file_path,NewsImage.name)' => $delete_link));
        }

        $upload_handler = new UploadHandler($action_link);
    }

    public function beforeFilter() {
        parent::beforeFilter();
    }

    protected function setInit() {
        $types = Configure::read('gom.DanhMuc.type');
        $news_type = array_search('NEWS', $types);

        $trees = $this->getTreeDanhMuc($news_type);
        $danhmuc = $this->buildOptsDanhMuc($trees);
        $this->set('danhmuc', $danhmuc);

        $theloai = $this->getTheLoai();
        $this->set('theloai', $theloai);

        $this->ProductDistribution->recursive = -1;
        $findapp = $this->ProductDistribution->find('all', array(
            'fields' => array('ProductDistribution.id', 'ProductDistribution.name', 'ProductDistribution.status'),
        ));
        $app = array();

        // gắn cứng 1 options là tất cả  
        // --> thể hiện tin tức news có thể thuộc vào bất cứ ProductDistribution nào
        $app[0] = 'Tất cả các Product Distribution';

        $status = Configure::read('gom.status');
        foreach ($findapp as $item) {
            $id = $item['ProductDistribution']['id'];
            $label = $item['ProductDistribution']['name'] . '(' . $status[$item['ProductDistribution']['status']] . ')';
            $app[$id] = $label;
        }

        $this->set('app', $app);
    }

}