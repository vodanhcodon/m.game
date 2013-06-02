<style>
    h1 {
        background: none;
        color: #003D4C;
        font-size: 100%;
    }
</style>
<div class="bs-docs-example">
    <div class="hero-unit">
        <h1>Xin chào <?php echo CakeSession::read('Auth.User.user_name'); ?>!</h1>
        <p>Chào mừng bạn đến với hệ thống quản trị nội dung Gom CMS.</p>
        <p><?php echo $this->Html->link(__('Hãy bắt đầu'), array('controller' => 'GameApp', 'action' => 'index'), array('class' => 'btn btn-primary btn-large')); ?></p>
    </div>
</div>