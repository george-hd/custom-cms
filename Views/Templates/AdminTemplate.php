
<?php
use \Cms\Forgery;
use \Cms\App as app;
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf" content="<?php echo Forgery::getInstance()->getForgeryString() ?>">
    <title>Title</title>
    <link rel="stylesheet" href="<?php echo \Cms\Paths::root(); ?>css/admin.css">
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/jquery.js"></script>
<!--    <script type="text/javascript" src="--><?php //echo \Cms\Paths::root(); ?><!--js/tinymce/js/tinymce/tinymce.min.js"></script>-->
<!--    <script>-->
<!--        tinymce.init({-->
<!--            selector:'#section-body',-->
<!--            statusbar: false,-->
<!--            plugins: "image anchor autolink charmap code codesample textcolor colorpicker directionality emoticons fullpage fullscreen " +-->
<!--            "hr insertdatetime link lists media nonbreaking noneditable pagebreak paste preview print save searchreplace spellchecker " +-->
<!--            "tabfocus table template visualblocks visualchars",-->
<!--            toolbar: "undo redo | styleselect | bold italic | link image | pagebreak | paste " +-->
<!--            "| image | anchor | autolink | charmap " +-->
<!--            "| code | codesample | forecolor backcolor |" +-->
<!--            "ltr rtl | emoticons | fullpage | fullscreen |" +-->
<!--            " insertdatetime | link | media | nonbreaking |" +-->
<!--            " preview | print | save | searchreplace | spellchecker |" +-->
<!--            " table | template | visualblocks | visualchars"-->
<!--        });-->
<!--    </script>-->
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/colorbox.js"></script>
    <script type="text/javascript" src="<?php echo \Cms\Paths::root(); ?>js/admin.js"></script>
</head>
<body>
<header>
    <nav class="cl">
        <?php
        $langsKeys = \Cms\Repositories\LanguageRepository::getInstance()->getLangKeys();
        foreach ($langsKeys as $lk) {
            foreach ($lk as $k => $v) {
                $arr[] = $v;
            }
        }
        $arr = array_diff($arr, array(\Cms\App::getInstance()->getAppLanguage()['key']));
        ?>
        <button class="cms-language active"><?php echo \Cms\App::getInstance()->getAppLanguage()['key']; ?></button>
        <div class="langs">
            <?php foreach ($arr as $langKey) { ?>
                <button class="cms-language"><?php echo $langKey; ?></button>
            <?php } ?>
        </div>
        <ul>
            <li><a href="<?php echo \Cms\Paths::link('admin'); ?>"><?php echo \Cms\App::getInstance()->getsv('dashboard'); ?></a></li>
            <li><a href="<?php echo \Cms\Paths::link('начало'); ?>">some link</a></li>
            <li><a href="<?php echo \Cms\Paths::link('admin/site-options'); ?>"><?php echo \Cms\App::getInstance()->getsv('site_options'); ?></a></li>
            <li><a href="<?php echo \Cms\Paths::link('admin/'); ?>"><?php echo \Cms\App::getInstance()->getsv('admin-settings'); ?></a></li>
            <li><a href="<?php echo \Cms\Paths::link('admin/users'); ?>"><?php echo \Cms\App::getInstance()->getsv('users'); ?></a></li>
            <li><a href="<?php echo \Cms\Paths::link('admin/master-admin'); ?>"><?php echo \Cms\App::getInstance()->getsv('master_admin'); ?></a></li>
        </ul>
        <ul id="user-data">
            <li>Hello, <?php echo (app::getInstance()->getSession()->admin['name'] != 'bro555555' ? ucfirst(\Cms\App::getInstance()->getSession()->admin['name']) : app::getInstance()->getSession()->admin['name']); ?></li>
<!--            <li><a href="--><?php //echo \Cms\Paths::root(); ?><!--">Exit Admin Pannel</a></li>-->
            <li><a href="<?php echo \Cms\Paths::link('manage/logout'); ?>"><?php echo \Cms\App::getInstance()->getsv('logout'); ?></a></li>

        </ul>
    </nav>
</header>

<?php echo $this->section['dashboard']; ?>
<?php //echo $this->section['admin-create']; ?>
<?php if($this->section['siteOptionsAside'] || $this->section['masterAdminAside']): ?>
    <div class="cl">
        <?php echo $this->section['siteOptionsHeader']; ?>
        <?php echo $this->section['siteOptionsAside']; ?>
        <?php echo $this->section['siteOptionsContainer']; ?>
        <?php echo $this->section['showSiteLanguages']; ?>
        <?php echo $this->section['showSiteVars']; ?>
        <?php echo $this->section['showCategories']; ?>
        <?php echo $this->section['showSections']; ?>
        <?php echo $this->section['masterAdminHeader']; ?>
        <?php echo $this->section['masterAdminAside']; ?>
        <?php echo $this->section['showAdmins']; ?>
    </div>
<?php endif ?>

</body>
</html>