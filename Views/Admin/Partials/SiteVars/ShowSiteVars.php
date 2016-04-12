<div class="options-container">
    <h2>Site Variables</h2>
    <div>
        <button id="add-var" class="create-btn">Add SiteVar</button>
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
                <select id="sv-categories" class="language">
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
    if($model['siteVars']) {
        $grid = new \Cms\ViewHelpers\Grid();
        $grid->create($model['siteVars'])
            ->setAttributes([
                'id' => 'site-vars-list',
                'class' => 'list-table'
            ])
            ->setTdClasses([
                'id' => 'var-id',
                'key' => 'key',
                'value' => 'value',
                'language_key' => 'lang-key',
                'category_key' => 'category-key',
                'edit' => 'edit',
                'delete' => 'delete'
            ])
            ->setColumnNames([
                'id' => 'Id',
                'key' => 'Key',
                'value' => 'Variable',
                'language_key' => 'Language',
                'category_key' => 'Category',
                'edit' => '<img src="' .\Cms\Paths::link('images/edit.png') . '" width="20" height=""20>',
                'delete' => '<img src="' .\Cms\Paths::link('images/delete.png') . '" width="20" height=""20>',
            ])
            ->render();
    } else {
        echo '<p class="error">No Site Vars</p>';
    }
    ?>
</div>