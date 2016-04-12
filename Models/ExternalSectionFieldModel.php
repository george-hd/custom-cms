<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 25.3.2016 г.
 * Time: 11:26
 */

namespace Cms\Models;


class ExternalSectionFieldModel extends BaseModel implements \JsonSerializable
{
    private $id = null;
    private $label = null;
    private $type = null;
    private $sectionId = null;

    public function __construct($id, $label, $type, $sectionId)
    {
        if($id)$this->setId($id);
        $this->setLabel($label);
        $this->setType($type);
        $this->setSectionId($sectionId);
    }

    public function jsonSerialize()
    {
        return [
            'label' => $this->getLabel(),
            'type' => $this->getType()
        ];
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $label = \Cms\Common::normalize($label, 'trim, string, xss');
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @throws \Exception
     */
    public function setType($type)
    {
        $type = \Cms\Common::normalize($type, 'trim, string, xss');
        if(in_array($type, ['file', 'input', 'textarea', 'checkbox', 'color', 'radio', 'date'])) {
            $this->type = $type;
        } else {
            throw new \Exception('Invalid external field type', 400);
        }
    }

    /**
     * @return mixed
     */
    public function getSectionId() {
        return $this->sectionId;
    }

    /**
     * @param $sectionId
     */
    public function setSectionId($sectionId) {
        $sectionId = \Cms\Common::normalize($sectionId,'trim, int, xss');
        $this->sectionId = $sectionId;
    }

}