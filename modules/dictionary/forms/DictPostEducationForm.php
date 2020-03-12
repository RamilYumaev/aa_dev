<?php
namespace modules\dictionary\forms;
use modules\dictionary\models\DictPostEducation;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictPostEducationForm extends Model
{
    public $name;

    private $_dictPostEducation;

    public function __construct(DictPostEducation $dictPostEducation = null, $config = [])
    {
        if($dictPostEducation){
            $this->setAttributes($dictPostEducation->getAttributes(), false);
            $this->_dictPostEducation = $dictPostEducation;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */


    public function uniqueRules()
    {
        if ($this->_dictPostEducation) {
            return [
                [['name'], 'unique', 'targetClass' => DictPostEducation::class,
                    'filter' => ['<>', 'id', $this->_dictPostEducation->id]],
            ];
        }
        return [[['name'], 'unique', 'targetClass' => DictPostEducation::class,]];
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), $this->uniqueRules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new DictPostEducation())->attributeLabels();
    }




}