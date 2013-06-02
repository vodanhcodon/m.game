<?php
    if (isset($javascript)) {
        $javascript->link(array(
            'jquery/jquery.min',
            'page_specific/posts_edit'
        ), false);
    }
?>

<div class="posts form">
<?php echo $form->create();?>
    <fieldset>
        <legend><?php $this->action == 'add' ? __('Add Post') : __('Edit Post'); ?></legend>
    <?php
        echo $form->input('id');
        echo $form->input('title');
        echo $form->input('body');
        echo $form->input('published', array('checked' => true));
    ?>
    </fieldset>
    
    <div id="loadingDiv" style="display:none;">
        <?php echo $html->image('ajax-loader.gif', array('alt' => 'Loading...')); ?>
    </div>
 
<?php echo $form->end(__('Submit', true));?>
</div>