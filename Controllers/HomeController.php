<?php
/**
 * Created by bro555555.
 * User: George
 * Date: 6.11.2015 г.
 * Time: 22:45
 */

namespace Cms\Controllers;

use Cms\View;
use Cms\InputData as input;

class HomeController extends BaseController
{
    public function index()
    {
        View::appendPage('home', 'project.home');
        $model = \Cms\Models\SectionModel::getSectionByKey('section_key');
        return new View('Templates.defaultTemplate', $model);
    }
}