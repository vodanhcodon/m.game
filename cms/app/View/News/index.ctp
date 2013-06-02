<?php
$status = Configure::read('gom.status');
$pageinfo = $this->Paginator->params();
$stt = ($pageinfo['page'] - 1) * $pageinfo['limit'];
?>

<?php
echo $this->element('update_list');
?>
<fieldset>
    <legend>Danh sách News</legend>
</fieldset>
<div class="row-fluid">
    <?php echo $this->Form->create('News', array('action' => 'search')); ?>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.title', array(
                    'type' => 'text',
                    'label' => __('Tên news'),
                ))
                ?>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.danh_muc_id', array(
                    'options' => $danhmuc,
                    'label' => __('Danh mục'),
                    'empty' => '---------Chọn tất cả---------',
                ))
                ?>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.status', array(
                    'options' => $status,
                    'label' => __('Trạng thái'),
                    'empty' => '---------Chọn tất cả---------',
                ))
                ?>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.the_loai_id', array(
                    'options' => $theloai,
                    'label' => __('Thể loại'),
                    'empty' => '---------Chọn tất cả---------',
                ))
                ?>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.product_distribution_id', array(
                    'options' => $app,
                    'label' => __('Tên product distribution'),
                    'empty' => '---------Chọn tất cả---------',
                ))
                ?>
            </div>
        </div>
        <div class="span8">
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
    <div class="row-fluid">
        <div class="span12">
            <span class="label label-success">Tổng số news đang public</span>&nbsp;&nbsp;&nbsp;<span class="badge badge-success"><?php echo empty($public) ? 0 : $public; ?></span>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <span class="label label-warning">Tổng số news đang chờ duyệt</span>&nbsp;&nbsp;&nbsp;<span class="badge badge-warning"><?php echo empty($waiting) ? 0 : $waiting; ?></span>
        </div>
    </div>

</div>
<?php
echo $this->Form->create('UpdateList', array(
    'url' => array(
        'controller' => 'News',
        'action' => 'updateList',
    ),
    'id' => 'updateList',
));
?>
<table class="table table-striped table-bordered table-hover sortable">
    <thead>
        <tr>
            <td>STT</td>
            <td>Tiêu đề</td>
            <td>Mô tả ngắn</td>
            <td>Danh Mục</td>
            <td>Thể Loại</td>
            <td>Tên product distribution</td>
            <td>Thứ tự</td>
            <td>Trạng thái</td>
            <td style="width: 6%">Thao tác</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($news)): ?>
            <?php foreach ($news as $new): ?>
                <?php $stt++; ?>
                <?php $id = (int) $new['News']['id']; ?>
                <tr>
                    <td>
                        <?php echo $stt; ?>
                        <?php echo $this->Form->hidden($id . '.News.id', array('value' => $id)); ?>
                    </td>
                    <td><?php echo $new['News']['title'] ?>
                    </td>
                    <td><?php echo $new['News']['short_body'] ?>
                    </td>
                    <td><?php
                        echo $this->Form->input($id . '.News.danh_muc_id', array(
                            'label' => false,
                            'div' => false,
                            'options' => $danhmuc,
                            'value' => $new['News']['danh_muc_id'],
                            'class' => 'input-medium',
                        ))
                        ?>
                    </td>
                    <td><?php
                        echo $this->Form->input($id . '.TheLoaiRelation.the_loai_id', array(
                            'label' => false,
                            'div' => false,
                            'options' => $theloai,
                            'value' => $opts_theloai[$id],
                            'multiple' => 'multiple',
                            'data-role' => 'multiselect',
                            'hiddenField' => false
                        ))
                        ?>
                    </td>
                    <td><?php
                        echo $this->Form->input($id . '.News.product_distribution_id', array(
                            'label' => false,
                            'div' => false,
                            'options' => $app,
                            'value' => $new['News']['product_distribution_id'],
                            'empty' => '------',
                            'class' => 'input-medium',
                        ))
                        ?>
                    </td>
                    <td class="order"><?php
                        echo $this->Form->input($id . '.News.order', array(
                            'options' => $orders,
                            'default' => $new['News']['order'],
                            'label' => false,
                            'div' => false,
                            'class' => 'input-medium',
                        ));
                        ?>
                    </td>
                    <?php if (empty($admin)): ?>
                        <td><?php
                            echo $this->Form->input($id . '.News.status', array(
                                'options' => $status,
                                'default' => $new['News']['status'],
                                'label' => false,
                                'disabled' => 'disabled',
                                'div' => false,
                                'class' => 'input-medium',
                            ));
                            ?></td>
                    <?php else: ?>
                        <td><?php
                            echo $this->Form->input($id . '.News.status', array(
                                'options' => $status,
                                'default' => $new['News']['status'],
                                'label' => false,
                                'div' => false,
                                'class' => 'input-medium',
                            ));
                            ?></td>
                    <?php endif; ?>
                    <td class="action"><?php
                        echo $this->Html->link(null, array('action' => 'edit', (int) $new['News']['id']), array(
                            'title' => 'Chỉnh sửa',
                            'class' => 'icon-edit',
                        ))
                        ?>
                        <?php if ($admin == 0 && in_array($id, $newsPublic)): ?>
                            <?php
                            echo $this->Html->link(null, '#', array(
                                'title' => 'Bạn không có quyền xóa game này',
                                'class' => 'icon-warning-sign',
                            ))
                            ?>  
                        <?php else : ?>
                            <?php
                            echo $this->Html->link(null, array('action' => 'delete', (int) $new['News']['id']), array(
                                'title' => 'Xóa',
                                'class' => 'icon-trash remove',
                            ))
                            ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php // echo $this->Form->hidden($id . '.News.last_update'); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php
echo $this->Form->end();
?>
<div class = "form-actions">
    <?php // echo $this->Form->hidden('News.submitflag', array('value' => 'search', 'id' => 'submitflag')) 
    ?>
    <?php echo $this->Form->button(__('Thay đổi'), array('class' => array('btn', 'btn-primary'), 'type' => 'submit', 'id' => 'update')); ?>

</div>
<!--<input type="hidden" value="search" id="submitflag" />-->
<?php echo $this->element('pager'); ?>