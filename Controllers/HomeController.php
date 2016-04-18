<?php
/**
 * Created by bro555555.
 * User: George
 * Date: 6.11.2015 г.
 * Time: 22:45
 */

namespace Cms\Controllers;

use Cms\Models\SectionModel;
use Cms\View;
use Cms\InputData as input;

class HomeController extends BaseController
{
    public function index()
    {
        View::appendPage('home', 'project.home');
        $section = \Cms\Models\SectionModel::getSectionByKeyAndLanguage('sectionKey');
        $resources = $section->getSectionResources();
        $model['section'] = $section;
        $model['resources'] = $resources;
//        echo "<pre>".print_r($model, true)."</pre>"; exit;
        return new View('Templates.defaultTemplate', $model);
    }
}