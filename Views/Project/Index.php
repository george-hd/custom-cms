<?php
use \Cms\Forgery;

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf" content="<?php echo Forgery::getInstance()->getForgeryString() ?>">
    <title>Title</title>
    <link rel="stylesheet" href="<?php echo \Cms\Paths::root(); ?>css/Cms.css">
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/project.js"></script>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="<?php echo \Cms\Paths::root(); ?>">Link1</a></li>
            <li><a href="<?php echo \Cms\Paths::link('home/index'); ?>">Link2</a></li>
            <li><a href="<?php echo \Cms\Paths::link('начало/index'); ?>">Link3</a></li>
            <li><a href="<?php echo \Cms\Paths::link('#'); ?>">Link4</a></li>
            <li><a href="<?php echo \Cms\Paths::link('#'); ?>">Link5</a></li>
            <li><a href="<?php echo \Cms\Paths::link('#'); ?>">Link6</a></li>
            <li><a href="<?php echo \Cms\Paths::link('#'); ?>">Link7</a></li>
            <?php
            if($model){
                echo '<li>Здравей, ' . htmlentities($model->getName()) . '</li>'
                .'<li><a href="'.\Cms\Paths::link('home/logout').'">Изход</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
<h1>Test Controller Index View</h1>

<?php

//Dropdown::create()->setAttributes(['id' => 'drop-down-id', 'class' => 'some-class', 'name' => 'drop-down-name'])
//    ->setOption('Stara Zagora', 1)
//    ->setOption('Sofia', 2)
//    ->setOption('Haskovo', 3)
//    ->render();
//
//Form::create()->openForm()
//    ->addAttributes(
//        array(
//            'id' => 'form-id',
//            'method' => 'POST',
//            'action' => \Cms\Paths::link('home/index')
//        )
//    )
//    ->addLabel(
//        'Label',
//        array('style' => 'display: block; color: red; margin: 20px 0',
//            'for' => 'field-id',
//            'id' => 'label-id',
//            'class' => 'label-class another-class'
//        )
//    )
//    ->addField(
//        array(
//            'id' => 'field_id',
//            'class' => 'field_class',
//            'name' => 'field_name'
//        )
//    )
//    ->addButton(
//        'submit',
//        array(
//            'type' => 'submit',
//            'style' => 'background-color: sky-blue;
//                color: #f00;
//                display: block;
//                margin-top: 20px;'
//        )
//    )
//    ->render();
//
//$grid  = new \Cms\ViewHelpers\Grid();
//$grid->create($model)
//    ->setAttributes([
//        'border-collapse' => 'collapse',
//        'border' => '1',
//        'style' => 'margin: 20px;'
//    ])
//    ->render();
//?>
</body>
</html>