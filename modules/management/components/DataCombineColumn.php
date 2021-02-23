<?php

namespace modules\management\components;


use yii\helpers\Html;
use yii\grid\DataColumn;

/**
 * Class DataCombineColumn
 * @package flyiing\uni\grid
 *
 * Renders several attributes combined in one grid column
 */

class DataCombineColumn extends DataColumn
{

    /**
     * @var array
     * List of attributes to combine
     * Simple format: [ 'attr1_name', 'attr2_name', ... ]
     * Extended format:
     * [
     *     'attr1_name' => [ // attribute name as item key
     *          'label' => 'attr1_label',
     *          'format' => 'attr1_format',
     *          ... // any property of the base DataColumn class possible here...
     *     ],
     *     [
     *          'attribute' => 'attr2_name', // attribute name as item property
     *          ...
     *     ],
     * ]
     */
    public $attributes = null;

    /**
     * @var string
     * Template for data cell in format: '...{attr1_name}...{attr2_name}...{attrN_name}...'
     */
    public $template = null;
    /**
     * @var string
     * Template for header cell in same format ^^^
     * If null, $template will be used
     */
    public $headerTemplate = null;

    /**
     * @var array
     * backup variable to store base/default properties
     */
    private $_staticData = null;

    public function init()
    {
        parent::init();

        // setting up default templates if empty
        if($this->template === null) {
            $this->template = '';
            foreach($this->attributes as $key => $value) {
                if(is_array($value)) {
                    if(is_string($key))
                        $attr = $key;
                    if(isset($value['attribute']))
                        $attr = $value['attribute'];
                } elseif(is_string($value))
                    $attr = $value;
                $this->template .= '{' . $attr . '}<br />';
            }
        }
        if($this->headerTemplate === null)
            $this->headerTemplate = $this->template;

        $this->_staticData = \yii\helpers\ArrayHelper::toArray($this, [], false);
    }

    public function renderHeaderCell()
    {
        if($this->attributes === null)
            return parent::renderHeaderCell();

        $items = [];
        foreach($this->attributes as $key => $value) {

            if(is_array($value)) {
                if(is_string($key))
                    $this->attribute = $key;
                \Yii::configure($this, $value);
            } elseif(is_string($value))
                $this->attribute = $value;

            $items['{' . $this->attribute . '}'] = $this->renderHeaderCellContent();
            \Yii::configure($this, $this->_staticData);

        }

        return Html::tag('th', strtr($this->headerTemplate, $items), $this->headerOptions);
    }

    public function renderDataCell($model, $key, $index)
    {
        if($this->attributes === null)
            return parent::renderDataCell($model, $key, $index);

        // copy-past from yii2\grid\Column
        if ($this->contentOptions instanceof Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        $items = [];
        foreach($this->attributes as $key => $value) {

            if(is_array($value)) {
                if(is_string($key))
                    $this->attribute = $key;
                \Yii::configure($this, $value);
            } elseif(is_string($value))
                $this->attribute = $value;

            $items['{' . $this->attribute . '}'] = $this->renderDataCellContent($model, $key, $index);
            \Yii::configure($this, $this->_staticData);

        }

        return Html::tag('td', strtr($this->template, $items), $options);
    }

}