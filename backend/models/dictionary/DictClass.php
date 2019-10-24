<?php
namespace backend\models\dictionary;

use backend\forms\dictionary\DictClassForm;
use backend\helpers\dictionary\DictClassHelper;

class DictClass  extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCHOOL = 1;
    const COLLEDGE = 2;
    const BACALAVR = 3;
    const MAGISTR =4;

    public static function tableName()
    {
        return 'dict_class';
    }

    public static function create (DictClassForm $form):self
    {
        $class = new static();
        $class->name = $form->name;
        $class->type = $form->type;
        return $class;
    }


    public  function edit (DictClassForm $form): void
    {
        $this->name = $form->name;
        $this->type = $form->type;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels():array
    {
        return [
            'name' => 'Номер',
            'type' => 'Тип',
        ];
    }

    public static function labels(): array
    {
        $class =  new static();
        return $class->attributeLabels();
    }

    public function getClassFullName(): string
    {
        $type = DictClassHelper::typeOfClass();
        return $this->name . '-й ' . $type[$this->type];
    }
}