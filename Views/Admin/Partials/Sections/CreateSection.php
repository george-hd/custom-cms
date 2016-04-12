<script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'#section-body',
        height: "200",
        statusbar: false,
        plugins: "image anchor autolink charmap code codesample textcolor colorpicker directionality emoticons fullpage fullscreen " +
        "hr insertdatetime link lists media nonbreaking noneditable pagebreak paste preview print save searchreplace spellchecker " +
        "tabfocus table template visualblocks visualchars",
        toolbar: "undo redo | styleselect | bold italic | link image | pagebreak | paste " +
        "| image | anchor | autolink | charmap " +
        "| code | codesample | forecolor backcolor |" +
        "ltr rtl | emoticons | fullpage | fullscreen |" +
        " insertdatetime | link | media | nonbreaking |" +
        " preview | print | save | searchreplace | spellchecker |" +
        " table | template | visualblocks | visualchars"
    });
</script>
<?php //if($model['action'] !== 'create') var_dump($model['section']->category_key); ?>
<!--<div class="create-form">-->
<form id="<?php echo($model['action'] === 'create' ? 'create-section-form' : 'update-section-form'); ?>" class="create-form" method="post" action="" enctype="multipart/form-data">
    <label for="sec-category">Category *</label>
    <select id="sec-category" name="sec-category">
        <?php
        if($model['action'] !== 'create' && $model['categories']) {
            echo "<pre>".print_r($model, true)."</pre>";
            foreach ($model['categories'] as $cat) {
                ?>
                <option value="<?php echo $cat['cat_key']; ?>" <?php echo($model['section']->categoryKey === $cat['cat_key'] ? 'selected' : ''); ?>><?php echo $cat['cat_val']; ?></option>
                <?php
            }
        }
        ?>
    </select>
    <label for="sec-key">Section Key *</label>
    <input id="sec-key" type="text" <?php echo ($model['action'] === 'edit' ? 'disabled' : ''); ?> value="<?php if($model['section']) echo $model['section']->key; ?>" name="sec-key">
    <label for="sec-title">Section Title *</label>
    <input id="sec-title" type="text" value="<?php if($model['section']) echo $model['section']->title; ?>" name="sec-title">

    <?php
    if($model['ext_fields']) {
        foreach ($model['ext_fields'] as $field) {
            if($field->type === 'file') {
                ?>
                <label for="<?php echo $field->label.'-'.$field->id; ?>"><?php echo $field->label; ?></label>
                <input type="file" name="<?php echo $field->label.'-'.$field->id; ?>">
                <input type="text" value="<?php echo($field->res ? 'current file: '.$field->res : ''); ?>" disabled>
                <input type="hidden" name="<?php echo $field->label.'-'.$field->id; ?>" value="file">
                <?php
            } else if($field->type === 'input') {
                ?>
                <label for="<?php echo $field->label.'-'.$field->id; ?>"><?php echo $field->label; ?></label>
                <input type="text" name="<?php echo $field->label.'-'.$field->id; ?>" value="<?php echo($field->res ? $field->res : ''); ?>">
                <?php
            } else if($field->type === 'textarea') {
                ?>
                <label for="<?php echo $field->label.'-'.$field->id; ?>"><?php echo $field->label; ?></label>
                <textarea name="<?php echo $field->label.'-'.$field->id; ?>"><?php echo($field->res ? $field->res : ''); ?></textarea>
                <?php
            } else if($field['type'] === 'checkbox') {
                //TODO
            } else if($field['type'] === 'radio') {
                //TODO
            } else if($field['type'] === 'date') {
                //TODO
            }
        }
    }
    ?>

    <label>Section Description</label>
<!--    --><?php //echo "<pre>".print_r($model['section'], true)."</pre>"; ?>
    <textarea id="sec-desc" name="sec-desc"><?php if($model['section']) echo $model['section']->short_desc; ?></textarea>
<!--    <label>Section Keywords</label>-->
<!--    <textarea id="sec-key-words">-->
<!---->
<!--    </textarea>-->
<!--    <label>Section Tags</label>-->
<!--    <textarea id="sec-tags">-->
<!---->
<!--    </textarea>-->
    <label>Section Body</label>
    <div id="mce-wrapper">
        <textarea id="section-body" name="section-body"><?php if($model['section']) echo $model['section']->body; ?></textarea>
    </div>
    <input id="section-id" type="hidden" value="" name="section-id">
    <input type="hidden" value="<?php echo($model['action'] === 'create' ? 'create-section' :'update-section'); ?>" name="action">
    <button id="<?php echo ($model['action'] === 'create' ? 'crete-section' : 'update-section-btn'); ?>" type="submit" class="create-btn"><?php echo ($model['action'] === 'create' ? 'Create Section' : 'Save changes') ?></button>
</form>