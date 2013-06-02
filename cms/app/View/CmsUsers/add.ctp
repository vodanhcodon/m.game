<div class="row-fluid">
    <?php echo $this->Form->create('CmsUser'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <div class="row-fluid">
            <div class="span4">
                <?php
                echo $this->Form->input('user_name');
                ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('status', array(
                    'label' => 'Trạng thái',
                    'options' => Configure::read('gom.status'),
                    'default' => 1,
                ));
                ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('type', array(
                    'options' => Configure::read('gom.cmsuser.type'),
                    'default' => 2,
                    'label' => 'Loại tài khoản'
                ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <?php
                echo $this->Form->input('password', array(
                    'label' => 'Mật khẩu',
                ));
                ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('company_id', array(
                    'options' => $companys,
                    'empty' => '---'
                ));
                ?>
            </div>
        </div>
    </fieldset>
    <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
    <?php echo $this->Form->end(); ?>
</div>