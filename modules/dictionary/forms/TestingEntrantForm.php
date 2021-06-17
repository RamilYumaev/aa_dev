<?php
namespace modules\dictionary\forms;

use modules\dictionary\helpers\DictIndividualAchievementCgHelper;
use modules\dictionary\helpers\DictIndividualAchievementDocumentHelper;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\models\DictTestingEntrant;
use modules\dictionary\models\TestingEntrant;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TestingEntrantForm extends Model
{
    public $department;
    public $special_right;
    public $edu_level;
    public $edu_document;
    public $country;
    public $category;
    public $fio;
    public $note;
    public $title;
    public $user_id;
    public $dictTestingList;

    /**
     * DictCategoryForm constructor.
     * @param TestingEntrant|null $testingEntrant
     * @param array $config
     */

    public function __construct(TestingEntrant $testingEntrant = null, $config = [])
    {
        if ($testingEntrant) {
            $this->setAttributes($testingEntrant->getAttributes(), false);
            $this->dictTestingList = $testingEntrant->getTestingEntrantDict()->select('id_dict_testing_entrant')->column();
            $this->department = json_decode($testingEntrant->department);
            $this->special_right = json_decode($testingEntrant->special_right);
            $this->edu_level = json_decode($testingEntrant->edu_level);
        }else {
            $this->dictTestingList = DictTestingEntrant::find()->select('id')->where(['is_auto'=> true])->column();
        }
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['title', 'edu_level', 'department','fio', 'dictTestingList','user_id'], 'required'],
            [[ 'special_right', 'edu_level', 'department', 'dictTestingList'], 'safe'],
            [['category','edu_document', 'country', 'user_id'], 'integer'],
            [['note'], 'string']
        ];
    }


    public function attributeLabels()
    {
        return (new TestingEntrant())->attributeLabels()+['dictTestingList'=>'Задачи'];
    }

}