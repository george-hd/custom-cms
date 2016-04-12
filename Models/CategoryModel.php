<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 14.2.2016 г.
 * Time: 11:02
 */

namespace Cms\Models;


class CategoryModel extends BaseModel
{
    private $id = null;
    private $key = null;
    private $value = null;
    private $languageKey = null;
    private $parentKey = null;
    
    public function __construct($key, $value, $languageKey = null, $parentKey = null, $id = null)
    {
        if($id) $this->setId($id);
        $this->setKey($key);
        $this->setValue($value);
        $languageKey === null ? $languageKey = \Cms\App::getInstance()->getSession()->appLanguage['key'] : $this->setLanguageKey($languageKey);
        if($parentKey) $this->setParentKey($parentKey);
    }

    /**
     * @return null
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param null $key
     */
    public function setKey($key)
    {
        $key = \Cms\Common::normalize($key, 'trim, strin, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $key, '', 'Category key is required')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['category_key'] = $validator->getErrors()[0];
        }
        $this->key = $key;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null $value
     */
    public function setValue($value)
    {
        $value = \Cms\Common::normalize($value, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $value, '', 'Category value is required')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['category_value'] = $validator->getErrors()[0];
        }
        $this->value = $value;
    }

    /**
     * @return null
     */
    public function getLanguageKey()
    {
        return $this->languageKey;
    }

    /**
     * @param $languageKey
     */
    public function setLanguageKey($languageKey)
    {
        $languageKey = \Cms\Common::normalize($languageKey, 'trim, string, xss');
        $this->languageKey = $languageKey;
    }

    /**
     * @return null
     */
    public function getParentKey()
    {
        return $this->parentKey;
    }

    /**
     * @param $parentKey
     */
    public function setParentKey($parentKey)
    {
        $parentKey = \Cms\Common::normalize($parentKey, 'trim, string, xss');
        $this->parentKey = $parentKey;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('gt', $id, '0', 'Category id must be greater then 0.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['category_id'] = $validator->getErrors()[0];
        }
        $this->id = $id;
    }

    /**
     * @param LanguageModel $lang
     * @param null $catFilter
     * @return mixed
     */
    public static function getAllCategories(\Cms\Models\LanguageModel $lang, $catFilter = null) {
        return \Cms\Repositories\CategoryRepository::getInstance()->getCategories($lang, $catFilter);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getCategoryById($id) {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        return \Cms\Repositories\CategoryRepository::getInstance()->getCategoryById($id);
    }

    /**
     * @param LanguageModel $language
     * @param $catKey
     * @return mixed
     */
    public static function getCategoryByKeyAndLanguage(\Cms\Models\LanguageModel $language, $catKey) {
        return \Cms\Repositories\CategoryRepository::getInstance()->getCategoryByKeyAndLanguage($language, $catKey);
    }

    /**
     * @return mixed
     */
    public function createCategory() {
        return \Cms\Repositories\CategoryRepository::getInstance()->createCategory($this);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function deleteCategory($key) {
        $key = \Cms\Common::normalize($key, 'trim, string, xss');
        return \Cms\Repositories\CategoryRepository::getInstance()->deleteCategory($key);
    }

    /**
     * @return mixed
     */
    public function updateCategory() {
        return \Cms\Repositories\CategoryRepository::getInstance()->updateCategory($this);
    }

    /**
     * @return mixed
     */
    public function updateCategoryParent() {
        return \Cms\Repositories\CategoryRepository::getInstance()->updateCategoryParent($this);
    }
}