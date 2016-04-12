<div class="create-form">
    <label for="site-var-key">Site Var Key</label>
    <input id="site-var-key" type="text" name="site-var-key"<?php echo($model['action'] === 'edit' ? 'disabled' : ''); ?>>
    <label for="site-var">Site Var</label>
    <input id="site-var" type="text" name="site-var">
    <label for="site-var-category">Site Var Category</label>

    <?php
    if($model['categories']) {
        ?>
        <select id="site-var-category">
            <?php
            foreach ($model['categories'] as $category) {
                ?>
                <option value="<?php echo $category->cat_key ?>"><?php echo $category->cat_val; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
    }
    ?>

<!--    <input id="site-var-category" type="text" name="site-var-category">-->
    <?php
    if($model['action'] === 'edit') {
        ?>
        <input id="site-var-id" type="hidden" value="">
        <?php
    }
    ?>
    <button id="<?php echo($model['action'] === 'create' ? 'create-site-var-btn' : 'edit-site-var-btn'); ?>" class="create-btn">Save</button>
</div>