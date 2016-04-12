<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 13.12.2015 г.
 * Time: 13:15
 */

namespace Cms\Models;

class SiteVarModel extends BaseModel
{
    private $id = null;
    /**
     * @var string | null
     */
    private $key = null;
    /**
     * @var string | null
     */
    private $value = null;
    /**
     * @var string | null
     */
    private $languageKey = null;
    /**
     * @var string | null
     */
    private $categoryKey = null;

    /**
     * SiteVarModel constructor.
     * @param $key
     * @param $value
     * @param $languageKey
     * @param null $categoryKey
     * @param null $id
     */
    public function __construct($key, $value, $languageKey, $categoryKey, $id = null)
    {
        $this->setKey($key);
        $this->setValue($value);
        $this->setLanguageKey($languageKey);
        $this->setCategoryKey($categoryKey);
        if($id) $this->setId($id);
    }

    /**
     * @return null|string
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
        $validator = new \Cms\Validation();
        $validator->setRule('required', $languageKey, '', 'language key is required')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('site-var-language', $validator->getErrors());
            exit;
        }
        $this->languageKey = $languageKey;
    }

    /**
     * @return int|null
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
        $key = \Cms\Common::normalize($key, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $key, '', 'Site var key is required!.')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('siteVarKey', $validator->getErrors());
            exit;
        }
        $this->key = $key;
    }

    /**
     * @return null|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @throws \Exception
     */
    public function setValue($value)
    {
        $value = \Cms\Common::normalize($value, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $value, '', 'Site var value is required!')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('siteVarValue', $validator->getErrors());
            exit;
        }
        $this->value = $value;
    }

    /**
     * @return null
     */
    public function getCategoryKey()
    {
        return $this->categoryKey;
    }

    /**
     * @param $categoryKey
     */
    public function setCategoryKey($categoryKey)
    {
        $categoryKey = \Cms\Common::normalize($categoryKey, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $categoryKey, '', 'Site var category key is required!')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('site-var-category-key', $validator->getErrors());
            exit;
        }
        $this->categoryKey = $categoryKey;
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
        $this->id = $id;
    }

    /**
     * @param LanguageModel $language
     * @param null $categoryFilter
     * @return array|null
     */
    public static function getAllSiteVars(\Cms\Models\LanguageModel $language, $categoryFilter = null) {
        return \Cms\Repositories\SiteVarRepository::getInstance()->getAllSiteVars($language, $categoryFilter);
    }

    /**
     * @param SiteVarModel $model
     * @return mixed
     */
    public static function createSiteVar(\Cms\Models\SiteVarModel $model) {
        return \Cms\Repositories\SiteVarRepository::getInstance()->createSiteVar($model);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getSiteVarById($id) {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        return \Cms\Repositories\SiteVarRepository::getInstance()->getSiteVarById($id);
    }

    /**
     * @return mixed
     */
    public function updateSiteVar() {
        $newSv = \Cms\Repositories\SiteVarRepository::getInstance()->updateSiteVar($this);
        $newSvCat = \Cms\Repositories\SiteVarRepository::getInstance()->updateSiteVarCategory($this);
        return $newSv + $newSvCat;
    }

    /**
     * @return mixed
     */
    public function deleteSiteVar() {
        return \Cms\Repositories\SiteVarRepository::getInstance()->deleteSiteVar($this);
    }
}