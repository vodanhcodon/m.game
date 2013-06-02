<?php
$status = Configure::read('gom.status');
$pageinfo = $this->Paginator->params();
$stt = ($pageinfo['page'] - 1) * $pageinfo['limit'];
?>
<?php
echo $this->element('update_list');
?>
<fieldset>
    <legend>Danh sách Product Distribution</legend>
</fieldset>
<div class="row-fluid">
    <?php
    echo $this->Form->create('ProductDistribution', array(
        'url' => array(
            'controller' => 'ProductDistribution',
            'action' => 'search',
        )
    ));
    ?>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.name', array(
                    'type' => 'text',
                    'label' => __('Tên game'),
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
                        )
                );
                ?>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.status', array(
                    'options' => $status,
                    'label' => __('Trạng thái'),
                    'empty' => '---------Chọn tất cả---------')
                )
                ?>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.type', array(
                    'options' => Configure::read('gom.platform'),
                    'label' => __('platform'),
                    'empty' => '---------Chọn tất cả---------')
                )
                ?>
            </div>
        </div>
        <!--
       <div class="span4">
          
           <div class="control-group">
        <?php
        /**
         * Xóa bỏ thể loại
         * BEGIN
         */
//                echo $this->Form->input('Search.the_loai_id', array(
//                    'options' => $theloai,
//                    'label' => __('Thể loại'),
//                    'empty' => '---------Chọn tất cả---------')
//                )
        /**
         * END
         */
        ?>
           </div>
        
       </div>
        -->
        <div class="span4">
            <div class="control-group">
                <?php
                echo $this->Form->input('Search.company_id', array(
                    'options' => $company, 'label' => __('Tên công ty'),
                    'empty' => '---------Chọn tất cả---------')
                )
                ?>
            </div>
        </div>
        <div class="span8">
            <div class="control-group">
                <?php
                echo $this->Form->button(__('Tìm'), array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary'
                    , 'id' => 'search',
                ))
                ?>
                <?php echo $this->element('add'); ?>
            </div>
        </div>

    </div>
    <?php echo $this->Form->end(); ?>
    <div class="row-fluid">
        <div class="span12">
            <span class="label label-success">Tổng số product distribution đang public</span>&nbsp;&nbsp;&nbsp;<span class="badge badge-success">
                <?php echo empty($public) ? 0 : $public; ?>
            </span>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <span class="label label-warning">Tổng số product distribution đang chờ duyệt</span>&nbsp;&nbsp;&nbsp;<span class="badge badge-warning">
                <?php echo empty($waiting) ? 0 : $waiting; ?>
            </span>
        </div>
    </div>

</div>
<?php
echo $this->Form->create('UpdateList', array(
    'url' => array(
        'controller' => 'ProductDistribution',
        'action' => 'updateList',
    ),
    'type' => 'post',
    'id' => 'updateList',
));
?>
<table class="table table-striped table-bordered table-hover sortable">
    <thead>
        <tr>
            <td>STT</td>
            <td>Tên app</td>
            <td>Danh Mục</td>
            <!-- xóa bỏ thể loại -->
<!--            <td>Thể Loại</td>-->
            <td>Máy hỗ trợ</td>
            <td>Download</td>
            <td>Thứ tự</td>
            <td>Trạng thái</td>
            <td>Thao tác</td>
        </tr>
    </thead>
    <tbody>

        <?php if (!empty($apps)): ?>
            <?php foreach ($apps as $app): ?>
                <?php $stt++; ?>
                <?php $id = (int) $app['ProductDistribution']['id']; ?>
                <tr>
                    <td>
                        <?php echo $stt; ?>
                        <?php echo $this->Form->hidden($id . '.ProductDistribution.id', array('value' => $id)); ?>
                        <?php echo $this->element('referer_link'); ?>
                    </td>
                    <td><?php echo $app['ProductDistribution']['name'] ?>
                    </td>
                    <td><?php
                        echo $this->Form->input($id . '.ProductDanhMuc.danh_muc_id', array(
                            'label' => false,
                            'div' => false,
                            'options' => $danhmuc,
                            'value' => isset($opts_danhmuc[$id]) ? $opts_danhmuc[$id] : '',
                            'multiple' => 'multiple',
                            'data-role' => 'multiselect',
//                            'name' => 'data[' . $id . '][ProductDanhMuc][danh_muc_id]',
                            'hiddenField' => false
                        ))
                        ?>
                    </td>
                    <!-- xóa bỏ thể loại
                    <td><?php
//                    echo $this->Form->input($id . '.TheLoaiRelation.the_loai_id', array(
//                        'label' => false,
//                        'div' => false,
//                        'options' => $theloai,
//                        'value' => $opts_theloai[$id],
//                        'multiple' => 'multiple',
//                        'data-role' => 'multiselect',
//                    ))
                    ?>
                    </td>
                    -->
                    <td><?php echo $app['ProductDistribution']['device_support'] ?>
                    </td>
                    <td><?php echo empty($app['ProductDistribution']['download']) ? 0 : $app['ProductDistribution']['download'] ?>
                    </td>
                    <?php if (empty($admin)): ?>
                        <td class="order"><?php
                            echo $this->Form->input($id . '.ProductDistribution.order', array(
                                'options' => $orders,
                                'default' => $app['ProductDistribution']['order'],
                                'label' => false,
                                'disabled' => 'disabled',
                                'div' => false
                            ));
                            ?></td>
                    <?php else : ?>
                        <td class="order"><?php
                            echo $this->Form->input($id . '.ProductDistribution.order', array(
                                'options' => $orders,
                                'default' => $app['ProductDistribution']['order'],
                                'label' => false,
                                'div' => false
                            ));
                            ?></td>
                    <?php endif; ?>
                    <?php if (empty($admin)): ?>
                        <td><?php
                            echo $this->Form->input($id . '.ProductDistribution.status', array(
                                'options' => $status,
                                'default' => $app['ProductDistribution']['status'],
                                'label' => false,
                                'disabled' => 'disabled',
                                'div' => false
                            ));
                            ?></td>
                    <?php else: ?>
                        <td><?php
                            echo $this->Form->input($id . '.ProductDistribution.status', array(
                                'options' => $status,
                                'default' => $app['ProductDistribution']['status'],
                                'label' => false,
                                'div' => false
                            ));
                            ?></td>
                    <?php endif; ?>
                    <td class="action"><?php echo $this->Html->link(null, array('action' => 'edit', (int) $app['ProductDistribution']['id']), array('title' => 'Chỉnh sửa', 'class' => 'icon-edit')) ?>
                        <?php if ($admin == 0 && in_array($id, $appPublic)): ?>
                            <?php echo $this->Html->link(null, '#', array('title' => 'Bạn không có quyền xóa game này', 'class' => 'icon-warning-sign')) ?>  
                        <?php else : ?>
                            <?php echo $this->Html->link(null, array('action' => 'delete', (int) $app['ProductDistribution']['id']), array('title' => 'Xóa', 'class' => 'icon-trash remove')) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php // echo $this->Form->hidden($id . '.ProductDistribution.last_update'); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php echo $this->Form->end(); ?>
<div class="form-actions">
    <?php echo $this->Form->hidden('ProductDistribution.submitflag', array('value' => 'search', 'id' => 'submitflag')) ?>
    <?php echo $this->Form->button(__('Thay đổi'), array('class' => array('btn', 'btn-primary'), 'type' => 'submit', 'id' => 'update')); ?>&nbsp;

</div>
<!--<input type="hidden" value="search" id="submitflag" />-->


<?php echo $this->element('pager'); ?>