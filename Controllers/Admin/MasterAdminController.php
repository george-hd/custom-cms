<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 29.2.2016 г.
 * Time: 11:46
 */

namespace Cms\Controllers\Admin;


use Cms\Controllers\BaseController;
use Cms\View;

class MasterAdminController extends BaseController
{
    public function index() {
        if($this->input->isGet() && empty($this->input->getGetByKey(0))) {

            View::appendPage('masterAdminAside', 'admin.partials.masterAdmin.masterAdminAside');
            View::appendPage('masterAdminHeader', 'admin.partials.masterAdmin.masterAdminHeader');

            return new View('Templates.adminTemplate', []);

        } else {
            throw new \Exception('Invalid request', 404);
        }
    }

    public function showAdmins() {
        if($this->input->isGet() && empty($this->input->getGetByKey(0))) {
            $admins = \Cms\Repositories\AdminRepository::getInstance()->getAdmins();
            foreach ($admins as $admin) {
                $admin = (object) $admin;
                $admin->edit = '<img src="' .\Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
                $admin->delete = '<img src="' .\Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
                $model[] = $admin;
            }
            View::appendPage('masterAdminAside', 'admin.partials.masterAdmin.masterAdminAside');
            View::appendPage('masterAdminHeader', 'admin.partials.masterAdmin.masterAdminHeader');
            View::appendPage('showAdmins', 'admin.partials.masterAdmin.showAdmins');
            return new View('Templates.adminTemplate', $model);
        }
    }

    public function createAdmin() {
        if($this->input->isGet()) {
            if(empty($this->input->getGetByKey(0))) {

                $model = \Cms\Repositories\RoleRepository::getInstance()->getAllRoles();
                return new View('admin.partials.masterAdmin.adminCreate', $model);

            } else {
                throw new \Exception('Invalid request', 404);
            }
        } else if($this->input->isPost()) {
            if(
                $this->input->getPostById('adminName')
                && $this->input->getPostById('adminPass')
                && $this->input->getPostById('adminRole')
                && $this->input->getPostById('action') === 'create-admin'
            ) {

                $adminModel = new \Cms\Models\AdminModel(
                    null,
                    $this->input->getPostById('adminName'),
                    $this->input->getPostById('adminPass'),
                    $this->input->getPostById('adminRole')
                    );
                if($adminModel->getErrors() > 0) {
                    foreach ($adminModel->getErrors() as $errorKey) {
                        foreach ($errorKey as $error) {
                            echo '<p class="error">'.$error.'</p>'; exit;
                        }
                    }
                } else {
                    $result = \Cms\Repositories\AdminRepository::getInstance()->createAdmin($adminModel);
                    echo($result ? '<p class="success">Admin was successfully crated</p>' : '<p class="error">Error creating admin</p>');
                }

            } else {
                throw new \Exception('Ínvalid request', 404);
            }
        } else {
            throw new \Exception('Invalid request', 404);
        }
    }

    public function editAdmin() {
        if($this->input->isGet()) {
            if(empty($this->input->getGetByKey(0))) {
                $roles = \Cms\Repositories\RoleRepository::getInstance()->getAllRoles();
                $roles['action'] = 'update';
                return new View('admin.partials.masterAdmin.adminCreate', $roles);
            } else {
                throw new \Exception('Invalid request', 404);
            }
        }
        else if($this->input->isPost()) {
            if(
                $this->input->hasPost('adminId') &&
                $this->input->getPostById('action') === 'edit-admin'
            ) {

                $id = \Cms\Common::normalize($this->input->getPostById('adminId'), 'trim, int, xss');
                $admin = \Cms\Repositories\AdminRepository::getInstance()->getAdminById($id);
                echo json_encode($admin);

            } else if(
                $this->input->hasPost('adminId') &&
                $this->input->hasPost('admin') &&
                $this->input->hasPost('adminPass') &&
                $this->input->hasPost('adminRole') &&
                $this->input->getPostById('action') === 'update-admin'
            ) {

                $adminMoldel = new \Cms\Models\AdminModel(
                    $this->input->getPostById('adminId'),
                    $this->input->getPostById('admin'),
                    $this->input->getPostById('adminPass'),
                    $this->input->getPostById('adminRole')
                );
                if($adminMoldel->getErrors() > 0) {
                    foreach ($adminMoldel->getErrors() as $errorKey) {
                        foreach ($errorKey as $error) {
                            echo '<p class="error">'.$error.'</p>'; exit;
                        }
                    }

                } else {
                    $result = \Cms\Repositories\AdminRepository::getInstance()->updateAdmin($adminMoldel);
                    echo($result > 0 ? '<p class="success">Admin was successfully updated</p>' : '<p class="error">Error updating admin</p>');
                }

            } else {
                throw new \Exception('Invalid request', 404);
            }
        }
    }

    public function deleteAdmin() {
        if($this->input->isPost()) {
            if(
                $this->input->hasPost('adminId') &&
                $this->input->getPostById('action') === 'delete-admin'
            ) {

                $admin = \Cms\Repositories\AdminRepository::getInstance()->getAdminById(\Cms\Common::normalize($this->input->getPostById('adminId'),'trim, int, xss'));
                $adminModel = new \Cms\Models\AdminModel($admin['id'], $admin['name'], $admin['password'], $admin['role_id']);
                $result = \Cms\Repositories\AdminRepository::getInstance()->deleteAdmin($adminModel);
                echo ($result ? '<p class="success">The admin was successfully deleted.</p>' : '<p class="error">Error deleting admin</p>');

            } else {
                throw new \Exception('Invalid request', 404);
            }
        } else {
            throw new \Exception('Invalid request', 404);
        }
    }
}