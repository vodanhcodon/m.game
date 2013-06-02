<div class="pagination">
	<ul>
		<?php echo $this->Paginator->prev('&larr; Trước', array('tag' => 'li','escape' => false), null, array('class' => 'disabled','tag' => 'li','escape' => false,'disabledTag' => 'a')); ?>
		<?php
		echo $this->Paginator->numbers(array('first' => 2, 'last' => 2, 'tag' => 'li','currentClass' => 'active','separator' => false,'currentTag' => 'a'));
		// echo $this->Paginator->counter('Trang {:page}/{:pages}') . ', '; // prints X of Y, where X is current page and Y is number of pages
		?>
		<?php echo $this->Paginator->next('Sau &rarr;', array('tag' => 'li','escape' => false), null, array('class' => 'disabled','tag' => 'li','escape' => false,'disabledTag' => 'a')); ?>
	</ul>
</div>
