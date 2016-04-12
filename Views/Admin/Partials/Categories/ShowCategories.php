<div class="options-container">
    <h2>Categories</h2>
    <div>
        <button id="add-category" class="create-btn">Add Category</button>
        <?php
        if($model['languages']) {
        ?>
            <label for="change-lang" class="margl20">Language</label>
            <select id="change-lang" class="language">
                <?php
                foreach ($model['languages'] as $language) {
                    ?>
                    <option value="<?php echo $language->id ?>"<?php echo($model['current_lang_id'] == $language->id ? 'selected': ''); ?>><?php echo ucfirst($language->value); ?></option>
                    <?php
                }
                ?>
            </select>
        <?php
        }
        if($model['categories']) {
        ?>
        <label for="category-filter" class="margl20">Filter by parent</label>
        <select id="category-filter" class="language">
            <option value="">All</option>
            <?php
            foreach ($model['categories'] as $category) {
                ?>
                <option value="<?php echo $category->cat_id ?>"><?php echo ucfirst($category->cat_val); ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <?php
        $grid = new \Cms\ViewHelpers\Grid();
        $grid->create($model['categories'])
            ->setAttributes([
                'id' => 'category-list',
                'class' => 'list-table'
            ])
            ->setTdClasses([
                'cat_id' => 'cat-id',
                'cat_key' => 'cat-key',
                'cat_val' => 'cat-value',
                'lang_val' => 'cat-lang-val',
                'parent_val' => 'cat-parent',
                'edit' => 'edit',
                'delete' => 'delete'
            ])
            ->setColumnNames([
                'cat_id' => 'Id',
                'cat_key' => 'Category Key',
                'cat_val' => 'Category',
                'lang_val' => 'Language',
                'parent_val' => 'Parent Category',
                'edit' => '<img src="' .\Cms\Paths::link('images/edit.png') . '" width="20" height=""20>',
                'delete' => '<img src="' .\Cms\Paths::link('images/delete.png') . '" width="20" height=""20>',
            ])
            ->render();
    } else {
        echo '<p class="error">No Categories</p>';
    }
    ?>
</div>