<?php
echo $this->element('jquery_file_upload');
?>
<style>
    .span12{
        margin-left: 0px !important;
    }
    /*    .fileupload-buttonbar {
            height:  63px;
        }*/
    div.fileupload-progress:empty{
        width: 0px;
    }
</style>
<?php echo $this->Form->create('GameApp', array('class' => 'game')); ?>
<div class="row-fluid">
    <div class="span12">
        <fieldset>
            <legend>
                <?php echo ($this->action == 'add') ? __('Thêm mới GameApp') : __('Chỉnh sửa game'); ?>
                <?php echo $this->element('referer_link'); ?>
            </legend>
            <div class="row-fluid">
                <div class="span4">
                    <?php
                    if ($this->action == 'edit') {
                        echo $this->Form->hidden('id');
                    }
                    ?>
                    <?php echo $this->Form->input('name', array('label' => 'Tên game', 'class' => 'input-xlarge')); ?>
                    <?php
                    echo $this->Form->input('danh_muc_id', array(
                        'label' => 'Danh mục',
                        'options' => $danhmuc,
                        'class' => 'input-xlarge'
                    ));
                    ?>
                    <div class="input">
                        <?php
                        echo $this->Form->input('TheLoaiRelation.the_loai_id', array(
                            'label' => 'Thể loại',
                            'options' => $theloai,
                            'class' => 'input-xlarge',
                            'multiple' => 'multiple',
                            'data-role' => 'multiselect',
                            'hiddenField' => false,
                            'value' => isset($id) ? $opts_theloai[$id] : '',
                        ));
                        ?>
                    </div>

                    <?php
                    echo $this->Form->input('company_id', array(
                        'label' => 'Công ty',
                        'options' => $company,
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('distributor_id', array(
                        'label' => 'Đối tác',
                        'options' => $partner,
                        'class' => 'input-xlarge',
                    ));
                    ?>

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
                </div>
                <div class="span4">
                    <div class="input file required">
                        <label>Logo</label>
                        <?php
                        echo $this->element('jquery_file_upload_input', array(
                            'selectorID' => 'logo',
                            'formname' => 'GameApp',
                            'inputname' => 'data[GameApp][logo]',
                            'imagePath' => isset($this->data['GameApp']['logo']) ? $this->data['GameApp']['logo'] : '',
                        ));
                        ?>
                    </div>
                    <div class="input">
                        <label>Ảnh game</label>
                        <?php
                        echo $this->element('jquery_file_upload_input', array(
                            'inputname' => 'data[GameApp][image_path][]',
                            'formname' => 'GameApp',
                            'selectorID' => 'image_path',
                            'imagePath' => isset($image_path) ? $image_path : '',
                            'singleFileUploads' => 'false',
                            'limitMultiFileUploads' => 3,
                            'maxNumberOfFiles' => 3,
                        ));
                        ?>
                    </div>

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
                        echo $this->Form->input('game_forum_link', array(
                            'label' => 'Forum link',
                            'type' => 'text',
                            'class' => 'input-xlarge',
                        ));
                        ?>
                    </div>
                    <div class="input required">
                        <label>Mô tả ngắn</label>
                        <?php
                        echo $this->Form->textarea('short_decription', array(
                            'label' => 'Mô tả ngắn',
                            'escaped' => false,
                            'class' => 'input-xlarge',
                        ));
                        ?>
                    </div>
                </div>
                <div class="span4">
                    <div class="input required">
                        <?php
                        echo $this->Form->input('platform', array(
                            'label' => 'Platform',
                            'class' => 'input-xlarge',
                            'options' => Configure::read('gom.platform'),
                        ));
                        ?>
                    </div>
                    <?php
                    echo $this->Form->input('type', array(
                        'label' => 'Loại',
                        'options' => Configure::read('gom.GameApp.type'),
                        'default' => 2,
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <div class="input file required">
                        <label>File cài đặt</label>
                        <?php
                        echo $this->element('jquery_file_upload_input', array(
                            'inputname' => 'data[GameApp][file_setup][]',
                            'formname' => 'GameApp',
                            'selectorID' => 'file_setup',
                            'maxNumberOfFiles' => 2,
                            'acceptFileTypes' => 'jad|jar|apk',
                            'maxFileSize' => 15 * 1000 * 1000,
                            'imagePath' => isset($file_setup) ? $file_setup : '',
                        ));
                        ?>
                    </div>
                    <div class="input file required">
                        <?php
                        echo $this->Form->input('android_store_id', array(
                            'label' => 'Android store id',
                            'class' => 'input-xlarge',
                            'type' => 'text',
                            'required' => FALSE,
                        ));
                        ?>
                    </div>
                    <div class="input file required">
                        <?php
                        echo $this->Form->input('windows_store_id', array(
                            'label' => 'Windows store id',
                            'class' => 'input-xlarge',
                            'type' => 'text',
                            'required' => FALSE,
                        ));
                        ?>
                    </div>
                    <div class="input file required">
                        <?php
                        echo $this->Form->input('iphone_store_id', array(
                            'label' => 'Iphone store id',
                            'class' => 'input-xlarge',
                            'type' => 'text',
                            'required' => FALSE,
                        ));
                        ?>
                    </div>
                </div>
                <div class="span12">
                    <div class="input required">
                        <label>Mô tả</label>
                        <?php
                        echo $this->Form->textarea('description', array(
                            'label' => 'Mô tả',
                            'escaped' => false,
                            'class' => 'input-xlarge',
                            'class' => 'span11',
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
