<div class="row-fluid">
    <?php echo $this->Form->create('Company'); ?>
    <fieldset>
        <legend><?php echo ($this->action == 'add') ? __('Thêm mới company') : __('Chỉnh sửa company'); ?></legend>
        <?php
        echo $this->Form->input('name', array(
            'label' => 'Tên company',
        ));
        ?>
        <div class="input">
            <label>Mô tả</label>
            <?php
            echo $this->Form->textarea('description', array(
                'escaped' => false,
                'class' => 'span6',
                'rows' => 5,
            ));
            ?>
        </div>
    </fieldset>
    <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
    <?php echo $this->Form->end(); ?>
</div>