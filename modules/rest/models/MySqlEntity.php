<?php

namespace application\modules\rest\models;

use yii;
use application\modules\core;
use application\modules\rest\models\Entity;

/**
 * Base Class for MySql Entities
 *
 * @package application\modules\rest\models
 * @property boolean $synchronize
 * @property string  $dataField
 * @property boolean $trackTime
 * @property boolean $trackUser
 * @property int     $createdAt
 */
class MySqlEntity extends Entity\DBEntity implements EntityInterface
{
    /**
     * Flag indicating whether if entity should be synchronized
     *
     * @var bool
     */
    public $synchronize = false;
    /**
     * Data Field to retrieve/set values from/to
     * if there is no such attribute
     *
     * @var string|null
     */
    public $dataField = null;
    /**
     * Indicates whether if attributes createdAt (for new) and updatedAt(for existing)
     * are automatically updated with current timestamp
     *
     * @var bool
     */
    public bool $trackTime = false;

    /**
     * @var int
     */
    private int $createdAt = 0;

    /**
     * Updates fields createdAt and updatedAt if necessary
     */
    public function trackTime()
    {
        // Track time if ONLY allowed
        if (!$this->trackTime) {
            return;
        }
        // Track creation time if any
        if ($this->hasAttribute('createdAt')) {
            if ($this->isNewRecord) {
                // Fore new record it's always NOW
                $createdAt = new yii\db\Expression('NOW()');
                $this->createdAt = time();
            } else {
                // Update with prev value just in case it's changed
                $createdAt = $this->getOldAttribute('createdAt');
                $this->createdAt = strtotime($createdAt);
            }
            $this->setAttribute('createdAt', $createdAt);
        }
        // Track updated time if any
        if ($this->hasAttribute('updatedAt')) {
            $this->setAttribute('updatedAt', new yii\db\Expression('NOW()'));
        }
    }

    /**
     * @inheritdoc
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->trackTime();
        $prev = $this->isNewRecord ? null : $this->oldAttributes;
        $done = parent::save($runValidation, $attributeNames);
        if (!$done) {
            throw new Action\Error\BadRequest(
                Defines\Api\Error::ENTITY_NOT_SAVED,
                Entity\Helper::errorsToString($this->getErrors())
            );
        }

        return $done;
    }

    /**
     * @inheritdoc
     */
    public function jsonFields()
    {
        return [];
    }

    /**
     * Returns whether entity has been changed after load or is new to be stored
     *
     * @return bool
     */
    public function changed()
    {
        return !empty($this->dirtyAttributes);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if (!$this->hasAttribute($name) && $this->hasAttribute($this->dataField)) {
            $temp = parent::__get($this->dataField);
            $temp = core\models\ArrayHelper::getValue($temp, $name);
        } else {
            $temp = parent::__get($name);
            if (in_array($name, $this->jsonFields())) {
                $data = json_decode($temp ?? '', true);
                if (is_array($data)) {
                    return $data;
                }
            }
        }

        return $temp;
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        // If not attribute - set into dataField if any
        if (!$this->hasAttribute($name) && $this->hasAttribute($this->dataField)) {
            $temp = parent::__get($this->dataField);
            if (!is_array($temp)) {
                $temp = [];
            }
            $temp[$name] = $value;
            $name = $this->dataField;
            $value = $temp;
        } else {
            // Check for JSON field and encode value if so
            if (in_array($name, $this->jsonFields())) {
                $value = json_encode($value);
            }
        }
        parent::__set($name, $value);
    }

    /**
     * Return default attributes
     */
    public function allowedParamsToUpdate()
    {
        return array_keys($this->attributes);
    }

    /**
     * Get entity createdAt time
     *
     * @return int|string
     */
    public function getCreatedAt()
    {
        if (!$this->trackTime) {
            return null;
        }

        return $this->createdAt ?: $this->getAttribute('createdAt');
    }
}
