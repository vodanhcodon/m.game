<div class="row-fluid">
    <fieldset>
        <legend>Danh sách company</legend>
    </fieldset>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td style="width: 6%">Mã số ID</td>
                <td>Tên Company</td>
                <td style="width: 60%">Mô tả</td>
                <td style="width: 6%">Thao tác</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($company as $item): ?>
                <tr>
                    <td><?php echo $item['Company']['id'] ?></td>
                    <td><?php echo $item['Company']['name'] ?></td>
                    <td><?php echo $item['Company']['description'] ?></td>
                    <td class="action">
                        <?php
                        echo $this->Html->link(null, array(
                            'action' => 'edit',
                            (int) $item['Company']['id']), array('title' => 'Chỉnh sửa', 'class' => 'icon-edit'))
                        ?>
                        <?php
                        echo
                        $this->Form->postLink(null, array('action' => 'delete',
                            (int) $item['Company']['id']), array('title' => 'Xóa', 'class' => 'icon-trash'), 'Bạn có chắc chắn muốn xóa công ty ' . $item['Company']['name'])
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->element('add'); ?>
</div>
<?php echo $this->element('pager'); ?>
