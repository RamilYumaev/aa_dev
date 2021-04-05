<?php
namespace modules\dictionary\forms;
use modules\dictionary\models\SettingEntrant;
use yii\base\Model;

class SettingEntrantForm extends Model
{
    public $faculty_id, $is_vi, $note, $type, $form_edu, $special_right, $finance_edu, $datetime_start, $datetime_end,
        $edu_level, $tpgu_status, $foreign_status, $cse_as_vi;

    public function __construct(SettingEntrant $settingEntrant = null, $config = [])
    {
        if($settingEntrant){
            $this->setAttributes($settingEntrant->getAttributes(), false);
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_edu','faculty_id', 'type', 'edu_level', 'note','finance_edu'], 'required'],
            [['faculty_id', 'form_edu', 'special_right', 'edu_level', 'type', 'finance_edu'], 'integer'],
            [['note'], 'string' ],
            [['datetime_start', 'datetime_end'], 'date', 'format' => 'yyyy-M-d H:m:s'],
            [['is_vi', 'tpgu_status', 'foreign_status', 'cse_as_vi'],'boolean'],
        ];
    }

    public function attributeLabels() {
        return (new SettingEntrant())->attributeLabels();
    }
}