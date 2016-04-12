<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 13.12.2015 г.
 * Time: 13:26
 */

namespace Cms\Models;

class LanguageModel extends BaseModel
{
    private $id;
    private $key;
    private $value;
    private $parentKey;

    /**
     * LanguageModel constructor.
     * @param $key
     * @param $value
     */
    public function __construct($key, $value, $id = null, $parentKey = null)
    {
        $this->setKey($key);
        $this->setValue($value);
        if($id) {
            $this->setId($id);
        }
        if($parentKey) {
            $this->setParentKey($parentKey);
        }
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param $key
     * @throws \Exception
     */
    public function setKey($key)
    {
        $validator = new \Cms\Validation();
        $validator->setRule('required', $key, '', 'Language id is required.')
            ->setRule('gt', $key, '0', 'Language id must be greater then 0.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['id'] = $validator->getErrors()[0];
        }
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $validator = new \Cms\Validation();
        $validator->setRule('required', $value, '', 'Language value is required.')
            ->setRule('minlen', $value, '1', 'Language value must be more then 1 symbol.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['val'] = $validator->getErrors()[0];
        }
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        if($id === 0) $id = null;
        $this->id = $id;
    }

    /**
     * @return mixed
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

    //*********Language API************//

    /**
     * @param LanguageModel $language
     * @return mixed
     */
    public static function getAllLanguages(\Cms\Models\LanguageModel $language) {
        return \Cms\Repositories\LanguageRepository::getInstance()->getAllLanguages($language);
    }

    /**
     * @return mixed
     */
    public static function getDefaultSiteLang() {
        return \Cms\Repositories\LanguageRepository::getInstance()->getDefaultSiteLang();
    }

    /**
     * @return mixed
     */
    public static function getLangKeys() {
        return \Cms\Repositories\LanguageRepository::getInstance()->getLangKeys();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getLanguageById($id) {
        $id = \Cms\Common::normalize($id, 'trim int xss');
        return \Cms\Repositories\LanguageRepository::getInstance()->getLanguageById($id);
    }

    /**
     * @param $key
     * @param $parent
     * @return mixed
     */
    public static function getLanguageByKeyAndParent($key, $parent) {
        $key = \Cms\Common::normalize($key, 'trim, string, xss');
        $parent = \Cms\Common::normalize($parent, 'trim, string, xss');
        return \Cms\Repositories\LanguageRepository::getInstance()->getLanguageByKeyAndParent($key, $parent);
    }

    /**
     * @return mixed
     */
    public function save() {
        return \Cms\Repositories\LanguageRepository::getInstance()->addLanguage($this);
    }

    /**
     * @param $oldKey
     * @return int
     */
    public function updateLanguage($oldKey) {
        $oldKey = \Cms\Common::normalize($oldKey, 'trim, string, xss');
        return \Cms\Repositories\LanguageRepository::getInstance()->updateLanguage($this, $oldKey);
    }

    /**
     * @return mixed
     */
    public function deleteLanguage() {
        return \Cms\Repositories\LanguageRepository::getInstance()->deleteLanguage($this);
    }

    /**
     * @return LanguageModel
     */
    public static function getCurrentSiteLang() {
        return new \Cms\Models\LanguageModel(
            \Cms\App::getInstance()->getSession()->appLanguage['key'],
            \Cms\App::getInstance()->getSession()->appLanguage['value'],
            \Cms\App::getInstance()->getSession()->appLanguage['id'],
            \Cms\App::getInstance()->getSession()->appLanguage['parent_key']
        );
    }
}