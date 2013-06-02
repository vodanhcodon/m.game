<style>
    /*    .span12{
            margin-left: 0px !important;
        }*/
</style> 
<div class="row-fluid">
    <fieldset>
        <legend>Danh sách thể loại</legend>
    </fieldset>
    <?php
    echo $this->Form->create('Search', array(
        'url' => array('action' => 'search', 'controller' => 'TheLoai')
    ));
    ?>
    <div class="row-fluid">
        <div class="span1">
            <label>Tên</label>
        </div>
        <div class="span3">
            <?php
            echo $this->Form->input('Search.name', array(
                'label' => false,
            ))
            ?>
        </div>
        <div class="span1">
            <label>Trạng thái</label>
        </div>
        <div class="span3">
            <?php
            echo $this->Form->input('Search.status', array(
                'label' => false,
                'options' => Configure::read('gom.status'),
                'empty' => '---------Chọn tất cả---------',
            ))
            ?>
        </div>
        <div class="span1">
            <label>Danh mục</label>
        </div>
        <div class="span3">
            <?php
            echo $this->Form->input('Search.danh_muc_id', array(
                'label' => false,
                'options' => $danhmuc,
                'empty' => '---------Chọn tất cả---------',
            ))
            ?>
        </div>
        <div class="span12">
            <div class="control-group">
                <?php
                echo $this->Form->button(__('Tìm'), array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                    'id' => 'search',
                ))
                ?>
                <?php echo $this->element('add'); ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
    <?php echo $this->Form->create('TheLoai'); ?>
    <table class="table table-striped table-bordered table-hover sortable">
        <thead>
            <tr>
                <td>ID</td>
                <td>Tên thể loại</td>
                <td>Thứ tự sắp xếp</td>
                <td width="10%">forum link</td>
                <td>Ngày tạo</td>
                <td>Ngày cập nhật</td>
                <td>Trạng thái</td>
                <td width="15%">Thuộc danh mục</td>
                <td width="6%">Thao tác</td>

            </tr>
        </thead>
        <tbody>
            <?php
            $status = Configure::read('gom.status');
//            $types = Configure::read('gom.TheLoai.type');
            ?>
            <?php foreach ($TheLoais as $TheLoai): ?>
                <?php $id = (int) $TheLoai['TheLoai']['id']; ?>
                <tr>
                    <td><?php echo (int) $TheLoai['TheLoai']['id'] ?>
                        <?php echo $this->Form->hidden($id . '.TheLoai.id', array('value' => $id)); ?>
                    </td>
                    <td><?php echo $TheLoai['TheLoai']['name'] ?>
                    </td>
                    <?php if (empty($admin)): ?>
                        <td class="order"><?php
                            echo $this->Form->input($id . '.TheLoai.order', array(
                                'options' => $orders,
                                'default' => $TheLoai['TheLoai']['order'],
                                'label' => false,
//                                'disabled' => 'disabled',
                                'div' => false
                            ));
                            ?></td>
                    <?php else : ?>
                        <td class="order"><?php
                            echo $this->Form->input($id . '.TheLoai.order', array(
                                'options' => $orders,
                                'default' => $TheLoai['TheLoai']['order'],
                                'label' => false,
                                'div' => false
                            ));
                            ?></td>
                    <?php endif; ?>
                    <td><a href="<?php echo $TheLoai['TheLoai']['forum_link'] ?>"
                           title="Đường dẫn link tới forum"><?php echo $TheLoai['TheLoai']['forum_link'] ?>
                        </a>
                    </td>
                    <td><?php echo $TheLoai['TheLoai']['created_date'] ?>
                    </td>
                    <td><?php echo $TheLoai['TheLoai']['last_update'] ?>
                    </td>
                    <?php if (empty($admin)): ?>
                        <td><?php
                            echo $this->Form->input($id . '.TheLoai.status', array(
                                'options' => $status,
                                'default' => $TheLoai['TheLoai']['status'],
                                'label' => false,
                                'class' => 'input-medium',
                                'disabled' => 'disabled'
                            ));
                            ?></td>
                        <td><?php
                            echo $this->Form->input($id . '.TheLoai.type', array(
                                'options' => $types,
                                'default' => $TheLoai['TheLoai']['type'],
                                'label' => false,
                                'class' => 'input-medium',
//                                'disabled' => 'disabled'
                            ));
                            ?></td>
                    <?php else: ?>
                        <td><?php
                            echo $this->Form->input($id . '.TheLoai.status', array(
                                'options' => $status,
                                'default' => $TheLoai['TheLoai']['status'],
                                'label' => false,
                                'class' => 'input-medium',
                            ));
                            ?></td>
                        <td><?php
                            echo $this->Form->input($id . '.TheLoai.danh_muc_id', array(
                                'options' => $danhmuc,
                                'default' => $TheLoai['TheLoai']['danh_muc_id'],
                                'label' => false,
                                'class' => 'input-medium',
                            ));
                            ?></td>
                    <?php endif; ?>
                    <td class="action"><?php echo $this->Html->link(null, array('action' => 'edit', (int) $TheLoai['TheLoai']['id']), array('title' => 'Chỉnh sửa', 'class' => 'icon-edit')) ?>
                        <?php echo $this->Html->link(null, array('action' => 'delete', (int) $TheLoai['TheLoai']['id']), array('title' => 'Xóa', 'class' => 'icon-trash remove')) ?>
                    </td>
                </tr>
                <?php echo $this->Form->hidden($id . '.TheLoai.last_update'); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="form-actions">
        <?php echo $this->Form->button(__('Thay đổi'), array('class' => array('btn', 'btn-primary'), 'type' => 'submit', 'id' => 'update')); ?>

    </div>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pager'); ?>