<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 21.2.2016 г.
 * Time: 13:16
 */

namespace Cms\Models;


class SectionModel extends BaseModel
{
    /**
     * @var int|null
     */
    private $id =null;
    /**
     * @var string|null
     */
    private $key = null;
    /**
     * @var string|null
     */
    private $title = null;
    /**
     * @var string|null
     */
    private $body = null;
    /**
     * @var string|null
     */
    private $description = null;
    /**
     * @var string|null
     */
    private $languageKey = null;
    /**
     * @var string|null
     */
    private $categoryKey = null;
    /**
     * @var int|null
     */
    private $visibility = null;

    public function __construct($id, $key, $title, $body, $description, $languageKey, $categoryKey, $visibility = 0)
    {
        if($id) $this->setId($id);
        $this->setKey($key);
        $this->setTitle($title);
        $this->setBody($body);
        $this->setDescription($description);
        $this->setLanguageKey($languageKey);
        $this->setCategoryKey($categoryKey);
        $this->setVisibility($visibility);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('gt', $id, 0, 'Section id must be positive number.')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('sectionId', $validator->getErrors()[0]);
            exit;
        } else {
            $this->id = $id;
        }
    }

    /**
     * @return null|string
     */
    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $key = \Cms\Common::normalize($key, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $key, '', 'Section key is required')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('section', $validator->getErrors());
            exit;
        }
        $this->key = $key;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return mixed
     */
    public function setTitle($title)
    {
        $title = \Cms\Common::normalize($title, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $title, '', 'Section title is required')->validate();
        if($validator->getErrors()) {
            return $this->errors['sectionTitle'] = $validator->getErrors()[0];
        }
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param null $body
     */
    public function setBody($body)
    {
        $body = \Cms\Common::normalize($body, 'trim, string, xss');
        $this->body = $body;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $description = \Cms\Common::normalize($description, 'trim, string, xss');
        $this->description = $description;
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
    public function getCategoryKey()
    {
        return $this->categoryKey;
    }

    /**
     * @param null $categoryKey
     */
    public function setCategoryKey($categoryKey)
    {
        $categoryKey = \Cms\Common::normalize($categoryKey, 'trim, string, xss');
        $this->categoryKey = $categoryKey;
    }

    /**
     * @return null
     */
    public function getVisibility() {
        return $this->visibility;
    }

    /**
     * @param $visibility
     */
    public function setVisibility($visibility) {
        $visibility = \Cms\Common::normalize($visibility, 'trim, int, xss');
        if($visibility > 1 || $visibility < 0) {
            $this->setErrors('sectionVisibility', 'Visibility must be 0 or 1');
            exit;
        } else {
            $this->visibility = $visibility;
        }

    }

    //************SECTION API************//

    /**
     * @param LanguageModel $language
     * @return mixed
     */
    public static function getAllSection(\Cms\Models\LanguageModel $language, $filter = null) {
        return \Cms\Repositories\SectionRepository::getInstance()->getAllSections($language, $filter);
    }

    /**
     * @return mixed
     */
    public function createSection() {
        return \Cms\Repositories\SectionRepository::getInstance()->createSection($this);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getSectionById($id) {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        return \Cms\Repositories\SectionRepository::getInstance()->getSectionById($id);
    }

    /**
     * @param $oldCategory
     * @return mixed
     */
    public function updateSection($oldCategory) {
        return \Cms\Repositories\SectionRepository::getInstance()->updateSection($this, $oldCategory);
    }

    /**
     * @return mixed
     */
    public function deleteSection() {
        return \Cms\Repositories\SectionRepository::getInstance()->deleteSection($this);
    }

    /**
     * @return void
     */
    public function changeSectionVisibility() {
        \Cms\Repositories\SectionRepository::getInstance()->updateSectionVisibility($this);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getSectionByKeyAndLanguage($key) {
        return \Cms\Repositories\SectionRepository::getInstance()->getSectionByKeyAndLanguage($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getSectionsByKey($key) {
        return \Cms\Repositories\SectionRepository::getInstance()->getSectionsByKey($key);
    }

    /**
     * @return mixed
     */
    public function getExternalSectionFields() {
        return \Cms\Repositories\ExternalSectionFieldRepository::getInstance()->getExtSecFields($this);
    }

    /**
     * @param ExternalSectionFieldModel $field
     * @return mixed
     */
    public function addExternalField(\Cms\Models\ExternalSectionFieldModel $field) {
        return \Cms\Repositories\ExternalSectionFieldRepository::getInstance()->createExtSecField($this, $field);
    }

    /**
     * @return mixed
     */
    public function getSectionResources() {
        return \Cms\Repositories\SectionRepository::getInstance()->getSectionResources($this);
    }
}