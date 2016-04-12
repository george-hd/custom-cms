<h2>Допълнителни полета</h2>
<?php
if($model) {
    //TODO
    $grid = new \Cms\ViewHelpers\Grid();
    $grid->create($model)
        ->setAttributes([
            'id' => 'section-fields-list',
            'class' => 'list-table'
        ])
        ->setTdClasses([
            'id' => 'id',
            'label' => 'label',
            'type' => 'type',
            'section' => 'section',
            'delete' => 'delete-section-field'
        ])
        ->setColumnNames([
            'id' => 'Id',
            'label' => 'Label',
            'type' => 'Type',
            'section' => 'Section',
            'delete' => '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>'
        ])
        ->render();
} else {
    ?>
    <div class="nosec">
        <p class="error">Тази секция няма допълнителни полета</p>
        <p class="error">За да добавите поле кликнете "Добавяне на поле" в менюто по-горе.</p>
    </div>
    <?php
}