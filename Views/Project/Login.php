
<form id="login" method="POST" action="login">
    <label for="user-name">Потребител</label>
    <input id="user-name" type="text" name="user-name">

    <label for="password">Парола</label>
    <input id="password" type="password" name="password">

    <input name="___ft" type="hidden" value="">

    <button id="login-btn">Вход</button>
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