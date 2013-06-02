<div class="row-fluid">
    <?php echo $this->Form->create('TheLoai'); ?>
    <?php echo $this->element('referer_link'); ?>
    <fieldset>
        <legend><?php echo __('Thêm mới thể loại'); ?></legend>
        <div class="span12">
            <div class="span4">
                <?php echo $this->Form->input('name', array('label' => 'Tên thể loại')); ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('danh_muc_id', array(
                    'options' => $danhmuc,
                    'empty' => '---',
                    'label' => 'Thuộc danh mục',
                    'div' => false
                ));
                ?>
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
        </div>
        <div class="span12">
            <div class="span4">
                <?php
                echo $this->Form->input('forum_link', array('label' => 'forum link'));
                ?>
            </div>
            <div class="span4">
                <?php
                echo $this->Form->input('order', array('label' => 'Thứ tự sắp xếp'));
                ?>
            </div>
            <div class="span4"></div>
        </div>
        <div class="span12">
            <label>Thông tin mô tả</label>
            <?php
            echo $this->Form->textarea('description', array(
                'label' => 'Thông tin mô tả',
                'escaped' => false,
                'class' => 'span10',
            ));
            ?>
        </div>
    </fieldset>
    <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
    <?php echo $this->Form->end(); ?>
</div>