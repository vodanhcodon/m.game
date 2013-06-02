<div class="row-fluid">
    <?php // echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('CmsUser'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php
        echo $this->Form->input('user_name');
        echo $this->Form->input('password');
        ?>
    </fieldset>
    <?php echo $this->Form->button(__('Đăng nhập'), array('label' => false, 'id' => 'submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'div' => false)); ?>
    <?php echo $this->Form->end(); ?>
</div>