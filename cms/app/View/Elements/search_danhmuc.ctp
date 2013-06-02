<?php
// xử lý tham số đầu vào
$type = isset($type) ? $type : '';
?>
<?php
echo $this->Form->create('Search', array(
    'url' => array(
        'controller' => 'DanhMuc',
        'action' => 'index',
    ),
));
?>
<div class="span12">
    <div class="row-fluid">
        <div class="span1">
            <p>Danh Mục</p>
        </div>
        <div class="span3">
            <?php
            echo $this->Form->input('Search.parent_id', array(
                'options' => $options,
                'empty' => '---------Chọn tất cả---------',
                'label' => false,
            ));
            ?>
        </div>
        <div class="span1">
            <p>Trạng thái</p>
        </div>
        <div class="span3">
            <?php
            echo $this->Form->input('Search.status', array(
                'options' => Configure::read('gom.status'),
                'empty' => '---------Chọn tất cả---------',
                'label' => false,
            ));
            echo $this->Form->hidden('Search.type', array(
                'value' => $type_danhmuc,
                'class' => 'type_danhmuc',
            ));
            ?>
        </div>
        <div class="span1">
            <?php
            echo $this->Form->button(__('Tìm'), array(
                'type' => 'submit',
                'class' => 'btn btn-primary',
                'id' => 'search',
            ))
            ?>
        </div>
        <div class="span2">
            <?php
            echo $this->Html->link('Thêm mới', array('action' => 'add',$type), array('title' => 'Thêm mới', 'class' => 'btn btn-success')
            )
            ?>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>