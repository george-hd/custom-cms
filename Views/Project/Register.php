<?php
use \Cms\App as app;
 $app = app::getInstance();
?>

<div id="register" method="post" action="<?php echo \Cms\Paths::link('register'); ?>">
    <div>
        <label for="user"><?php echo $app->getSiteVar('user'); ?></label>
        <input id="user" type="text" name="user">

        <label for="password"><?php echo $app->getSiteVar('password'); ?></label>
        <input id="password" type="password" name="password">

        <label for="confirm-password"><?php echo $app->getSiteVar('confirm_password'); ?></label>
        <input id="confirm-password" type="password" name="confirm">
    </div>

    <div>
        <label for="fname"><?php echo $app->getSiteVar('name'); ?></label>
        <input id="fname" type="text" name="fname">

        <label for="family"><?php echo $app->getSiteVar('family'); ?></label>
        <input id="family" type="text" name="family">

        <label for="email"><?php echo $app->getSiteVar('email') ?></label>
        <input id="email" type="email" name="email">
    </div>

    <input name="___ft" type="hidden" value="">

    <button id="submit-registration">Регистрация</button>
</div>
<?php
$messages = \Cms\App::getInstance()->getSession()->messages;
if ($messages) {
?>
    <div class="register-error">
        <?php
        foreach ($messages as $message) {
            echo '<p>' . $message['message'] . '</p>';
        }
        ?>
    </div>
    <?php
}
    unset($_SESSION['messages']);