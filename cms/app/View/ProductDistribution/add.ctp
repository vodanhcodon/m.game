<?php
echo $this->element('jquery_file_upload');
?>
<style>

</style>
<?php
echo $this->Form->create('ProductDistribution', array(
    'type' => 'file',
    'class' => 'game',
));
?>
<div class="row-fluid">
    <div class="span12">
        <fieldset>
            <legend>
                <?php echo ($this->action == 'add') ? __('Thêm mới product distribution') : __('Chỉnh sửa product distribution'); ?>
                <?php echo $this->element('referer_link'); ?>
            </legend>
            <div class="row-fluid">
                <div class="span4">
                    <?php
                    if ($this->action == 'edit') {
                        echo $this->Form->hidden('id');
                    }
                    ?>
                    <?php
                    echo $this->Form->input('name', array(
                        'label' => 'Tên product distribution',
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('ProductDanhMuc.danh_muc_id', array(
                        'label' => 'Danh mục',
                        'options' => $danhmuc,
                        'value' => isset($id) ? $opts_danhmuc[$id] : '',
                        'class' => 'input-xlarge',
                        'multiple' => 'multiple',
                        'data-role' => 'multiselect',
                    ));
                    ?>
                    <?php
                    /**
                     * Xóa bỏ Thể loại
                     * BEGIN
                     */
//                    echo $this->Form->input('TheLoaiRelation.the_loai_id', array(
//                        'label' => 'Thể loại',
//                        'options' => $theloai,
//                        'class' => 'input-xlarge',
//                        'multiple' => 'multiple',
//                        'data-role' => 'multiselect',
//                    ));
                    /**
                     * END
                     */
                    ?>
                    <?php
                    echo $this->Form->input('company_id', array(
                        'label' => 'Công ty',
                        'options' => $company,
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('distributor_id', array(
                        'label' => 'Nhà cung cấp',
                        'options' => $partner,
                        'class' => 'input-xlarge',
                    ));
                    ?>


                    <div class="input required">
                        <label>Mô tả</label>
                        <?php
                        echo $this->Form->textarea('description', array(
                            'label' => 'Mô tả',
                            'escaped' => false,
                            'class' => 'input-xlarge',
                        ));
                        ?>
                    </div>

                </div>
                <div class="span4">
                    <div class="input file required">
                        <label>Logo</label>
                        <?php
                        echo $this->element('jquery_file_upload_input', array(
                            'selectorID' => 'logo',
                            'formname' => 'ProductDistribution',
                            'inputname' => 'data[ProductDistribution][logo]',
                            'imagePath' => isset($this->data['ProductDistribution']['logo']) ? $this->data['ProductDistribution']['logo'] : '',
                        ));
                        ?>
                    </div>
                    <div class="input file">
                        <label>Ảnh màn hình loading</label>
                        <?php
                        echo $this->element('jquery_file_upload_input', array(
                            'selectorID' => 'load_screen_image',
                            'formname' => 'ProductDistribution',
                            'inputname' => 'data[ProductDistribution][load_screen_image]',
                            'imagePath' => isset($this->data['ProductDistribution']['load_screen_image']) ? $this->data['ProductDistribution']['load_screen_image'] : '',
                        ));
                        ?>
                    </div>
                    <div class="input file">
                        <label>Ảnh mô tả</label>
                        <?php
                        echo $this->element('jquery_file_upload_input', array(
                            'inputname' => 'data[ProductDistribution][image_path][]',
                            'formname' => 'ProductDistribution',
                            'selectorID' => 'image_path',
                            'imagePath' => isset($image_path) ? $image_path : '',
                            'singleFileUploads' => 'false',
                            'limitMultiFileUploads' => 3,
                            'maxNumberOfFiles' => 3,
                        ));
                        ?>
                    </div>
                </div>
                <div class="span4">
                    <?php
                    echo $this->Form->input('platform', array(
                        'options' => Configure::read('gom.platform'),
                        'value' => isset($this->data['ProductDistribution']['platform']) ? $this->data['ProductDistribution']['platform'] : '',
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('version', array(
                        'label' => 'version',
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('price', array(
                        'label' => 'Giá bán',
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <?php
                    // 		echo $this->Form->input('order',array('label' => 'Thứ tự sắp xếp','div'=> false));
                    ?>
                    <div class="input">
                        <?php
                        echo $this->Form->input('app_forum_link', array(
                            'label' => 'Forum link',
                            'type' => 'text',
                            'class' => 'input-xlarge',
                        ));
                        ?>
                    </div>
                    <div class="input required">
                        <label>Máy hỗ trợ</label>
                        <?php
                        echo $this->Form->textarea('device_support', array(
                            'label' => 'Máy hỗ trợ',
                            'escaped' => false,
                            'class' => 'input-xlarge',
                        ));
                        ?>
                    </div>
                    <?php
//                    echo $this->Form->input('type', array('label' => 'Loại', 'options' => Configure::read('gom.ProductDistribution.type'), 'default' => 2, 'class' => 'input-xlarge'));
                    ?>
                    <div class="input file required">
                        <label>File cài đặt</label>
                        <?php
                        echo $this->element('jquery_file_upload_input', array(
                            'inputname' => 'data[ProductDistribution][file_setup][]',
                            'formname' => 'ProductDistribution',
                            'selectorID' => 'file_setup',
                            'maxNumberOfFiles' => 2,
                            'acceptFileTypes' => 'jad|jar|apk',
                            'maxFileSize' => 15 * 1000 * 1000,
                            'imagePath' => isset($file_setup) ? $file_setup : '',
                        ));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="input required">
                        <label>Mô tả ngắn</label>
                        <?php
                        echo $this->Form->textarea('short_decription', array(
                            'label' => 'Mô tả ngắn',
                            'escaped' => false,
                            'class' => 'span6',
                            'rows' => 5,
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
            </div>
        </fieldset>
    </div>
</div>
<?php echo $this->Form->end(); ?>
