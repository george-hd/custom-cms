<?php
if($model) {
    ?>
    <h1><?php echo $model['title']; ?></h1>
    <div style="margin: 0 auto; width: 50%; border: 1px solid #ff0000;">
        <?php echo $model['short_desc'] ?>
    </div>
    <div style="margin: 10px auto; width: 50%; border: 1px solid #0000ff;">
        <?php echo $model['body'] ?>
    </div>
    <?php
}