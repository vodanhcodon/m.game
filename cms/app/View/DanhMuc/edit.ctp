<div class="row-fluid">
    <?php echo $this->Form->create('DanhMuc'); ?>
    <fieldset>
        <legend><?php echo __('Chỉnh sửa danh mục'); ?></legend>
        <div class="span4">
            <?php echo $this->Form->input('name', array('label' => 'Tên danh mục')); ?>
            <label>Thông tin mô tả</label>
            <?php
            echo $this->Form->textarea('description', array('label' => 'Thông tin mô tả', 'escaped' => false));
            echo $this->Form->input('order', array('label' => 'Thứ tự sắp xếp'));
            ?>
            <label>Đường dẫn forum link</label>
            <?php
            echo $this->Form->textarea('forum_link', array('label' => 'Đường dẫn forum link', 'escaped' => false));
            echo $this->Form->input('status', array(
                'options' => Configure::read('gom.status'),
                'label' => 'Trạng thái',
                'div' => false
            ));
            echo $this->Form->input('type', array(
                'options' => Configure::read('gom.DanhMuc.type'),
                'empty' => '---',
                'label' => 'Kiểu phân loại',
                'div' => false
            ));
            ?>
        </div>
        <div class="span4">
            <?php
            echo $this->Form->input('parent_id', array(
                'options' => $optsDanhMuc,
                'label' => 'Phân cấp danh mục',
            ));
            ?>
        </div>
    </fieldset>
    <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
    <?php echo $this->Form->end(); ?>
</div>