<?php
/**
 * Created by bro555555.
 * User: George
 * Date: 11.11.2015 г.
 * Time: 11:19
 */
if(\Cms\App::getInstance()->getSession()->admin['role_id'] < 3) {
    $cfg['admin']['namespace'] = 'Cms\Controllers\Admin';

    $cfg['admin']['controllers']['dashboard']['controller'] = 'dashboard';
    $cfg['admin']['controllers']['dashboard']['methods']['index'] = 'index';

    $cfg['admin']['controllers']['master-admin']['controller'] = 'masterAdmin';
    $cfg['admin']['controllers']['master-admin']['methods']['index'] = 'index';
    $cfg['admin']['controllers']['master-admin']['methods']['create-admin'] = 'createAdmin';
    $cfg['admin']['controllers']['master-admin']['methods']['show-admins'] = 'showAdmins';
    $cfg['admin']['controllers']['master-admin']['methods']['delete-admin'] = 'deleteAdmin';
    $cfg['admin']['controllers']['master-admin']['methods']['edit-admin'] = 'editAdmin';

    $cfg['admin']['controllers']['site-options']['controller'] = 'siteOptions';
    $cfg['admin']['controllers']['site-options']['methods']['index'] = 'index';
    $cfg['admin']['controllers']['site-options']['methods']['languages'] = 'languages';
    $cfg['admin']['controllers']['site-options']['methods']['site-vars'] = 'siteVars';
    $cfg['admin']['controllers']['site-options']['methods']['categories'] = 'categories';
    $cfg['admin']['controllers']['site-options']['methods']['sections'] = 'sections';
}

$cfg['*']['namespace'] = 'Cms\Controllers';

// Definition of controller home
$cfg['controllers']['index']['controller'] = 'home';
// Definition of method index of the controller home
$cfg['controllers']['index']['methods']['index'] = 'index';
$cfg['controllers']['manage']['controller'] = 'manage';
$cfg['controllers']['manage']['methods']['logout'] = 'logout';
//$cfg['controllers']['manage']['methods']['manage'] = 'index';
$cfg['controllers']['user']['controller'] = 'user';
$cfg['controllers']['user']['methods']['login'] = 'login';
$cfg['controllers']['user']['methods']['logout'] = 'logout';
$cfg['controllers']['user']['methods']['register'] = 'register';

return $cfg;