<div class="row-fluid">
    <?php echo $this->Form->create('DanhMuc'); ?>
    <fieldset>
        <legend>Danh sách danh mục</legend>
    </fieldset>
    <table class="table table-striped table-bordered table-hover sortable">
        <thead>
            <tr>
                <td>Mã số ID</td>
                <td>Tên danh mục</td>
                <td>Thông tin mô tả</td>
                <td>Thứ tự sắp xếp</td>
                <td>Đường dẫn forum link</td>
                <td>Ngày tạo</td>
                <td>Ngày cập nhật</td>
                <td>Trạng thái</td>
                <td>Kiểu Phân loại</td>
                <td>Thao tác</td>

            </tr>
        </thead>
        <tbody>
            <?php
            $status = Configure::read('gom.status');
            $types = Configure::read('gom.DanhMuc.type');
            ?>

            <?php foreach ($danhmucs as $danhmuc): ?>
                <?php $id = (int) $danhmuc['DanhMuc']['id']; ?>
                <tr>
                    <td><?php echo (int) $danhmuc['DanhMuc']['id'] ?>
                        <?php echo $this->Form->hidden($id . '.DanhMuc.id', array('value' => $id)); ?>
                    </td>
                    <td><?php echo $danhmuc['DanhMuc']['name'] ?>
                    </td>
                    <td><?php echo $danhmuc['DanhMuc']['description'] ?>
                    </td>
                    <?php if (empty($admin)): ?>
                        <td class="order"><?php
                            echo $this->Form->input($id . '.DanhMuc.order', array(
                                'options' => $orders,
                                'default' => $danhmuc['DanhMuc']['order'],
                                'label' => false,
//                                'disabled' => 'disabled',
                                'div' => false
                            ));
                            ?></td>
                    <?php else : ?>
                        <td class="order"><?php
                            echo $this->Form->input($id . '.DanhMuc.order', array(
                                'options' => $orders,
                                'default' => $danhmuc['DanhMuc']['order'],
                                'label' => false,
                                'div' => false
                            ));
                            ?></td>
                    <?php endif; ?>
                    <td><a href="<?php echo $danhmuc['DanhMuc']['forum_link'] ?>" title="Đường dẫn link tới forum"><?php echo $danhmuc['DanhMuc']['forum_link'] ?></a>
                    </td>
                    <td><?php echo $danhmuc['DanhMuc']['created_date'] ?>
                    </td>
                    <td><?php echo $danhmuc['DanhMuc']['last_update'] ?>
                    </td>
                    <?php if (empty($admin)): ?>
                        <td><?php
                            echo $this->Form->input($id . '.DanhMuc.status', array(
                                'options' => $status,
                                'default' => $danhmuc['DanhMuc']['status'],
                                'label' => false,
                                'disabled' => 'disabled',
                                'div' => false
                            ));
                            ?></td>
                        <td><?php
                            echo $this->Form->input($id . '.DanhMuc.type', array(
                                'options' => $types,
                                'default' => $danhmuc['DanhMuc']['type'],
                                'label' => false,
//                                'disabled' => 'disabled',
                                'div' => false
                            ));
                            ?></td>
                    <?php else: ?>
                        <td><?php
                            echo $this->Form->input($id . '.DanhMuc.status', array(
                                'options' => $status,
                                'default' => $danhmuc['DanhMuc']['status'],
                                'label' => false,
                                'div' => false
                            ));
                            ?></td>
                        <td><?php
                            echo $this->Form->input($id . '.DanhMuc.type', array(
                                'options' => $types,
                                'default' => $danhmuc['DanhMuc']['type'],
                                'label' => false,
                                'div' => false
                            ));
                            ?></td>
                    <?php endif; ?>
                    <td class="action"><?php echo $this->Html->link(null, array('action' => 'edit', (int) $danhmuc['DanhMuc']['id']), array('title' => 'Chỉnh sửa', 'class' => 'icon-edit')) ?>
                        <?php echo $this->Html->link(null, array('action' => 'delete', (int) $danhmuc['DanhMuc']['id']), array('title' => 'Xóa', 'class' => 'icon-trash remove')) ?>
                    </td>
                </tr>
                <?php echo $this->Form->hidden($id . '.DanhMuc.last_update'); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="form-actions">
        <?php echo $this->Form->button(__('Thay đổi'), array('class' => array('btn', 'btn-primary'), 'type' => 'submit', 'id' => 'update')); ?>
        <?php echo $this->element('add'); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pager'); ?>