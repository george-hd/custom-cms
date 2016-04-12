<div class="options-container">
    <h2>Sections</h2>
    <div>
        <button id="add-section" class="create-btn">Add Section</button>
        <?php if($model['languages']) { ?>
            <label for="change-lang" class="margl20">Language</label>
            <select id="change-lang" class="language">
                <?php
                foreach ($model['languages'] as $language) {
                    ?>
                    <option value="<?php echo $language->id ?>" <?php echo($model['current_lang_id'] == $language->id ? 'selected' : ''); ?>><?php echo ucfirst($language->value); ?></option>
                    <?php
                }
                ?>
            </select>
        <?php }
        if($model['categories']) {
            ?>
            <label for="sv-categories" class="margl20">Filter by category</label>
            <select id="section-categories" class="language">
                <option value="">All</option>
                <?php
                foreach ($model['categories'] as $category) {
                    ?>
                    <option value="<?php echo $category->cat_id; ?>" <?php echo($category->cat_id == $model['current_category_id'] ? 'selected' : ''); ?>><?php echo $category->cat_val; ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
        ?>
    </div>
    <?php
    if($model['sections']) {
        $grid = new \Cms\ViewHelpers\Grid();
        $grid->create($model['sections'])
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
    ?>
</div>