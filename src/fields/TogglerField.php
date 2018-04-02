<?php
/**
 * Toggler plugin for Craft CMS 3.x
 *
 * A super simple field type which allows you toggle existing field types.
 *
 * @link      https://fruitstudios.co.uk
 * @copyright Copyright (c) 2018 Fruit Studios
 */

namespace fruitstudios\toggler\fields;

use fruitstudios\toggler\Toggler;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Fruit Studios
 * @package   Toggler
 * @since     1.0.0
 */
class TogglerField extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $type;
    public $field;
    public $label;
    public $toggle = false;
    public $position = 'above';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('toggler', 'Toggler');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['type', 'required'];
        $rules[] = ['toggle', 'boolean'];
        $rules[] = ['position', 'required', 'message' => 'above'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'toggler/_settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'toggler/_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
            ]
        );
    }

    public function getPositions()
    {
        return [
            [
                'label' => Craft::t('toggler', 'Above'),
                'value' => 'above',
            ],
            [
                'label' => Craft::t('toggler', 'Before'),
                'value' => 'before',
            ],
            [
                'label' => Craft::t('toggler', 'After'),
                'value' => 'after',
            ]
        ];
    }

    public function getFields()
    {

        return [
            [
                'label' => Craft::t('toggler', 'Field Name'),
                'value' => 'fieldclass',
            ],
            [
                'label' => Craft::t('toggler', 'Another Field Name'),
                'value' => 'anothefieldclass',
            ]
        ];

        // if ($field === null) {
        //     $field = $fieldsService->createField(PlainText::class);
        // }

        // // Supported translation methods
        // // ---------------------------------------------------------------------

        // $supportedTranslationMethods = [];
        // /** @var string[]|FieldInterface[] $allFieldTypes */
        // $allFieldTypes = $fieldsService->getAllFieldTypes();

        // foreach ($allFieldTypes as $class) {
        //     if ($class === get_class($field) || $class::isSelectable()) {
        //         $supportedTranslationMethods[$class] = $class::supportedTranslationMethods();
        //     }
        // }

        // // Allowed field types
        // // ---------------------------------------------------------------------

        // if (!$field->id) {
        //     $compatibleFieldTypes = $allFieldTypes;
        // } else {
        //     $compatibleFieldTypes = $fieldsService->getCompatibleFieldTypes($field, true);
        // }

        // /** @var string[]|FieldInterface[] $compatibleFieldTypes */
        // $fieldTypeOptions = [];

        // foreach ($allFieldTypes as $class) {
        //     if ($class === get_class($field) || $class::isSelectable()) {
        //         $compatible = in_array($class, $compatibleFieldTypes, true);
        //         $fieldTypeOptions[] = [
        //             'value' => $class,
        //             'label' => $class::displayName().($compatible ? '' : ' ⚠️'),
        //         ];
        //     }
        // }

        // // Sort them by name
        // ArrayHelper::multisort($fieldTypeOptions, 'label');
    }
}
