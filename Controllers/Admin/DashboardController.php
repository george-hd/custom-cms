<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 23.2.2016 г.
 * Time: 14:35
 */

namespace Cms\Controllers\Admin;


use Cms\Controllers\BaseController;
use Cms\View;

class DashboardController extends BaseController
{
    public function index() {
        View::appendPage('dashboard', 'admin.partials.dashboard');
        return new View('Templates.adminTemplate', []);
    }
}