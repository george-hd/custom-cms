<?php
use \Cms\Forgery;
use \Cms\App as app;
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf" content="<?php echo Forgery::getInstance()->getForgeryString() ?>">
    <title>Title</title>
    <link rel="stylesheet" href="<?php echo \Cms\Paths::root(); ?>css/project.css">
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/colorbox.js"></script>
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/project.js"></script>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="<?php echo \Cms\Paths::root(); ?>">Some Link</a></li>
            <li><a href="<?php echo \Cms\Paths::link('home'); ?>">Some Link</a></li>
            <li><a href="<?php echo \Cms\Paths::link('#'); ?>">Some Link</a></li>
            <li><a href="<?php echo \Cms\Paths::link('#'); ?>">Some Link</a></li>
            <?php if (app::getInstance()->getSession()->user['isLogged'] === true): ?>
                <li><a href="<?php echo \Cms\Paths::link('user/logout'); ?>">Изход</a></li>
                <li><?php echo app::getInstance()->getSiteVar('hello').', ' . (app::getInstance()->getSession()->user['userName'] != 'bro555555' ? ucfirst(\Cms\App::getInstance()->getSession()->user['userName']) : app::getInstance()->getSession()->user['userName']); ?></li>
            <?php endif ?>
            <?php if (!app::getInstance()->getSession()->user['isLogged']): ?>
                <li id="entrance"><a href="<?php echo \Cms\Paths::link('user/login'); ?>">Вход</a></li>
                <li id="registration"><a href="<?php echo \Cms\Paths::link('register'); ?>">Регистрация</a></li>
            <?php endif ?>
            <?php if(app::getInstance()->getSession()->user['role_id'] && (int) app::getInstance()->getSession()->user['role'] < 3): ?>
                <li><a href="<?php echo \Cms\Paths::link('admin'); ?>">admin panel</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>
<h1>Default Template</h1>

<?php echo $this->section['home']; ?>
<?php echo $this->section['login']; ?>
<?php echo $this->section['register']; ?>
<?php echo $this->section['userData']; ?>

</body>
</html>