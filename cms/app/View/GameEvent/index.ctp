<?php
$status = Configure::read('gom.status');

$pageinfo = $this->Paginator->params();
$stt = ($pageinfo['page'] - 1) * $pageinfo['limit'];
?>
<script>
    $(document).ready(function() {
        // mã js script dùng để xác định khi nào user nhấn vào nút tìm kiếm hay nút thay đổi
        // khi user ấn vào 1 nút search hay nút update thì 1 thông tin flag sẽ được truyền vào thẻ
        // input hidden có id là submitflag
        $('.btn-primary').on('click', function(e) {
            var flag = $(this).attr('id');
            $('#submitflag').val(flag);

        });

    });
</script>
<?php
echo $this->element('update_list');
?>
<style>
    td a{
        width: 200px;
        word-wrap: break-word;
        word-break: normal;
    }
</style>
<fieldset>
    <legend>Danh sách sự kiện GameEvent</legend>

    <div class="row-fluid">
        <?php
        echo $this->Form->create('GameEvent', array(
            'url' => array(
                'controller' => 'GameEvent',
                'action' => 'search',
            )
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
                    <?php echo $this->Form->input('Search.status', array('options' => $status, 'label' => __('Trạng thái'), 'empty' => '---------Chọn tất cả---------')) ?>
                </div>
            </div>
        </div>
        <div class="span8">
            <div class="control-group">
                <?php echo $this->Form->button(__('Tìm'), array('type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'search')) ?>
                <?php echo $this->element('add'); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

    <?php
    echo $this->Form->create('UpdateList', array(
        'url' => array(
            'controller' => 'GameEvent',
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
                <td>Tên sự kiện</td>
                <td>Tên game</td>
                <td>Bắt đầu</td>
                <td>Kết thúc</td>
                <td style="width: 200px">Link diễn đàn</td>
                <td>Thứ tự</td>
                <td>Trạng thái</td>
                <td width="7%">Thao tác</td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($gameEvents)): ?>
                <?php foreach ($gameEvents as $gameEvent): ?>
                    <?php $stt++; ?>
                    <?php $id = (int) $gameEvent['GameEvent']['id']; ?>
                    <tr>
                        <td>
                            <?php echo $stt; ?>
                            <?php echo $this->Form->hidden($id . '.GameEvent.id', array('value' => $id)); ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Html->link($gameEvent['GameEvent']['name'], array('action' => 'edit', $id));
                            ?>
                        </td>
                        <td><?php echo $gameEvent['GameApp']['name'] ?>
                        </td>
                        <td><?php echo $gameEvent['GameEvent']['start_date'] ?>
                        </td>
                        <td><?php echo $gameEvent['GameEvent']['end_date'] ?>
                        </td>
                        <td style="width: 200px"><a href="<?php echo $gameEvent['GameEvent']['event_forum_link'] ?>"><?php echo $gameEvent['GameEvent']['event_forum_link'] ?></a>
                        </td>
                        <?php if (empty($admin)): ?>
                            <td class="order"><?php
                                echo $this->Form->input($id . '.GameEvent.order', array(
                                    'options' => $orders,
                                    'default' => $gameEvent['GameEvent']['order'],
                                    'label' => false,
                                    'disabled' => 'disabled',
                                    'div' => false
                                ));
                                ?></td>
                        <?php else : ?>
                            <td class="order"><?php
                                echo $this->Form->input($id . '.GameEvent.order', array(
                                    'options' => $orders,
                                    'default' => $gameEvent['GameEvent']['order'],
                                    'label' => false,
                                    'div' => false
                                ));
                                ?></td>
                        <?php endif; ?>
                        <?php if (empty($admin)): ?>
                            <td><?php
                                echo $this->Form->input($id . '.GameEvent.status', array(
                                    'options' => $status,
                                    'default' => $gameEvent['GameEvent']['status'],
                                    'label' => false,
                                    'disabled' => 'disabled',
                                    'div' => false
                                ));
                                ?></td>
                        <?php else: ?>
                            <td><?php
                                echo $this->Form->input($id . '.GameEvent.status', array(
                                    'options' => $status,
                                    'default' => $gameEvent['GameEvent']['status'],
                                    'label' => false,
                                    'div' => false
                                ));
                                ?></td>
                        <?php endif; ?>
                        <td class="action"><?php echo $this->Html->link(null, array('action' => 'edit', (int) $gameEvent['GameEvent']['id']), array('title' => 'Chỉnh sửa', 'class' => 'icon-edit')) ?>
                            <?php if ($admin == 0 && in_array($id, $gamePublic)): ?>
                                <?php echo $this->Html->link(null, '#', array('title' => 'Bạn không có quyền xóa game này', 'class' => 'icon-warning-sign')) ?>  
                            <?php else : ?>
                                <?php echo $this->Html->link(null, array('action' => 'delete', (int) $gameEvent['GameEvent']['id']), array('title' => 'Xóa', 'class' => 'icon-trash remove')) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo $this->Form->end(); ?>
</fieldset>
<div class="form-actions">
    <?php // echo $this->Form->hidden('GameEvent.submitflag', array('value' => 'search', 'id' => 'submitflag'))  ?>
    <?php echo $this->Form->button(__('Thay đổi'), array('class' => array('btn', 'btn-primary'), 'type' => 'submit', 'id' => 'update')); ?>

</div>
<?php echo $this->element('pager'); ?>