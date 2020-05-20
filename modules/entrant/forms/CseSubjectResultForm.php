<?php


namespace modules\entrant\forms;


use common\auth\forms\CompositeForm;
use modules\entrant\models\CseSubjectResult;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CseSubjectResultForm extends Model
{
    public $user_id, $year, $resultData;

    private $_cseSubjectResult;

    public function __construct($user_id, CseSubjectResult $cseSubjectResult = null, $config = [])
    {
        if ($cseSubjectResult) {
            $this->setAttributes($cseSubjectResult->getAttributes(), false);
            foreach ($cseSubjectResult->dateJsonDecode() as $key => $value) {
                $this->resultData [] = new CseSubjectMarkForm(['subject_id' => $key, 'mark' => $value]);
            }
            $this->_cseSubjectResult = $cseSubjectResult;
        } else {
            $this->user_id = $user_id;
            $this->resultData = [new CseSubjectMarkForm()];
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer', 'min' => date("Y") - 4, 'max' => date("Y")],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $message = "Нельзя добавлять несколько записей одного и того же года";
        if ($this->_cseSubjectResult) {
            return [
                [['year'], 'unique', 'targetClass' => CseSubjectResult::class,
                    'filter' => ['<>', 'id', $this->_cseSubjectResult->id],
                    'targetAttribute' => ['user_id', 'year'], 'message' => $message],
            ];
        }
        return [[['year',], 'unique', 'targetClass' => CseSubjectResult::class,
            'targetAttribute' => ['user_id', 'year'], 'message' => $message]];
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
        return (new CseSubjectResult())->attributeLabels();
    }

    public function isArrayMoreResult()
    {
        try {
            $postData = \Yii::$app->request->post((new CseSubjectMarkForm)->formName());
            if ($postData) {
                $this->resultData = [];
                foreach ($postData as $value) {
                    $this->resultData [] = new CseSubjectMarkForm($value);
                }
            }
        } catch (InvalidConfigException $e) {
        }
        return $this->resultData;
    }
}