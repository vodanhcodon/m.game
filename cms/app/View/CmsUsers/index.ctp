<?php
$status = Configure::read('gom.status');
?>
<style>
/*    .span12{
        margin-left: 0px !important;
    }*/
</style> 
<fieldset>
    <?php
    echo $this->Form->create('Search', array(
        'url' => array('action' => 'search', 'controller' => 'CmsUsers')
    ));
    ?>
    <legend>Danh sách tài khoản</legend>
    <div class="row-fluid">

        <div class="span4">
            <?php
            echo $this->Form->input('Search.user_name', array(
                'label' => 'Tên'
            ))
            ?>
        </div>
        <div class="span4">
            <?php
            echo $this->Form->input('Search.company_id', array(
                'label' => 'Tên công ty',
                'empty' => '---------Chọn tất cả---------',
                'options' => $companys,
            ))
            ?>

        </div>
        <div class="span4">
            <?php
            echo $this->Form->input('Search.type', array(
                'label' => 'Kiểu tài khoản',
                'empty' => '---------Chọn tất cả---------',
                'options' => Configure::read('gom.cmsuser.type'),
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
                    'label' => FALSE,
                    'div' => FALSE,
                ))
                ?>
                <?php echo $this->element('add'); ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end() ?>
</fieldset>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td width="6%">Mã số ID</td>
            <td>Tên người dùng</td>
            <td>Kiểu tài khoản</td>
            <td>Công ty</td>
            <td>Trạng thái</td>
            <td>Thao tác</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <?php
            $acctypes = Configure::read('gom.cmsuser.type');
            ?>
            <tr>
                <td><?php echo (int) $user['CmsUser']['id'] ?></td>
                <td><?php echo $user['CmsUser']['user_name'] ?></td>
                <td><?php echo $acctypes[$user['CmsUser']['type']] ?></td>
                <td><?php echo $user['Company']['name'] ?></td>
                <td><?php echo $status[$user['CmsUser']['status']] ?></td>
                <td class="action">
                    <?php
                    echo $this->Html->link(null, array(
                        'action' => 'edit', (int) $user['CmsUser']['id']), array('title' => 'Chỉnh sửa', 'class' => 'icon-edit'))
                    ?>
                    <?php
                    echo $this->Form->postLink(null, array('action' => 'delete',
                        (int) $user['CmsUser']['id']), array('title' => 'Xóa', 'class' => 'icon-trash'), 'Bạn có chắc chắn muốn xóa người dùng ' . $user['CmsUser']['user_name'])
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php echo $this->element('pager'); ?>
