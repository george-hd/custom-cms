<?php
if($model) {
    $grid = new \Cms\ViewHelpers\Grid();
    $grid->create($model)
        ->setAttributes([
            'id' => 'section-list',
            'class' => 'list-table'
        ])
        ->setTdClasses([
            'id' => 'id',
            'key' => 'key',
            'title' => 'title',
            'lang_val' => 'lang-val',
            'cat_val' => 'cat-val',
            'visibility' => 'visibility',
            'settings' => 'sec-settings',
            'edit' => 'edit',
            'delete' => 'delete'
        ])
        ->setColumnNames([
            'id' => 'Id',
            'key' => 'Section Key',
            'title' => 'Title',
            'lang_val' => 'Language',
            'cat_val' => 'Category',
            'visibility' => 'Visibility',
            'settings' => '<img src="' .\Cms\Paths::link('images/settings.png') . '" width="20" height=""20>',
            'edit' => '<img src="' .\Cms\Paths::link('images/edit.png') . '" width="20" height=""20>',
            'delete' => '<img src="' .\Cms\Paths::link('images/delete.png') . '" width="20" height=""20>',
        ])
        ->render();
} else {
    echo '<p class="error">No Sections</p>';
}