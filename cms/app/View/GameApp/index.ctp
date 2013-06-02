<?php
$status = Configure::read('gom.status');
$types = Configure::read('gom.GameApp.type');

$pageinfo = $this->Paginator->params();
$stt = ($pageinfo['page'] - 1) * $pageinfo['limit'];
?>
<?php
echo $this->element('update_list');
?>
<style>
    select.input-medium{
        max-width: 200px;
    }
</style>
<fieldset>
    <legend>Danh sách Game</legend>

    <div class="row-fluid">
        <?php
        echo $this->Form->create('GameApp', array(
            'url' => array('action' => 'search', 'controller' => 'GameApp')
        ));
        ?>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <?php echo $this->Form->input('Search.name', array('type' => 'text', 'label' => __('Tên game'))) ?>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo $this->Form->input('Search.danh_muc_id', array('options' => $danhmuc, 'label' => __('Danh mục'), 'empty' => '---------Chọn tất cả---------')) ?>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo $this->Form->input('Search.status', array('options' => $status, 'label' => __('Trạng thái'), 'empty' => '---------Chọn tất cả---------')) ?>
                </div>
            </div>
        </div>


        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <?php echo $this->Form->input('Search.type', array('options' => $types, 'label' => __('Loại'), 'empty' => '---------Chọn tất cả---------')) ?>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo $this->Form->input('Search.the_loai_id', array('options' => $theloai, 'label' => __('Thể loại'), 'empty' => '---------Chọn tất cả---------')) ?>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php if ($admin): ?>
                        <?php
                        echo $this->Form->input('Search.company_id', array(
                            'options' => $company,
                            'label' => __('Tên công ty'),
                            'empty' => '---------Chọn tất cả---------',
                        ))
                        ?>
                    <?php else : ?>
                        <?php
                        echo $this->Form->input('Search.company_id', array(
                            'options' => $company,
                            'label' => __('Tên công ty'),
//                            'disabled' => true,
                        ))
                        ?>
                    <?php endif; ?>

                </div>
            </div>
            <div class="span8">
                <div class="control-group">
                    <?php echo $this->Form->button(__('Tìm'), array('type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'search')) ?>
                    <?php echo $this->element('add'); ?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
        <div class="row-fluid">
            <div class="span12">
                <span class="label label-success">Tổng số game đang public</span>&nbsp;&nbsp;&nbsp;<span class="badge badge-success"><?php echo empty($public) ? 0 : $public; ?></span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <span class="label label-warning">Tổng số game đang chờ duyệt</span>&nbsp;&nbsp;&nbsp;<span class="badge badge-warning"><?php echo empty($waiting) ? 0 : $waiting; ?></span>
            </div>
        </div>

    </div>

    <?php
    echo $this->Form->create('UpdateList', array(
        'url' => array(
            'controller' => 'GameApp',
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
                <td width="12%">Tên game</td>
                <td>Danh Mục</td>
                <td>Thể Loại</td>
                <td>Máy hỗ trợ</td>
                <td width="5%">Download</td>
                <td width="5%">Thứ tự</td>
                <td>Trạng thái</td>
                <td width="6%">Thao tác</td>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($games)): ?>
                <?php foreach ($games as $game): ?>
                    <?php $stt++; ?>
                    <?php
                    $id = (int) $game['GameApp']['id'];
                    $type = $game['GameApp']['type'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $stt; ?>
                            <?php echo $this->Form->hidden($id . '.GameApp.id', array('value' => $id)); ?>
                            <?php echo $this->Form->hidden($id . '.GameApp.type', array('value' => $type)); ?>
                        </td>
                        <td><?php echo $game['GameApp']['name'] ?>
                        </td>
                        <td><?php
                            echo $this->Form->input($id . '.GameApp.danh_muc_id', array(
                                'label' => false,
                                'div' => false,
                                'options' => ($type == 1) ? $danhmuc_game : $danhmuc_app,
                                'value' => $game['GameApp']['danh_muc_id'],
                                'class' => 'input-medium',
                            ));
                            ?>
                        </td>
                        <td><?php
                            echo $this->Form->input($id . '.TheLoaiRelation.the_loai_id', array(
                                'label' => false,
                                'div' => false,
                                'options' => $theloai,
//                            'value' => $game['GameApp']['the_loai_id'],
                                'value' => isset($opts_theloai[$id]) ? $opts_theloai[$id] : '',
                                'multiple' => 'multiple',
                                'data-role' => 'multiselect',
                                'hiddenField' => false
                            ));
                            ?>
                        </td>
                        <td><?php echo $game['GameApp']['device_support'] ?>
                        </td>
                        <td><?php echo empty($game['GameApp']['download']) ? 0 : $game['GameApp']['download'] ?>
                        </td>
                        <?php if (empty($admin)): ?>
                            <td class="order"><?php
                                echo $this->Form->input($id . '.GameApp.order', array(
                                    'options' => $orders,
                                    'default' => $game['GameApp']['order'],
                                    'label' => false,
//                                'disabled' => 'disabled',
                                    'div' => false
                                ));
                                ?></td>
                        <?php else : ?>
                            <td class="order"><?php
                                echo $this->Form->input($id . '.GameApp.order', array(
                                    'options' => $orders,
                                    'default' => $game['GameApp']['order'],
                                    'label' => false,
                                    'div' => false
                                ));
                                ?></td>
                        <?php endif; ?>
                        <?php if (empty($admin)): ?>
                            <td><?php
                                echo $this->Form->input($id . '.GameApp.status', array(
                                    'options' => $status,
                                    'default' => $game['GameApp']['status'],
                                    'label' => false,
                                    'disabled' => 'disabled',
                                    'div' => false
                                ));
                                ?></td>
                        <?php else: ?>
                            <td><?php
                                echo $this->Form->input($id . '.GameApp.status', array(
                                    'options' => $status,
                                    'default' => $game['GameApp']['status'],
                                    'label' => false,
                                    'div' => false
                                ));
                                ?></td>
                        <?php endif; ?>
                        <td class="action"><?php
                            echo $this->Html->link(null, array(
                                'action' => 'edit',
                                (int) $game['GameApp']['id']), array('title' => 'Chỉnh sửa',
                                'class' => 'icon-edit',
                            ));
                            ?>
                            <?php if ($admin == 0 && in_array($id, $gamePublic)): ?>
                                <?php echo $this->Html->link(null, '#', array('title' => 'Bạn không có quyền xóa game này', 'class' => 'icon-warning-sign')) ?>  
                            <?php else : ?>
                                <?php echo $this->Html->link(null, array('action' => 'delete', (int) $game['GameApp']['id']), array('title' => 'Xóa', 'class' => 'icon-trash remove')) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php // echo $this->Form->hidden($id . '.GameApp.last_update'); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo $this->Form->end(); ?>
    <div class="form-actions">
        <?php echo $this->Form->hidden('GameApp.submitflag', array('value' => 'search', 'id' => 'submitflag')) ?>
        <?php echo $this->Form->button(__('Thay đổi'), array('class' => array('btn', 'btn-primary'), 'type' => 'submit', 'id' => 'update')); ?>

    </div>
    <!--<input type="hidden" value="search" id="submitflag" />-->
</fieldset>
<?php echo $this->element('pager'); ?>