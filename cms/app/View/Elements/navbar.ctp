<div class="navbar">
    <div class="navbar-inner">
        <div style="width: auto;" class="container">
            <?php echo $this->Html->link(Configure::read('gom.sitename'), array('controller' => 'pages', 'action' => 'display'), array('class' => 'brand')); ?>
            <ul role="navigation" class="nav">
                <?php echo $this->element('menuitem', array('title' => 'Game', 'controller' => 'GameApp', 'add' => 'add', 'index' => 'index')); ?>
                <?php echo $this->element('menuitem', array('title' => 'Sự kiện', 'controller' => 'GameEvent', 'add' => 'add', 'index' => 'index')); ?>
                <?php if (!empty($admin)): ?>
                    <?php echo $this->element('menuitem', array('title' => 'News', 'controller' => 'News', 'add' => 'add', 'index' => 'index')); ?>
                    <?php echo $this->element('menuitem', array('title' => 'Product distribution', 'controller' => 'ProductDistribution', 'add' => 'add', 'index' => 'index')); ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#">Cài Đặt<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php
                            echo $this->element('menuitem', array(
                                'title' => 'Danh Mục',
                                'controller' => 'DanhMuc',
                                'add' => 'add',
                                'index' => 'index',
                                'class' => 'dropdown-submenu',
                            ));
                            ?>
                            <?php
                            echo $this->element('menuitem', array(
                                'title' => 'Thể Loại',
                                'controller' => 'TheLoai',
                                'add' => 'add',
                                'index' => 'index',
                                'class' => 'dropdown-submenu',
                            ));
                            ?>
                            <?php
                            echo $this->element('menuitem', array(
                                'title' => 'Tài khoản',
                                'controller' => 'CmsUsers',
                                'add' => 'add',
                                'index' => 'index',
                                'class' => 'dropdown-submenu',
                            ));
                            ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="nav pull-right">
                <li class="dropdown" id="fat-menu">
                    <?php echo $this->Html->link(__('Đăng xuất'), array('controller' => 'CmsUsers', 'action' => 'logout')) ?>
                </li>
            </ul>
        </div>
    </div>
</div>