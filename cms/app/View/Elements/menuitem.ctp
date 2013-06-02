<?php
$class = isset($class) ? $class : 'dropdown';
?>
<li class="<?php echo $class ?>">
    <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" ><?php echo $title; ?><b class="caret"></b></a>
    <ul role="menu" class="dropdown-menu">
        <li role="presentation"><?php echo $this->Html->link(__('Thêm mới'), array('controller' => $controller, 'action' => $add)) ?></li>
        <li role="presentation"><?php echo $this->Html->link(__('Danh sách'), array('controller' => $controller, 'action' => $index)) ?></li>
    </ul>
</li>