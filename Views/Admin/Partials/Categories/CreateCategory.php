<div class="create-form">
    <label for="category-key">Category Key</label>
    <input id="category-key" type="text" name="category-key"<?php echo ($model['action'] === 'edit' ? 'disabled' : ''); ?>>
    <label for="category-val">Category Name</label>
    <input id="category-val" type="text" name="category-val">
    <label for="parent-category">Parent Category</label>
    <select id="parent-category" class="language">
        <option value="">NULL</option>
        <?php
//        if($model['categories']) {
//            foreach ($model['categories'] as $category) {
//                echo '<option value="'.$category['id'].'">'.$category['category'].'</option>';
//            }
//        }
        ?>

    </select>
    <?php
    if($model['action'] === 'edit') {
        ?>
        <input id="category-id" type="hidden" value="">
        <?php
    }
    ?>
    <button id="<?php echo($model['action'] === 'create' ? 'create-category-btn' : 'edit-category-btn'); ?>" class="create-btn">Save</button>
</div>