<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 6.11.2015 г.
 * Time: 19:15
 */

$cfg['default_controller']='home';
$cfg['default_method']='index';

$cfg['namespace']['Cms\Controllers'] = '../Controllers';
$cfg['namespace']['Cms\Models'] = '../Models';
$cfg['namespace']['Cms\Views'] = '../Views';

$cfg['session']['type'] = 'native';
$cfg['session']['autostart'] = true;
$cfg['session']['name'] = '_sess';
$cfg['session']['lifetime'] = null;
$cfg['session']['path'] = '/';
$cfg['session']['domain'] = '';
$cfg['session']['secure'] = false;

return $cfg;