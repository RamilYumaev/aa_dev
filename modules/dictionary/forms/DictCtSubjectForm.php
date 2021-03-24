<?php
namespace modules\dictionary\forms;

use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\DictCtSubject;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictCtSubjectForm extends DictCseSubjectForm
{
    public $name, $min_mark, $composite_discipline_status, $cse_status, $ais_id;

    public function __construct(DictCtSubject $dictCseSubject = null, $config = [])
    {
        parent::__construct($dictCseSubject, DictCtSubject::class, $config);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new DictCtSubject())->attributeLabels();
    }
}