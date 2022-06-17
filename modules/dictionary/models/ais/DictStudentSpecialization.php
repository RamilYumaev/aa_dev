<?php

namespace modules\dictionary\models\ais;

use Yii;

/**
 * This is the model class for table "dict_student_specialization".
 *
 * @property int $id ID
 * @property string $name Название
 * @property string $code_incoming_cg Код, конкурсная группа
 * @property string $code_incoming_application Код, заявление
 * @property string $code_group Код, группа
 * @property int|null $diploma_qualification_id Квалификация для диплома
 * @property string $site_name Название образовательной программы на сайте
 * @property string $argument Аргументация добавления
 * @property int $priority_status Направление приказа 654
 */
class DictStudentSpecialization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_student_specialization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['diploma_qualification_id', 'priority_status'], 'integer'],
            [['name', 'code_incoming_cg', 'code_incoming_application', 'code_group', 'site_name', 'argument'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code_incoming_cg' => 'Code Incoming Cg',
            'code_incoming_application' => 'Code Incoming Application',
            'code_group' => 'Code Group',
            'diploma_qualification_id' => 'Diploma Qualification ID',
            'site_name' => 'Site Name',
            'argument' => 'Argument',
            'priority_status' => 'Priority Status',
        ];
    }
}
