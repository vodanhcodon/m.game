<div class="row-fluid">
    <fieldset>
        <legend>Danh sách tài khoản</legend>
    </fieldset>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td>Mã số ID</td>
                <td>Tên người dùng</td>
                <td>Kiểu tài khoản</td>
                <td>Công ty</td>
                <td>Thao tác</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->request->data as $user): ?>
                <?php
                $acctypes = Configure::read('gom.cmsuser.type');
                ?>
                <tr>
                    <td><?php echo (int) $user['CmsUser']['id'] ?></td>
                    <td><?php echo $user['CmsUser']['user_name'] ?></td>
                    <td><?php echo $acctypes[$user['CmsUser']['type']] ?></td>
                    <td><?php echo $user['Company']['name'] ?></td>
                    <td class="action">
                        <?php echo $this->Html->link(null, array('action' => 'edit', (int) $user['CmsUser']['id']), array('title' => 'Chỉnh sửa', 'class' => 'icon-edit')) ?>
                        <?php echo $this->Form->postLink(null, array('action' => 'delete', (int) $user['CmsUser']['id']), array('title' => 'Xóa', 'class' => 'icon-trash'), 'Bạn có chắc chắn muốn xóa người dùng #' . (int) $user['CmsUser']['id']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->element('add'); ?>
</div>
<?php echo $this->element('pager'); ?>
