<?php

namespace modules\dictionary\forms;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use yii\base\Model;

class JobEntrantForm extends Model
{
    public $faculty_id, $category_id, $user_id, $email_id, $examiner_id, $right_full;
    private $_jobEntrant;

    public function __construct(JobEntrant $entrant = null, $config = [])
    {
        if($entrant){
            $this->setAttributes($entrant->getAttributes(), false);
            $this->_jobEntrant= $entrant;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'faculty_id', 'email_id', 'examiner_id', 'user_id', 'right_full'], 'integer'],
            ['faculty_id', 'required', 'when' => function ($model) {
                return $model->category_id == JobEntrantHelper::FOK;
            }, 'whenClient' => 'function (attribute, value) { return $("#jobentrantform-category_id").val() == 3}'],
            ['examiner_id', 'required', 'when' => function ($model) {
                return $model->category_id == JobEntrantHelper::EXAM;
            }, 'whenClient' => 'function (attribute, value) { return $("#jobentrantform-category_id").val() == 9}'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new JobEntrant())->attributeLabels();
    }

}