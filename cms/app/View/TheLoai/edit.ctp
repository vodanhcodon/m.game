<div class="row-fluid">
    <?php echo $this->Form->create('TheLoai'); ?>
    <fieldset>
        <legend><?php echo __('Chỉnh sửa thể loại'); ?></legend>
        <?php echo $this->Form->input('name', array('label' => 'Tên thể loại')); ?>
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
        echo $this->Form->input('danh_muc_id', array(
//            'options' => Configure::read('gom.TheLoai.type'),
            'options' => $danhmuc,
            'empty' => '---',
            'label' => 'Thuộc danh mục',
            'div' => false
        ));
        ?>
    </fieldset>
    <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
    <?php echo $this->Form->end(); ?>
</div>