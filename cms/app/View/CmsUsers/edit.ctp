<div class="row-fluid">
    <?php echo $this->Form->create('CmsUser'); ?>
    <fieldset>
        <legend><?php echo __('Edit User'); ?></legend>
        <?php
        echo $this->Form->input('user_name');
        echo $this->Form->input('password');
        echo $this->Form->input('type', array(
            'options' => Configure::read('gom.cmsuser.type'),
        ));
        echo $this->Form->input('company_id', array(
            'options' => $companys,
            'empty' => '---'
        ));
        ?>
    </fieldset>
    <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
<?php echo $this->Form->end(); ?>
</div>