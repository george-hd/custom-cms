
<style>
    #admin-login {
        display: block;
        width: 200px;
        margin: 10% auto;
        padding: 10px;    border-radius: 5px;
        background-color: #25f;
        text-align: center;

    }
    #admin-login input {
        display: block;
        width: 180px;
        height: 30px;
        padding: 10px;
        box-sizing: border-box;
        margin: 10px;
    }
    #admin-login label {
        color: #fff;
        font-size: 18px;
    }
    #admin-login button {
        border-radius: 3px;
        padding: 5px 15px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        margin: 5px 0;
    }
</style>
<form id="admin-login" method="POST" action="#">
    <label for="admin-name">Потребител</label>
    <input id="admin-name" type="text" name="admin-name">

    <label for="password">Парола</label>
    <input id="password" type="password" name="password">

    <input name="___ft" type="hidden" value="">

    <button id="admin-login-btn">Вход</button>
</form>
<?php
//Form::create()->openForm()
//    ->addAttributes([
//        'id' => 'login',
//        'method' => 'POST',
//        'action' => \Cms\Paths::link('home')
//    ])
//    ->addLabel('Потребител',
//        [
//            'for' => 'user'
//        ])
//    ->addFieldWithErrors([
//        'id' => 'user',
//        'type' => 'text',
//        'name' => 'user'
//    ])
//    ->addLabel('Парола',
//        [
//            'for' => 'password'
//        ])
//    ->addFieldWithErrors([
//        'id' => 'password',
//        'type' => 'password',
//        'name' => 'password'
//    ])
//    ->addButton('Вход',[])
//    ->render();

$messages = \Cms\App::getInstance()->getSession()->messages;
if($messages) {
    foreach ($messages as $message) {
        echo '<p class="login-error">' . $message['message'] . '</p>';
    }
}
unset($_SESSION['messages']);