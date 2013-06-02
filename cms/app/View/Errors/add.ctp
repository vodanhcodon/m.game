
<fieldset>
	<?php echo $this->Form->create('Game'); ?>
	<legend>
		<?php echo __('Thêm mới game'); ?>
	</legend>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span6">
				<?php echo $this->Form->input('name',array('label' => 'Tên game','div' => false));?>
				<?php echo $this->Form->input('category_id',
            array('label' => 'Danh mục','div' => false,'options' => $danhmuc));?>
				<?php echo $this->Form->input('the_loai_id',
            array('label' => 'Danh mục','div' => false,'options' => $theloai));?>
				<?php echo $this->Form->input('company_id',
            array('label' => 'Công ty','div' => false,'options' => $company));?>
				<label>Mô tả ngắn</label>
				<?php
				echo $this->Form->textarea('short_decription',array('label' => 'Mô tả ngắn','div' => false,'escaped' => false));
				?>
				<label>Máy hỗ trợ</label>
				<?php 
				echo $this->Form->textarea('device_support',array('label' => 'Máy hỗ trợ','div' => false,'escaped' => false));
				?>
				<label>Mô tả</label>
				<?php 
				echo $this->Form->textarea('description',array('label' => 'Mô tả','div' => false,'escaped' => false));
				?>
			</div>
			<div class="span6">
				<?php 
				echo $this->Form->input('logo',array('label' => 'Logo','div' => false,'type' => 'file'));
				?>
				<?php 
				echo $this->Form->input('image_path',array('label' => 'Ảnh game','div' => false,'type' => 'file'));
				echo $this->Form->hidden('image_path_1',array('label' => 'Ảnh game','div' => false,'type' => 'file'));
				echo $this->Form->hidden('image_path_2',array('label' => 'Ảnh game','div' => false,'type' => 'file'));
				echo $this->Form->hidden('image_path_3',array('label' => 'Ảnh game','div' => false,'type' => 'file'));
				?>
				<?php 
				echo $this->Form->input('version',array('label' => 'version','div' => false));
				?>
				<?php 
				echo $this->Form->input('price',array('label' => 'Giá bán','div' => false));
				?>
				<?php 
				// 		echo $this->Form->input('order',array('label' => 'Thứ tự sắp xếp','div'=> false));
				?>
				<label>Forum link</label>
				<?php 
				echo $this->Form->textarea('game_forum_link',array('label' => 'Forum link','div' => false,'escaped' => false));
				?>
				<?php 
				echo $this->Form->input('type',array('label' => 'Loại','div' => false,'options' => Configure::read('gom.Game.type')));
				?>
				<?php 
				echo $this->Form->input('jar_file',array('label' => 'jar file','div' => false,'type' => 'file'));
				?>
				<?php 
				echo $this->Form->input('jad_file',array('label' => 'jad file','div' => false,'type' => 'file'));
				?>
				<?php 
				echo $this->Form->input('apk_file',array('label' => 'apk file','div' => false,'type' => 'file'));
				?>
			</div>
			<div class="span12">
				<?php echo $this->Form->input(__('Submit'),array('type' => 'submit','label' => false,'div' => false)); ?>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end();?>
</fieldset>
