<div class="options-container">
    <h2>Site Languages</h2>
    <div>
        <button id="add-lang" class="create-btn">Add Language</button>
        <?php if($model) {?>
            <label for="change-lang" class="margl20">Language</label>
            <select id="change-lang" class="language">
                <?php
                if($model['current']) {
                    $current = $model['current'];
                    unset($model['current']);
                }
                foreach ($model as $language) {
                    ?>
                    <option value="<?php echo $language->id; ?>"<?php echo($current === $language->id ? 'selected' : ''); ?>><?php echo ucfirst($language->value); ?></option>
                    <?php
                }
                ?>
            </select>
        <?php } ?>
    </div>
    <?php
    if($model) {
        $grid = new \Cms\ViewHelpers\Grid();
        $grid->create($model)
            ->setAttributes([
                'id' => 'language-list',
                'class' => 'list-table'
            ])
            ->setTdClasses([
                'id' => 'lang_id',
                'key' => 'abbreviation',
                'value' => 'language',
                'parent_key' => 'parent-key',
                'edit' => 'edit',
                'delete' => 'delete'
            ])
            ->setColumnNames([
                'id' => 'Id',
                'langPrefix' => 'Abbreviation',
                'language' => 'Language',
                'parent_key' => 'Parent',
                'edit' => '<img src="' .\Cms\Paths::link('images/edit.png') . '" width="20" height=""20>',
                'delete' => '<img src="' .\Cms\Paths::link('images/delete.png') . '" width="20" height=""20>',
            ])
            ->render();
    }
    ?>
</div>