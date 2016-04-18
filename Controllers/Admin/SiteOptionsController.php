<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 23.2.2016 г.
 * Time: 14:44
 */

namespace Cms\Controllers\Admin;


use Cms\Controllers\BaseController;
use Cms\Models\CategoryModel;
use \Cms\View;

class SiteOptionsController extends BaseController
{
    public function index() {
        View::appendPage('siteOptionsHeader', 'admin.partials.siteOptionsHeader');
        View::appendPage('siteOptionsAside', 'admin.partials.siteOptionsAside');
        return new View('Templates.adminTemplate', []);
    }

    //**********LANGUAGES**********//
    public function languages() {
        if($this->input->isGet()) {

            if($this->input->hasGet(0)) {
            // ******Shows form for create or update a language
                $this->createOrUpdateLanguage();
            } else {
                $this->getAllLanguages();
            }

        } else if($this->input->isPost()) {

            if($this->input->getPostById('action') === 'create-language') {

                $this->createLanguage();

            } else if($this->input->getPostById('action') === 'get-language') {

                $this->getLanguage();

            } else if($this->input->getPostById('action') === 'update') {

                $this->updateLanguage();

            } else if($this->input->getPostById('action') === 'delete') {

                $this->deleteLanguage();

            } else if($this->input->getPostById('action') === 'change-language') {

                $this->changeLanguage();

            } else if($this->input->getPostById('action') === 'change-site-lang') {
                $this->changeSiteLang();

            }
        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function getAllLanguages() {
        View::appendPage('siteOptionsHeader', 'admin.partials.siteOptionsHeader');
        View::appendPage('siteOptionsAside', 'admin.partials.siteOptionsAside');
        View::appendPage('showSiteLanguages', 'admin.partials.languages.showSiteLanguages');
        $appLang = new \Cms\Models\LanguageModel(
            \Cms\App::getInstance()->getSession()->appLanguage['key'],
            \Cms\App::getInstance()->getSession()->appLanguage['value']
        );
        $languages = \Cms\Models\LanguageModel::getAllLanguages($appLang);
        foreach ($languages as $language) {
            $language = (object)$language;
            $language->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $language->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model[] = $language;
        }
        $model['current'] = \Cms\Models\LanguageModel::getDefaultSiteLang()['id'];
        return new View('Templates.adminTemplate', $model);
    }

    private function createOrUpdateLanguage() {
        if($this->input->getGetByKey(0) === 'create' || $this->input->getGetByKey(0) === 'edit') {
            $model['action'] = $this->input->getGetByKey(0);
            return new View('admin.partials.languages.createLanguage', $model);

        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function createLanguage() {
        if($this->input->getPostById('langAbbreviation') && $this->input->getPostById('language')) {
            $abbreviation = $this->input->getPostById('langAbbreviation', 'trim, string, xss');
            $language = $this->input->getPostById('language', 'trim, string, xss');
            $langModel = new \Cms\Models\LanguageModel($abbreviation, $language);
            if($langModel->getErrors() > 0) {
                foreach ($langModel as $errorKey) {
                    foreach ($errorKey as $error) {
                        echo '<p class="error">'.$error.'</p>'; exit;
                    }
                }
            }
            $result = $langModel->save();
            if($result) {
                echo '<p class="success">The Language was successfully added</p>';
            } else {
                echo '<p class="error">Invalid Language data!</p>';
            }
        } else {
            echo '<p class="error">Invalid Language data!</p>';
        }
    }

    private function getLanguage() {
        $id = $this->input->getPostById('langId', 'trim, int, xss');
        $language = \Cms\Models\LanguageModel::getLanguageById($id);
        echo json_encode($language);
    }

    private function updateLanguage() {
        $langAbbreviation = $this->input->getPostById('abbreviation', 'trim, string, xss');
        $language = $this->input->getPostById('language', 'trim, string, xss');
        $id = $this->input->getPostById('id', 'trim, int, xss');
        $oldKey = $this->input->getPostById('oldKey', 'trim, string, xss');
        if($langAbbreviation && $language && $id) {
            $langModel = new \Cms\Models\LanguageModel($langAbbreviation, $language, $id);
            if(!empty($langModel)) {
                $result = $langModel->updateLanguage($oldKey);
                echo($result > 0 ? '<p class="success">Language was successfully updated</p>' :  '<p class="error">Error updating language</p>');
            }
        } else {
            echo '<p class="error">Error updating language</p>';
        }
    }

    private function deleteLanguage() {
        $id = $this->input->getPostById('id', 'trim, int, xss');
        if($id) {
            $language = \Cms\Models\LanguageModel::getLanguageById($id);
            $deleteModel = new \Cms\Models\LanguageModel($language['key'], $language['value']);
            if($language['key'] == \Cms\App::getInstance()->getAppLanguage()['key']) {
                \Cms\App::getInstance()->getSession()->appLanguage = [
                    'id' => \Cms\Models\LanguageModel::getDefaultSiteLang()['id'],
                    'key' => \Cms\Models\LanguageModel::getDefaultSiteLang()['key'],
                    'value' => \Cms\Models\LanguageModel::getDefaultSiteLang()['value'],
                    'parent_key' => \Cms\Models\LanguageModel::getDefaultSiteLang()['parent_key']
                ];
            }
            $result = $deleteModel->deleteLanguage();
            echo($result > 0 ? '' : '<p class="error">Error deleting language.</p>');
        }
    }

    private function changeLanguage() {
        $lang = \Cms\Models\LanguageModel::getLanguageById($this->input->getPostById('langId', 'trim, int, xss'));
        $langModel = new \Cms\Models\LanguageModel($lang['key'], $lang['value'], $lang['id'], $lang['key']);
        $languages = \Cms\Models\LanguageModel::getAllLanguages($langModel);
        foreach ($languages as $language) {
            $language = (object) $language;
            $language->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $language->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $langs[] = $language;
            if($language->key === $lang['key'] && $language->parent_key === $lang['key']) $langs['current'] = $language->id;
        }
        return new View('admin.partials.languages.ShowSiteLanguages', $langs);
    }

    private function changeSiteLang() {
        $lang = new \Cms\Models\LanguageModel(
            \Cms\Models\LanguageModel::getLanguageByKeyAndParent($this->input->getPostById('setLang', 'trim, string, xss'), $this->input->getPostById('setLang', 'trim, string, xss'))['key'],
            \Cms\Models\LanguageModel::getLanguageByKeyAndParent($this->input->getPostById('setLang', 'trim, string, xss'), $this->input->getPostById('setLang', 'trim, string, xss'))['value'],
            \Cms\Models\LanguageModel::getLanguageByKeyAndParent($this->input->getPostById('setLang', 'trim, string, xss'), $this->input->getPostById('setLang', 'trim, string, xss'))['id'],
            \Cms\Models\LanguageModel::getLanguageByKeyAndParent($this->input->getPostById('setLang', 'trim, string, xss'), $this->input->getPostById('setLang', 'trim, string, xss'))['parent_key']
        );
        \Cms\App::getInstance()->getSession()->appLanguage = [
            'id' => $lang->getId(),
            'key' => $lang->getKey(),
            'value' => $lang->getValue(),
            'parent_key' => $lang->getParentKey()
        ];
    }

    //***********CATEGORIES***********//
    public function categories() {
        if($this->input->isGet()) {
            if($this->input->hasGet(0)) {
                $this->createOrUpdateCategory();
            } else {
                $this->getAllCategories();
            }

        } else if($this->input->isPost()) {
            if($this->input->getPostById('action') === 'get-cats-by-lang') {
               $this->getCatsByLang();
            } else if($this->input->getPostById('action') === 'category-filter') {
                $this->categoryFilter();
            } else if($this->input->getPostById('action') === 'create-category') {
                $this->createCategory();
            } else if($this->input->getPostById('action') === 'delete-category') {
                $this->deleteCategory();
            } else if($this->input->getPostById('action') === 'get-category') {
                $this->getCategory();
            } else if($this->input->getPostById('action') === 'edit-category') {
                $this->editCategory();
            }
        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function createOrUpdateCategory() {
        if($this->input->getGetByKey(0) === 'create' || $this->input->getGetByKey(0) === 'edit') {
            $categories = \Cms\Models\CategoryModel::getAllCategories(
                new \Cms\Models\LanguageModel(
                    \Cms\App::getInstance()->getSession()->appLanguage['key'],
                    \Cms\App::getInstance()->getSession()->appLanguage['value'],
                    \Cms\App::getInstance()->getSession()->appLanguage['id'],
                    \Cms\App::getInstance()->getSession()->appLanguage['parent_key']
                )
            );
            $model['categories'] = $categories;
            $model['action'] = $this->input->getGetByKey(0);
            return new View('admin.partials.categories.createCategory', $model);

        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function getAllCategories() {
        $activeSiteLanguage = new \Cms\Models\LanguageModel(
            \Cms\App::getInstance()->getSession()->appLanguage['key'],
            \Cms\App::getInstance()->getSession()->appLanguage['value'],
            \Cms\App::getInstance()->getSession()->appLanguage['id']
        );
        $languages = \Cms\Models\LanguageModel::getAllLanguages($activeSiteLanguage);
        $categories = \Cms\Models\CategoryModel::getAllCategories($activeSiteLanguage);
        foreach ($categories as $category) {
            $category = (object) $category;
            $category->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $category->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model['categories'][] = $category;
        }
        foreach ($languages as $language) {
            $language = (object) $language;
            $model['languages'][] = $language;
        }
        $model['current_lang_id'] = $activeSiteLanguage->getId();
        View::appendPage('siteOptionsHeader', 'admin.partials.siteOptionsHeader');
        View::appendPage('siteOptionsAside', 'admin.partials.siteOptionsAside');
        View::appendPage('showCategories', 'admin.partials.categories.showCategories');
        return new View('Templates.adminTemplate', $model);
    }

    private function getCatsByLang() {
        $langId = $this->input->getPostById('langId', 'trim, int, xss');
        $catLanguage = new \Cms\Models\LanguageModel(
            \Cms\Models\LanguageModel::getLanguageById($langId)['key'],
            \Cms\Models\LanguageModel::getLanguageById($langId)['value'],
            \Cms\Models\LanguageModel::getLanguageById($langId)['id'],
            \Cms\Models\LanguageModel::getLanguageById($langId)['parent_id']
        );
        $categories = \Cms\Models\CategoryModel::getAllCategories($catLanguage);
        foreach ($categories as $category) {
            $result[] = json_encode($category);
        }
        echo json_encode($result);
    }

    private function categoryFilter() {
        $language = \Cms\Models\LanguageModel::getLanguageById($this->input->getPostById('languageId', 'trim, int, xss'));
        $langModel = new \Cms\Models\LanguageModel(
            $language['key'],
            $language['value'],
            \Cms\Models\LanguageModel::getLanguageByKeyAndParent($language['key'], $language['key'])['id'],
            $language['key']
        );
        $cat = \Cms\Models\CategoryModel::getCategoryById($this->input->getPostById('categoryId', 'trim, int, xss'));
        $cat = \Cms\Models\CategoryModel::getCategoryByKeyAndLanguage($langModel, $cat['key']);
        $categories = \Cms\Models\CategoryModel::getAllCategories($langModel, $cat['key']);
        foreach ($categories as $category) {
            $category = (object) $category;
            $category->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $category->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model['categories'][] = $category;
        }
        $langs = \Cms\Models\LanguageModel::getAllLanguages($langModel);
        foreach ($langs as $lang) {
            $model['languages'][] = (object) $lang;
        }
        $listCategories = \Cms\Models\CategoryModel::getAllCategories($langModel);
        foreach ($listCategories as $c) {
            $model['list_categories'][] = (object) $c;
        }
        $model['current_lang_id'] = $langModel->getId();
        $model['current_filter'] = $cat['id'];
        return new View('admin.partials.categories.filteredCategoriesTable', $model);
    }

    private function createCategory() {
        $langKeys = \Cms\Models\LanguageModel::getLangKeys();

        foreach ($langKeys as $langKey) {
            $catModel = new \Cms\Models\CategoryModel(
                $this->input->getPostById('categoryKey'),
                $this->input->getPostById('categoryVal'),
                $langKey['key'],
            \Cms\Models\CategoryModel::getCategoryById($this->input->getPostById('parentKey'))['key']
            );
            $result[] = $catModel->createCategory();
        }
        echo(min($result) > 0 ? '<p class="success">Category was successfully created</p>' : '<p class="error">Error creating Category</p>');
    }

    private function deleteCategory() {
        $catKey = $this->input->getPostById('catKey', 'trim, string, xss');
        $result = \Cms\Models\CategoryModel::deleteCategory($catKey);
        echo($result > 0 ? '<p class="success">The category was successfully deleted</p>' : '<p class="error">Error deleting category</p>');
    }

    private function getCategory() {
        $catId = $this->input->getPostById('catId', 'trim, int, xss');
        $language = \Cms\Models\LanguageModel::getLanguageById($this->input->getPostById('catLang', 'trim, int, xss'));
        $langModel = new \Cms\Models\LanguageModel($language['key'], $language['value'], $language['id'], $language['parent_key']);
        $category = \Cms\Models\CategoryModel::getCategoryById($catId);
        $categories =  \Cms\Models\CategoryModel::getAllCategories($langModel);
        $result['category'] = $category;
        $result['categories'] = $categories;
        echo json_encode($result);
    }

    private function editCategory() {
        $catModel = new \Cms\Models\CategoryModel(
            $this->input->getPostById('catKey'),
            $this->input->getPostById('catVal'),
            $this->input->getPostById('langId'),
            $this->input->getPostById('parentId'),
            $this->input->getPostById('catId')
        );
        $result = $catModel->updateCategory();
        echo ($result > 0 ? '<p class="success">The category was successfully updated</p>' : '<p class="error">Error updating category</p>');
    }

    //***********SITE VARS***********//

    public function siteVars() {
        if($this->input->isGet()) {
            if($this->input->hasGet(0)) {
                $this->createOrUpdateSiteVar();
            } else {
                $this->getAllSiteVars();
            }
        } else if($this->input->isPost()) {

            if($this->input->getPostById('action') === 'create-site-var') {
                $this->createSiteVar();
            } else if($this->input->getPostById('action') === 'edit-sv') {
                $this->getSiteVarForEditing();
            } else if($this->input->getPostById('action') === 'update-sv') {
                $this->updateSiteVar();
            } else if($this->input->getPostById('action') === 'delete-sv') {
                $this->deleteSiteVar();
            } else if($this->input->getPostById('action') === 'sv-filter') {
                $this->siteVarFilter();
            }

        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function createOrUpdateSiteVar() {
        if($this->input->getGetByKey(0) === 'create' || $this->input->getGetByKey(0) === 'edit') {
            $model['action'] = $this->input->getGetByKey(0);
            $defaultLanguage = new \Cms\Models\LanguageModel(
                \Cms\App::getInstance()->getSession()->appLanguage['key'],
                \Cms\App::getInstance()->getSession()->appLanguage['value'],
                \Cms\App::getInstance()->getSession()->appLanguage['id'],
                \Cms\App::getInstance()->getSession()->appLanguage['parent_key']
            );
            $categories = \Cms\Models\CategoryModel::getAllCategories($defaultLanguage);
            foreach ($categories as $category) {
                $model['categories'][] = (object) $category;
            }
            return new View('admin.partials.siteVars.createSiteVar', $model);
        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function getAllSiteVars() {
        $activeSiteLanguage = new \Cms\Models\LanguageModel(
            \Cms\App::getInstance()->getSession()->appLanguage['key'],
            \Cms\App::getInstance()->getSession()->appLanguage['value'],
            \Cms\App::getInstance()->getSession()->appLanguage['id']
        );
        $languages = \Cms\Models\LanguageModel::getAllLanguages($activeSiteLanguage);
        $siteVars = \Cms\Models\SiteVarModel::getAllSiteVars($activeSiteLanguage);
        foreach ($siteVars as $siteVar) {
            $siteVar = (object) $siteVar;
            $siteVar->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $siteVar->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model['siteVars'][] = $siteVar;
        }
        foreach ($languages as $language) {
            $language = (object) $language;
            $model['languages'][] = $language;
        }
        $model['current_lang_id'] = $activeSiteLanguage->getId();
        $categories = \Cms\Models\CategoryModel::getAllCategories($activeSiteLanguage);
        foreach ($categories as $category) {
            $model['categories'][] = (object) $category;
        }
        View::appendPage('siteOptionsHeader', 'admin.partials.siteOptionsHeader');
        View::appendPage('siteOptionsAside', 'admin.partials.siteOptionsAside');
        View::appendPage('showSiteVars', 'admin.partials.siteVars.showSiteVars');
        return new View('Templates.adminTemplate', $model);
    }

    private function createSiteVar() {
            $siteVarModel = new \Cms\Models\SiteVarModel(
                $this->input->getPostById('svKey', 'trim string xss'),
                $this->input->getPostById('siteVar', 'trim string xss'),
                \Cms\App::getInstance()->getSession()->appLanguage['key'],
                $this->input->getPostById('svCategory', 'trim string xss')
            );
            $result[] = \Cms\Models\SiteVarModel::createSiteVar($siteVarModel);
        echo(min($result) > 0 ? '<p class="success">Site var was successfully created</p>' : '<p class="error">Error creating Site var</p>');
    }

    private function getSiteVarForEditing() {
        $sv = \Cms\Models\SiteVarModel::getSiteVarById($this->input->getPostById('svId', 'trim, int, xss'));
        echo json_encode($sv);
    }

    private function updateSiteVar() {
        $svModel = new \Cms\Models\SiteVarModel(
            $this->input->getPostById('svKey', 'trim, string, xss'),
            $this->input->getPostById('svVal', 'trim, string, xss'),
            \Cms\App::getInstance()->getSession()->appLanguage['key'],
            $this->input->getPostById('svCat', 'trim, string, xss'),
            $this->input->getPostById('svId', 'trim, int, xss')
        );
        $result = $svModel->updateSiteVar();
        echo ($result > 0 ? '<p class="success">The site var was successfully updated</p>' : '<p class="error">Error updating site var</p>');
    }

    private function deleteSiteVar() {
        $sv = \Cms\Models\SiteVarModel::getSiteVarById($this->input->getPostById('svId', 'trim, int, xss'));
        $svModel = new \Cms\Models\SiteVarModel(
            $sv['key'],
            $sv['value'],
            $sv['language_key'],
            $sv['category_key']
        );
        $result = $svModel->deleteSiteVar();
        echo($result > 0 ? '<p class="success">Site var was successfully deleted.</p>' : '<p class="error">Error deleting site var</p>');
    }

    private function siteVarFilter() {
        $lang = \Cms\Models\LanguageModel::getLanguageById($this->input->getPostById('langId', 'trim, int, xss'));
        $langModel = new \Cms\Models\LanguageModel(
            $lang['key'],
            $lang['value'],
            \Cms\Models\LanguageModel::getLanguageByKeyAndParent($lang['key'], $lang['key'])['id'],
            \Cms\App::getInstance()->getSession()->appLanguage['key']
        );
        $siteVars = \Cms\Models\SiteVarModel::getAllSiteVars(
            $langModel,
            \Cms\Models\CategoryModel::getCategoryById($this->input->getPostById('svId', 'trim, int, xss'))['key']
        );
        foreach ($siteVars as $siteVar) {
            $siteVar = (object) $siteVar;
            $siteVar->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $siteVar->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model['siteVars'][] = $siteVar;
        }
        $languages = \Cms\Models\LanguageModel::getAllLanguages($langModel);
        foreach ($languages as $language) {
            $language = (object) $language;
            $model['languages'][] = $language;
        }
        $categories = \Cms\Models\CategoryModel::getAllCategories($langModel);
        foreach ($categories as $category) {
            $model['categories'][] = (object) $category;
        }
        $currentCategory = \Cms\Models\CategoryModel::getCategoryByKeyAndLanguage(
            $langModel,
            \Cms\Models\CategoryModel::getCategoryById($this->input->getPostById('svId', 'trim, int, xss'))['key']
        );
        $model['current_lang_id'] = $langModel->getId();
        $model['current_category_id'] = $currentCategory['id'];
        return new View('admin.partials.siteVars.showSiteVars', $model);
    }

    //**********SECTIONS**********//

    public function sections() {
        if($this->input->isGet()) {
            if($this->input->hasGet(0)) {
                $this->input->getGetByKey(0) === 'settings' ? $this->setSettings() : $this->createOrUpdateSection();
            } else {
                $this->getAllSections();
            }

        } else if($this->input->isPost()) {
            if($this->input->getPostById('action') === 'create-section-get-language') {
                $this->createSectionGetLang();
            } else if($this->input->getPostById('action') === 'create-section') {
                $this->createSection();
            } else if($this->input->getPostById('action') === 'get-section-for-edit') {
                $this->getSectionForEditing();
            } else if($this->input->getPostById('action') === 'update-section') {
                $this->updateSection();
            } else if($this->input->getPostById('action') === 'delete-section') {
                $this->deleteSection();
            } else if($this->input->getPostById('action') === 'section-filter') {
                $this->sectionFilter();
            } else if($this->input->getPostById('action') === 'set-section-visibility') {
                $this->changeSectionVisibility();
            } else if($this->input->getPostById('action') === 'get-section-settings') {
                $this->getSectionSettings();
            } else if($this->input->getPostById('action') === 'get-create-section-field-form') {
                $this->getCreateSectionFieldForm();
            } else if($this->input->getPostById('action') === 'create-section-field') {
                $this->createSectionField();
            } else if($this->input->getPostById('action') === 'delete-ext-field') {
                $this->deleteExtField();
            } else if($this->input->getPostById('action') === 'delete-resource') {
                $this->deleteResource();
            }
        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function createOrUpdateSection() {
        if($this->input->getGetByKey(0) === 'create' || $this->input->getGetByKey(0) === 'edit') {
            $model['action'] = $this->input->getGetByKey(0);
            return new View('admin.partials.sections.createSection', $model);
        } else {
            throw new \Exception('Bad request', 404);
        }
    }

    private function createSectionGetLang() {
        $lang = \Cms\Models\LanguageModel::getLanguageById($this->input->getPostById('langId', 'trim int xss'));
        $categories = \Cms\Models\CategoryModel::getAllCategories(
            new \Cms\Models\LanguageModel(
                $lang['key'],
                $lang['value'],
                $lang['id'],
                $lang['parent_key']
            )
        );
        foreach ($categories as $category) {
            $category = (object) $category;
            $result[] = $category;
        }
        echo json_encode($result);
    }

    private function createSection() {
        $sectionModel = new \Cms\Models\SectionModel(
            null,
            $this->input->getPostById('sec-key'),
            $this->input->getPostById('sec-title'),
            $this->input->getPostById('section-body'),
            $this->input->getPostById('sec-desc'),
            \Cms\App::getInstance()->getAppLanguage()['key'],
            $this->input->getPostById('sec-category')
        );
        if($sectionModel->getErrors()) {
            echo $sectionModel->getErrors()[0];
        } else {
            $result = $sectionModel->createSection();
//            echo ($result > 0 ? '<p class="success">Section was created successfully</p>' : '<p class="error">Error creating section</p>');
            $this->getAllSections();
        }

    }

    private function getAllSections() {
        $langs = \Cms\Models\LanguageModel::getAllLanguages(
            new \Cms\Models\LanguageModel(
                \Cms\App::getInstance()->getAppLanguage()['key'],
                \Cms\App::getInstance()->getAppLanguage()['value'],
                \Cms\App::getInstance()->getAppLanguage()['id'],
                \Cms\App::getInstance()->getAppLanguage()['parent_key']
            )
        );
        $cats = \Cms\Models\CategoryModel::getAllCategories(
            new \Cms\Models\LanguageModel(
                \Cms\App::getInstance()->getAppLanguage()['key'],
                \Cms\App::getInstance()->getAppLanguage()['value'],
                \Cms\App::getInstance()->getAppLanguage()['id'],
                \Cms\App::getInstance()->getAppLanguage()['parent_key']
            )
        );
        $sections = \Cms\Models\SectionModel::getAllSection(
            new \Cms\Models\LanguageModel(
                \Cms\Models\LanguageModel::getCurrentSiteLang()->getKey(),
                \Cms\Models\LanguageModel::getCurrentSiteLang()->getValue(),
                \Cms\Models\LanguageModel::getCurrentSiteLang()->getId(),
                \Cms\Models\LanguageModel::getCurrentSiteLang()->getParentKey()
            )
        );
        foreach ($langs as $lang) {
            $model['languages'][] = (object) $lang;
        }
        foreach ($cats as $cat) {
            $model['categories'][] = (object) $cat;
        }
        foreach ($sections as $section) {
            $section = (object) $section;
            $section->visibility == 0 ? $section->visibility = '<img src="' . \Cms\Paths::link('images/forbidden.png') . '" width="20" height=""20>' : $section->visibility = '<img src="' . \Cms\Paths::link('images/allowed.png') . '" width="20" height=""20>';
            $section->settings = '<img src="' . \Cms\Paths::link('images/settings.png') . '" width="20" height=""20>';
            $section->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $section->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model['sections'][] = $section;
            $model['current_lang_id'] = \Cms\App::getInstance()->getAppLanguage()['id'];
        }
        View::appendPage('siteOptionsHeader', 'admin.partials.siteOptionsHeader');
        View::appendPage('siteOptionsAside', 'admin.partials.siteOptionsAside');
        View::appendPage('showSections', 'admin.partials.sections.showSections');
        return new View('Templates.adminTemplate', $model);
    }

    private function getSectionForEditing() {
        $lang = \Cms\Models\LanguageModel::getLanguageById($this->input->getPostById('langId', 'trim, int, xss'));
        $cats = \Cms\Models\CategoryModel::getAllCategories(
            new \Cms\Models\LanguageModel($lang['key'], $lang['value'], $lang['id'], $lang['parent_key'])
        );
        $secArray = \Cms\Models\SectionModel::getSectionById($this->input->getPostById('secId', 'trim, int, xss'));
        $section = new \Cms\Models\SectionModel(
            $secArray['id'],
            $secArray['key'],
            $secArray['title'],
            $secArray['body'],
            $secArray['short_desc'],
            $secArray['language_key'],
            $secArray['category_key'],
            $secArray['visibility']
        );
        $extFields = $section->getExternalSectionFields();
        $resources = $section->getSectionResources();
        foreach ($extFields as $extField) {
            foreach ($resources as $resource) {
                if(($extField->label.'-'.$extField->id) == $resource['key']) {
                    $extField->res = $resource['value'];
                }
            }
        }
        $result['ext_fields'] = $extFields;
        $result['categories'] = $cats;
        $result['section'] = (object) $secArray;
//        echo "<pre>".print_r($result, true)."</pre>"; exit;
        return new View('admin.partials.sections.createSection', $result);
    }

    private function updateSection() {
        $root = $_SERVER['DOCUMENT_ROOT'] . 'Cms\public\\';
        $uploadDir = realpath($root . 'images');

        $section = new \Cms\Models\SectionModel(
            $this->input->getPostById('section-id', 'trim, int, xss'),
            $this->input->getPostById('sec-category', 'trim, string, xss'),
            $this->input->getPostById('sec-title', 'trim, string, xss'),
            $this->input->getPostById('section-body', 'trim, string, xss'),
            $this->input->getPostById('sec-desc', 'trim, string, xss'),
            \Cms\Models\SectionModel::getSectionById($this->input->getPostById('section-id', 'trim, int, xss'))['language_key'],
            $this->input->getPostById('sec-category', 'trim, string, xss')
        );
        $extFields = $section->getExternalSectionFields();
        foreach ($extFields as $extField) {
            $resource = new \Cms\Models\ResourceModel(
                $extField->id,
                $extField->label . '-' . $extField->id,
                $this->input->getPostById(str_replace(' ', '_', $extField->label . '-' . $extField->id)),
                $this->input->getPostById('section-id')
            );
            if($extField->type === 'file') {
                foreach ($_FILES as $k => $v) {
                    if($v['name']) {
                        move_uploaded_file($v['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $v['name']);
                        $resource = new \Cms\Models\ResourceModel(
                            $extField->id,
                            $extField->label . '-' . $extField->id,
                            $v['name'],
                            $this->input->getPostById('section-id')
                        );
                    }
                }
            }
            if ($resource->getResourceByKey()) {
                $resource->updateResource();
            } else {
                $resource->addResource();
            }

        }
        $result = $section->updateSection(
            \Cms\Models\SectionModel::getSectionById($this->input->getPostById('section-id', 'trim, int, xss'))['category_key']
        );
//        echo ($result > 0 ? '<p class="success">Section was successfully updated</p>' : '<p class="error">Error updating section</p>');
        $this->getAllSections();
    }

    private function deleteSection() {
        $section = \Cms\Models\SectionModel::getSectionById($this->input->getPostById('secId', 'trim, int, xss'));
        $sectionModel = new \Cms\Models\SectionModel(
            $section['id'],
            $section['key'],
            $section['title'],
            $section['body'],
            $section['short_desc'],
            $section['language_key'],
            $section['category_key']
        );
        $result = $sectionModel->deleteSection();
        echo($result > 0 ? '<p class="success">Section was successfully deleted</p>' : '<p class="error">Error deleting section!</p>');
    }

    private function sectionFilter() {
        $language = \Cms\Models\LanguageModel::getLanguageById($this->input->getPostById('langId', 'trim, int, xss'));
        $langModel = new \Cms\Models\LanguageModel(
            $language['key'],
            $language['value'],
            $language['id'],
            $language['parent_key']
        );
        $category = \Cms\Models\CategoryModel::getCategoryById($this->input->getPostById('catId', 'trim, int, xss'));
        $sections = \Cms\Models\SectionModel::getAllSection($langModel, $category['key']);
        foreach ($sections as $section) {
            $section = (object) $section;
            $section->visibility == 0 ? $section->visibility = '<img src="' . \Cms\Paths::link('images/forbidden.png') . '" width="20" height=""20>' : $section->visibility = '<img src="' . \Cms\Paths::link('images/allowed.png') . '" width="20" height=""20>';
            $section->settings = '<img src="' . \Cms\Paths::link('images/settings.png') . '" width="20" height=""20>';
            $section->edit = '<img src="' . \Cms\Paths::link('images/edit.png') . '" width="20" height=""20>';
            $section->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model[] = $section;
        }
        return new View('admin.partials.sections.filteredSections', $model);
    }

    private function changeSectionVisibility() {
        $section = \Cms\Models\SectionModel::getSectionById($this->input->getPostById('secId', 'trim, int, xss'));
        if($this->input->getPostById('visibility') == 0) {
            $visibility = 1;
        } else {
            $visibility = 0;
        }
        $secModel = new \Cms\Models\SectionModel(
            $section['id'],
            $section['key'],
            $section['title'],
            $section['body'],
            $section['short_desc'],
            $section['language_key'],
            $section['category_key'],
            $visibility
        );
        $secModel->changeSectionVisibility();
        $this->sectionFilter();
    }

    private function setSettings() {
        return new View('admin.partials.sections.settingsNav', []);
    }

    private function getSectionSettings() {
        $section = \Cms\Models\SectionModel::getSectionById($this->input->getPostById('secId', 'trim, int, xss'));
        $section = new \Cms\Models\SectionModel(
            $section['id'],
            $section['key'],
            $section['title'],
            $section['body'],
            $section['short_desc'],
            $section['language_key'],
            $section['category_key']
        );
        $fields = $section->getExternalSectionFields();
        foreach ($fields as $field) {
            $field = (object) $field;
            $field->delete = '<img src="' . \Cms\Paths::link('images/delete.png') . '" width="20" height=""20>';
            $model[] = $field;
        }
        return new View('admin.partials.sections.settingsFields', $model);
    }

    private function getCreateSectionFieldForm() {
        return new View('admin.partials.sections.createExternalField', []);
    }

    private function createSectionField() {
        $section = \Cms\Models\SectionModel::getSectionById($this->input->getPostById('secId', 'trim, int, xss'));
        $sections = \Cms\Models\SectionModel::getSectionsByKey($section['key']);
        foreach ($sections as $s) {
            $s = new \Cms\Models\SectionModel(
                $s['id'],
                $s['key'],
                $s['title'],
                $s['body'],
                $s['short_desc'],
                $s['language_key'],
                $s['category_key']
            );
            $field = new \Cms\Models\ExternalSectionFieldModel(
                null,
                $this->input->getPostById('fLabel', 'trim, string, xss'),
                $this->input->getPostById('fType', 'trim, string, xss'),
                $this->input->getPostById('secId', 'trim, int, xss')
            );
            $s->addExternalField($field);
        }
        $this->getAllSections();
    }

    private function deleteExtField() {
        $field = \Cms\Repositories\ExternalSectionFieldRepository::getInstance()->getExtFieldById($this->input->getPostById('extFieldId'));
        $result = \Cms\Repositories\ExternalSectionFieldRepository::getInstance()->deleteExtField($field['label']);
        echo ($result > 0 ? '<p class="success">Field was deleted successfully</p>' : '<p class="error">Error deleting field</p>');
    }

    private function deleteResource() {
        $res = new \Cms\Models\ResourceModel(
            null,
            $this->input->getPostById('resId'),
            'value',
            '1'
            );
        $resource = $res->getResourceByKey();
        $resource = new \Cms\Models\ResourceModel(
            $resource[0]->id,
            $resource[0]->key,
            $resource[0]->value,
            $resource[0]->section_id
        );
        $result = $resource->deleteResource();
        if($result > 0) echo 'deleted';
    }

}