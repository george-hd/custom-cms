<div class="options-container">
    <h2>Administrators</h2>
    <form>
        <button id="add-admin" class="create-btn">Create Admin</button>
    </form>
    <?php
    if($model) {
        $grid = new \Cms\ViewHelpers\Grid();
        $grid->create($model)
            ->setAttributes([
                'id' => 'admin-list',
                'class' => 'list-table',
            ])
            ->setTdClasses([
                'admin_id' => 'admin-id',
                'admin_name' => 'admin-name',
                'role_id' => 'role-id',
                'role_name' => 'role-name',
                'edit' => 'edit',
                'delete' => 'delete',
            ])
            ->setColumnNames([
                'admin_id' => 'Admin Id',
                'admin_name' => 'Admin Name',
                'role_id' => 'Role Id',
                'role_name' => 'Role Name',
                'edit' => '<img src="' .\Cms\Paths::link('images/edit.png') . '" width="20" height=""20>',
                'delete' => '<img src="' .\Cms\Paths::link('images/delete.png') . '" width="20" height=""20>',
            ])
            ->render();
    }
    ?>
</div>