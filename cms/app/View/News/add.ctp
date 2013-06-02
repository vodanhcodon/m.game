<?php
$folder = Configure::read('gom.News.folder');
$tmp = $folder['tmp'];
$path = $folder['dir'];
$webroot = $this->webroot;
?>
<?php
echo $this->element('jquery_file_upload');
?>
<style>

</style>
<script>
    $(document).ready(function() {
        $('#submit').on('click', function() {
            $('#news').submit();
        });
    });
</script>
<?php echo $this->Form->create('News', array('id' => 'news')); ?>
<div class="row-fluid">
    <div class="span12">
        <fieldset>
            <legend>
                <?php echo ($this->action == 'add') ? __('Thêm mới bài viết News') : __('Chỉnh sửa bài viết News'); ?>
            </legend>
            <div class="row-fluid">
                <div class="span4">
                    <?php
                    if ($this->action == 'edit') {
                        echo $this->Form->hidden('id');
                    }
                    ?>
                    <?php echo $this->element('referer_link');
                    ?>
                    <?php
                    echo $this->Form->input('title', array(
                        'label' => 'Tên bài viết News',
                        'class' => 'input-xlarge',
                    ));
                    ?>
                </div>
                <div class="span4">
                    <?php
                    echo $this->Form->input('danh_muc_id', array(
                        'label' => __('Danh Mục'),
                        'class' => 'input-xlarge',
                        'options' => $danhmuc,
                    ));
                    ?>
                </div>
                <div class="span4">
                    <label>Ảnh thumbnail</label>
                    <?php
                    echo $this->element('jquery_file_upload_input', array(
                        'inputname' => 'data[NewsImage][image_thumbnail]',
                        'formname' => 'News',
                        'selectorID' => 'image_thumbnail',
                        'imagePath' => isset($image_thumbnail) ? $image_thumbnail : '',
                    ));
                    ?>
                </div>

            </div>
            <div class="row-fluid">
                <div class="span4">
                    <div class="input required">
                        <label>Mô tả ngắn</label>
                        <?php
                        echo $this->Form->textarea('short_body', array(
                            'label' => 'Mô tả ngắn',
                            'escaped' => false,
                            'class' => 'input-xlarge',
                            'rows' => 3,
                        ));
                        ?>
                    </div>
                </div>
                <div class="span4">
                    <div class="row-fluid">
                        <?php
                        echo $this->Form->input('TheLoaiRelation.the_loai_id', array(
                            'label' => __('Thể loại'),
                            'class' => 'input-xlarge',
                            'options' => $theloai,
                            'multiple' => 'multiple',
                            'data-role' => 'multiselect',
                            'hiddenField' => false,
                            'value' => isset($id) ? $opts_theloai[$id] : '',
                        ));
                        ?>
                    </div>
                    <div class="row-fluid">
                        <?php
                        echo $this->Form->input('product_distribution_id', array(
                            'label' => __('Tên product distribution'),
                            'class' => 'input-xlarge',
                            'options' => $app,
                            'empty' => '------',
                        ));
                        ?>
                    </div>
                </div>
                <div class="span4">
                    <label>Ảnh nội dung</label>
                    <?php
                    echo $this->element('jquery_file_upload_input', array(
                        'inputname' => 'data[NewsImage][image_news][]',
                        'formname' => 'News',
                        'selectorID' => 'image_news',
                        'imagePath' => isset($image_news) ? $image_news : '',
                        'singleFileUploads' => 'false',
                        'maxNumberOfFiles' => 10,
                    ));
                    ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span8">
                    <div class="input required">
                        <label>Mô tả</label>
                        <?php
                        echo $this->Form->textarea('body', array(
                            'label' => 'Mô tả',
                            'escaped' => false,
                            'class' => 'span10',
                            'rows' => 3,
                        ));
                        ?>
                    </div>
                </div>
                <div class="span4">
                    <div class="row-fluid">
                        <?php
                        echo $this->Form->input('status', array(
                            'label' => __('Trạng thái'),
                            'class' => 'input-xlarge',
                            'options' => Configure::read('gom.status'),
                            'empty' => '------',
                            'default' => 1,
                        ));
                        ?>
                    </div>
                    <div class="row-fluid">
                        <?php
                        echo $this->Form->input('order', array(
                            'label' => __('Thứ tự sắp xếp'),
                            'class' => 'input-xlarge',
                        ));
                        ?>
                    </div>
                </div>
            </div>

        </fieldset>
    </div>
</div>

<?php echo $this->Form->end();
?>
<?php echo $this->element('actionbar', array('id' => empty($id) ? '' : $id)) ?>
