<div class="create-form">
    <label for="langAbbreviation">Language abbreviation</label>
    <input id="langAbbreviation" type="text" name="langAbbreviation" placeholder="EN">
    <label for="langVal">Language</label>
    <input id="langVal" type="text" placeholder="English" name="langVal">
    <?php
    if($model['action'] === 'edit') {
        ?>
        <input id="langId" type="hidden" value="">
        <input id="oldKey" type="hidden" value="">
        <?php
    }
    ?>
    <button id="<?php echo($model['action'] === 'create' ? 'create-lang-btn' : 'edit-lang-btn'); ?>" class="create-btn">Save</button>
</div>