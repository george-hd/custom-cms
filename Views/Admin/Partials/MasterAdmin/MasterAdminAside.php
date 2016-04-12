<?php
use \Cms\App as app;
?>
<aside id="master-admin-aside" class="left-aside">
    <ul>
        <li><a href="<?php echo \Cms\Paths::link('admin/master-admin/show-admins'); ?>">Administrators</a></li>
        <li><a href="<?php echo \Cms\Paths::link('admin/site-options/site-vars'); ?>">Site vars</a></li>
        <li><a href="<?php echo \Cms\Paths::link('admin/site-options/categories'); ?>">Categories</a></li>
        <li><a href="<?php echo \Cms\Paths::link('admin/section'); ?>">Sections</a></li>
    </ul>
</aside>