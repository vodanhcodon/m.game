<?php
echo $this->element('jquery_file_upload');
?>
<style>
    .table{
        width: 82.906%;
    }
</style>
<div class="row-fluid">
    <?php echo $this->Form->create('DanhMuc'); ?>
    <fieldset>
        <legend><?php echo __('Thêm mới danh mục'); ?></legend>

        <div class="span12">
            <div class="span4">
                <?php echo $this->Form->input('name', array('label' => 'Tên danh mục')); ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('status', array(
                    'options' => Configure::read('gom.status'),
                    'default' => 1,
                    'label' => 'Trạng thái',
                    'div' => false
                ));
                ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('forum_link', array(
                    'label' => 'Đường dẫn forum link',
                ));
                ?>
            </div>
        </div>
        <div class="span12">
            <div class="span4">
                <?php
                echo $this->Form->input('order', array(
                    'label' => 'Thứ tự sắp xếp',
                ));
                ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('parent_id', array(
                    'options' => $danhmucs,
                    'empty' => '------',
                    'label' => 'Phân cấp danh mục',
                ));
                ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('type', array(
                    'options' => $types,
                    'empty' => '---',
                    'label' => 'Kiểu phân loại',
                    'default' => $default,
//                    'div' => false
                ));
                ?>
            </div>
        </div>
        <div class="span12">
            <label>Ảnh đại diện</label>
            <?php
            echo $this->element('jquery_file_upload_input', array(
                'inputname' => 'data[DanhMuc][image_file_path]',
                'formname' => 'DanhMuc',
                'selectorID' => 'image_file',
                'imagePath' => isset($this->data['DanhMuc']['image_file_path']) ? $this->data['DanhMuc']['image_file_path'] : '',
            ));
            ?>
        </div>
        <div class="span12">
            <label>Ảnh thu nhỏ đại diện</label>
            <?php
            echo $this->element('jquery_file_upload_input', array(
                'inputname' => 'data[DanhMuc][thumbnail_image_path]',
                'formname' => 'DanhMuc',
                'selectorID' => 'thumbnail_image',
                'imagePath' => isset($this->data['DanhMuc']['thumbnail_image_path']) ? $this->data['DanhMuc']['thumbnail_image_path'] : '',
            ));
            ?>
        </div>

        <div class="span12">
            <label>Thông tin mô tả</label>
            <?php
            echo $this->Form->textarea('description', array(
                'label' => 'Thông tin mô tả',
                'escaped' => false,
                'class' => 'span10',
                'rows' => 5,
            ));
            ?>
        </div>
    </fieldset>
    <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
    <?php echo $this->Form->end(); ?>
</div>