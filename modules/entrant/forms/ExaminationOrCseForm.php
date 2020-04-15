<?php
namespace modules\entrant\forms;

use modules\entrant\models\CseViSelect;
use yii\base\InvalidConfigException;
use yii\base\Model;

class ExaminationOrCseForm extends Model
{
    public  $arrayMark;
    public  $id;
    private $examinations;
    private $cseResult;


    public function __construct($examinations, CseViSelect $cseViSelect = null, $config = [])
    {
        $this->id = 'dkjskjfkjvjdkthb';
        $this->examinations = $examinations;
        $this->cseResult = $cseViSelect;
        array_walk($examinations, function(&$a, $b) use($cseViSelect) {
            $a = new TypeExaminationsForm($a, $b, $cseViSelect); });
        $this->arrayMark = $examinations;

        parent::__construct($config);
    }

    public function rules()
    {
       return[['id','string']];
    }

    public function isArrayMoreResult()
    {
        try {
            $postData = \Yii::$app->request->post((new TypeExaminationsForm())->formName());
            if ($postData) {
                $this->arrayMark = [];
                foreach ($postData as $key => $value) {
                    $this->arrayMark[$key] = new TypeExaminationsForm($this->examinations[$key], $key, $this->cseResult, $value);
                }
            }
        } catch (InvalidConfigException $e) {
        }
        return $this->arrayMark;
    }

}