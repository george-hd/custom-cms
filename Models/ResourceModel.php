<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 25.3.2016 г.
 * Time: 9:30
 */

namespace Cms\Models;


class ResourceModel extends BaseModel
{
    private $id = null;

    private $key;

    private $value;

    private $sectionId;

    public function __construct($id , $key, $value, $sectionId)
    {
        if($id)$this->setId($id);
        $this->setKey($key);
        $this->setValue($value);
        $this->setSectionId($sectionId);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        $this->id = $id;
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
     */
    public function setKey($key)
    {
        $key = \Cms\Common::normalize($key, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $key, '', 'Resource key is required,')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('resources', $validator->getErrors());
            exit;
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
     * @param $value
     */
    public function setValue($value)
    {
        $value = \Cms\Common::normalize($value, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $value, '', 'Resource value is required,')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('resources', $validator->getErrors());
            exit;
        }
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * @param $sectionId
     */
    public function setSectionId($sectionId)
    {
        $sectionId = \Cms\Common::normalize($sectionId, 'trim, int, xss');
        $this->sectionId = $sectionId;
    }

    //******************RESOURCE API******************//

    /**
     * @param SectionModel $section
     * @return mixed
     */
    public static function getResourcesBySection(\Cms\Models\SectionModel $section) {
        return \Cms\Repositories\ResourceRepository::getInstance()->getResourcesBySection($section);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getResourceById($id) {
        return \Cms\Repositories\ResourceRepository::getInstance()->getResourceById($id);
    }

    /**
     * @return mixed
     */
    public function getResourceByKey() {
        return \Cms\Repositories\ResourceRepository::getInstance()->getResourceByKey($this);
    }

    /**
     * @return mixed
     */
    public function addResource() {
        return \Cms\Repositories\ResourceRepository::getInstance()->addResource($this);
    }

    public function updateResource() {
        return \Cms\Repositories\ResourceRepository::getInstance()->updateResource($this);
    }

}