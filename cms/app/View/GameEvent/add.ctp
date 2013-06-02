<?php
$folder = Configure::read('gom.GameEvent.folder');
$tmp = $folder['tmp'];
$path = $folder['dir'];
$webroot = $this->webroot;
?>
<?php
echo $this->element('jquery_file_upload');
?>
<script>
    $(function() {
        $('.selectpicker').selectpicker();
        $(".datepicker").datepicker({
            showOn: "button",
            buttonImage: "<?php echo $webroot; ?>img/calendar2.gif",
            buttonImageOnly: true,
            dateFormat: "dd/mm/yy",
        });
        
        // thêm load ajax khi chọn 1 game nào đó thì tự động in ra game forum tương ứng
        $('#game_app_id').on('change', function() {
            var game_app_id = $(this).val();
            var game_forum = '<?php echo $this->Html->url(array('action' => 'getForumLink')); ?>';
            $.get(game_forum, {game_app_id: game_app_id}, function() {
            }).done(function(data) {
                console.log(data);
                $('#game_forum_link').val(data);
            });
        });
    });
</script>
<style>
    img.ui-datepicker-trigger {
        vertical-align: 0;
    }
    .span12 {
        margin-left: 0px !important;
    }

</style>
<?php echo $this->Form->create('GameEvent', array('class' => 'game')); ?>

<div class="row-fluid">
    <div class="span12">
        <fieldset>
            <legend>
                <?php echo __('Thêm mới sự kiện GameEvent'); ?>
                <?php echo $this->element('referer_link'); ?>
            </legend>
            <div class="row-fluid">
                <div class="span4">
                    <?php echo $this->Form->input('name', array('label' => 'Tên sự kiện GameEvent', 'class' => 'input-xlarge')); ?>
                    <?php
                    echo $this->Form->input('order', array(
                        'label' => 'Thứ tự',
                        'class' => 'input-xlarge',
                    ));
                    ?>
                    <div class="input required">
                        <label>Mô tả ngắn</label>
                        <?php
                        echo $this->Form->textarea('short_decription', array(
                            'label' => 'Mô tả ngắn',
                            'escaped' => false,
                            'class' => 'input-xlarge',
                            'rows' => 8,
                        ));
                        ?>
                    </div>

                </div>
                <div class="span4">
                    <?php
                    echo $this->Form->input('start_date', array(
                        'label' => __('Bắt đầu'),
                        'type' => 'text',
                        'id' => 'start_date',
                        'class' => 'input-xlarge datepicker',
                        'value' => isset($this->data['GameEvent']['start_date']) ? $this->data['GameEvent']['start_date'] : date('d/m/Y', time()),
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('end_date', array(
                        'label' => __('Kết thúc'),
                        'type' => 'text',
                        'id' => 'end_date',
                        'class' => 'input-xlarge datepicker',
                        'value' => isset($this->data['GameEvent']['end_date']) ? $this->data['GameEvent']['end_date'] : date('d/m/Y', strtotime('+2 day', time())),
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('game_app_id', array(
                        'label' => __('Chọn Game/App'),
                        'options' => $game,
                        'id' => 'game_app_id',
                        'class' => 'input-xlarge selectpicker',
                        'data-size' => '10',
                        'data-style' => 'input-xlarge',
                    ));
                    ?>
                    <?php
                    echo $this->Form->input('game_forum_link', array('label' => __('Game forum link'), 'type' => 'text', 'id' => 'game_forum_link', 'class' => 'input-xlarge'));
                    ?>
                    <?php
                    echo $this->Form->input('event_forum_link', array('label' => __('Event forum link'), 'type' => 'text', 'id' => 'event_forum_link', 'class' => 'input-xlarge'));
                    ?>

                </div>
                <div class="span4">
                    <label>File ảnh</label>
                    <?php
                    echo $this->element('jquery_file_upload_input', array(
                        'inputname' => 'data[GameEvent][image_path][]',
                        'formname' => 'GameEvent',
                        'selectorID' => 'image_path',
                        'imagePath' => isset($image_path) ? $image_path : '',
                        'singleFileUploads' => 'false',
                        'limitMultiFileUploads' => 3,
                        'maxNumberOfFiles' => 3,
                    ));
                    ?>
                </div>
                <div class="span12">
                    <div class="input required">
                        <label>Mô tả</label>
                        <?php
                        echo $this->Form->textarea('description', array(
                            'label' => 'Mô tả',
                            'escaped' => false,
                            'class' => 'span7',
                            'rows' => 8,
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $this->element('submitbar', array('id' => empty($id) ? '' : $id)) ?>
            </div>
        </fieldset>
    </div>
</div>

<?php echo $this->Form->end(); ?>
