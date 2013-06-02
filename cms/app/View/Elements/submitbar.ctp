<div class="span12">
    <div class="form-actions">
        <?php $submitName = ($this->action == 'add') ? __('Thêm mới') : __('Chỉnh sửa'); ?>
        <?php echo $this->Form->button($submitName, array('label' => false, 'id' => 'submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'div' => false)); ?>
        <?php echo $this->Html->link(__('Danh sách'), array('action' => 'index'), array('class' => 'btn btn-info')); ?>
        <?php if (!empty($id)): ?>
            <?php echo $this->Html->link(__('Xóa'), array('action' => 'delete', $id), array('class' => 'btn btn-danger remove')); ?>
        <?php endif; ?>
    </div>
</div>