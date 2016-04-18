<?php
if($model) {
//    echo "<pre>".print_r($model, true)."</pre>";
    ?>
    <h1><?php echo $model['section']->getTitle(); ?></h1>
    <div style="margin: 0 auto; width: 50%; border: 1px solid #ff0000;">
        <?php echo $model['section']->getDescription(); ?>
    </div>
    <div style="margin: 10px auto; width: 50%; border: 1px solid #0000ff;">
        <?php echo $model['section']->getBody(); ?>
    </div>
    <div style="margin: 10px auto; width: 50%; border: 1px solid #0000ff;">
        <img src="<?php echo \Cms\Paths::root() . 'images/' . $model['resources'][0]['value']; ?>" width="680" height="100">
    </div>
    <?php
}