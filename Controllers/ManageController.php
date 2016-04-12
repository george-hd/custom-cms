<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 28.2.2016 г.
 * Time: 16:40
 */

namespace Cms\Controllers;


use Cms\View;

class ManageController extends BaseController
{
    public function index() {

        if($this->input->isGet()) {
            if(\Cms\App::getInstance()->getSession()->admin) {
                $this->redirect('admin/dashboard');
            } else {
                return new View('admin.adminLogin', []);
            }
        } else if($this->input->isPost()) {
            if($this->input->hasPost('admin-name') && $this->input->hasPost('password')) {
                $adminName = \Cms\Common::normalize($this->input->getPostById('admin-name'), 'trim, string, xss');
                $password = \Cms\Common::normalize($this->input->getPostById('password'), 'trim, string, xss');
                $adminModel = new \Cms\Models\AdminModel(null, $adminName, null, null);
                $admin = \Cms\Repositories\AdminRepository::getInstance()->getAdminByName($adminModel);
                if($admin['name'] === $adminName && $password === $admin['password']) {
                    \Cms\App::getInstance()->getSession()->admin = [
                        'id' => $admin['id'],
                        'name' => $admin['name'],
                        'role_id' => $admin['role_id'],
                        'isLogged' => true
                    ];
                    $this->redirect('admin/dashboard');
                } else {
                    $this->redirect('home');
                }
            }
        }
    }

    public function logout() {
        unset($_SESSION['admin']);
        $this->redirect('');
    }
}