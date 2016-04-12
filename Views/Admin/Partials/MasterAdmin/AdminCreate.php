<div id="admin-create" class="create-form">
    <label for="admin-name">Admin</label>
    <input id="admin-name" type="text" name="admin-name">

    <label for="password">Password</label>
    <input id="password" type="password" name="password">

    <label>Admin Role</label>
    <select id="admin-role" name="admin-role">
        <?php
            if($model) {
                $action = $model['action'];
                unset($model['action']);
                foreach ($model as $item) {
                    ?>
                    <option value="<?php echo $item['id']; ?>" <?php echo($item['id'] == 2 ? 'selected' : ''); ?>><?php echo $item['name']; ?></option>
                    <?php
                }
            }
        ?>
    </select>

    <input name="___ft" type="hidden" value="">
    <input id="adm-id" name="adm-id" type="hidden" value="">

    <button id="<?php echo($action === 'update' ? 'update-admin-btn' : 'create-admin-btn'); ?>">Save</button>
</div>
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
        echo '<p class="error">' . $message['message'] . '</p>';
    }
}
unset($_SESSION['messages']);