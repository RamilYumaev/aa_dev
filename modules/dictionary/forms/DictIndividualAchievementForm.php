<?php
namespace modules\dictionary\forms;

use modules\dictionary\helpers\DictIndividualAchievementCgHelper;
use modules\dictionary\helpers\DictIndividualAchievementDocumentHelper;
use modules\dictionary\models\DictIndividualAchievement;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictIndividualAchievementForm extends Model
{
    public $name, $year, $mark, $category_id, $name_short, $competitiveGroupsList, $documentTypesList;

    private $_dictIndividualAchievement;

    /**
     * DictCategoryForm constructor.
     * @param DictIndividualAchievement $dictIndividualAchievement
     * @param array $config
     */

    public function __construct(DictIndividualAchievement $dictIndividualAchievement= null, $config = [])
    {
        if ($dictIndividualAchievement) {
            $this->setAttributes($dictIndividualAchievement->getAttributes(), false);
            $this->documentTypesList = DictIndividualAchievementDocumentHelper::listDocument($dictIndividualAchievement->id);
            $this->competitiveGroupsList = DictIndividualAchievementCgHelper::listCg($dictIndividualAchievement->id);
            $this->_dictIndividualAchievement = $dictIndividualAchievement;
        } else {
            $this->competitiveGroupsList = [];
        }

        parent::__construct($config);
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name',], 'unique', 'targetClass' => DictIndividualAchievement::class,
            'targetAttribute' => ['name', 'year',]];
        if ($this->_dictIndividualAchievement) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_dictIndividualAchievement->id]]);
        }
        return $arrayUnique;
    }

    public function defaultRules()
    {
        return [
           // [['year', 'name', 'name_short', 'category_id','mark', 'competitiveGroupsList','documentTypesList'], 'required'],
            [['year', 'name', 'name_short', 'category_id','mark'], 'required'],
            [['category_id','mark'], 'integer'],
            [['competitiveGroupsList','documentTypesList'], 'safe'],
            [['year', 'name', 'name_short'], 'string', 'max' => 255],
        ];
    }

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictIndividualAchievement())->attributeLabels();
    }

}