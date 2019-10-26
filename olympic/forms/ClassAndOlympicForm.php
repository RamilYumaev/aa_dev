<?php


namespace olympic\forms;


use dictionary\models\DictClass;
use olympic\models\ClassAndOlympic;
use olympic\models\Olympic;
use yii\base\Model;

class ClassAndOlympicForm extends Model
{
    public $class_id, $olympic_id;

    public function __construct(ClassAndOlympic $classAndOlympic = null, $config = [])
    {
        if ($classAndOlympic) {
            $this->class_id = $classAndOlympic->class_id;
            $this->olympic_id = $classAndOlympic->olympic_id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'olympic_id'], 'required'],
            [['class_id', 'olympic_id'], 'integer'],
            [['class_id', 'olympic_id'], 'unique', 'targetClass'=>ClassAndOlympic::class, 'targetAttribute' => ['class_id', 'olympic_id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictClass::class, 'targetAttribute' => ['class_id' => 'id']],
            [['olympic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Olympic::class, 'targetAttribute' => ['olympic_id' => 'id']],
        ];
    }

}