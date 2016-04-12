<aside id="site-options-aside" class="left-aside">
    <ul>
        <li><a href="<?php echo \Cms\Paths::link('admin/site-options/languages'); ?>"><?php echo \Cms\App::getInstance()->getsv('language'); ?></a></li>
        <li><a href="<?php echo \Cms\Paths::link('admin/site-options/site-vars'); ?>"><?php echo \Cms\App::getInstance()->getsv('site_vars'); ?></a></li>
        <li><a href="<?php echo \Cms\Paths::link('admin/site-options/categories'); ?>"><?php echo \Cms\App::getInstance()->getsv('categories'); ?></a></li>
        <li><a href="<?php echo \Cms\Paths::link('admin/site-options/sections'); ?>"><?php echo \Cms\App::getInstance()->getsv('sections'); ?></a></li>
        <li><a href="#">Some Link</a></li>
        <li><a href="#">Some Link</a></li>
    </ul>
</aside>