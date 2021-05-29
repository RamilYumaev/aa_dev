<?php
namespace modules\dictionary\forms;

use modules\dictionary\helpers\DictIndividualAchievementCgHelper;
use modules\dictionary\helpers\DictIndividualAchievementDocumentHelper;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\models\DictTestingEntrant;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictTestingEntrantForm extends Model
{
    public $name;
    public $description;
    public $result;
    public $priority;
    public $is_auto;
    private  $_dictTestingEntrant;

    /**
     * DictCategoryForm constructor.
     * @param DictTestingEntrant|null $dictTestingEntrant
     * @param array $config
     */

    public function __construct(DictTestingEntrant $dictTestingEntrant = null, $config = [])
    {
        if ($dictTestingEntrant) {
            $this->setAttributes($dictTestingEntrant->getAttributes(), false);
            $this->_dictTestingEntrant = $dictTestingEntrant;
        }
        parent::__construct($config);
    }


    public function defaultRules()
    {
        return [
            [['name','description', 'result', 'priority'], 'required'],
            [['description', 'result'], 'string'],
            [['priority'], 'integer'],
            [['is_auto'], 'boolean'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => DictTestingEntrant::class];
        if ($this->_dictTestingEntrant) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_dictTestingEntrant->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictTestingEntrant())->attributeLabels();
    }

}