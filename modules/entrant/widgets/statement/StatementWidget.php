<?php
namespace modules\entrant\widgets\statement;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\models\Statement;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementWidget extends Widget
{
    public $facultyId, $specialityId, $specialRight, $eduLevel, $userId, $formCategory;
    public $finance =  0;
    private $service;

    public function __construct(StatementService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function init()
    {
        try {
            if(($se = $this->isOpenZuk()) && $se->open()) {
            $this->service->create($this->facultyId,
                $this->specialityId,
                $this->specialRight,
                $this->eduLevel,
                $this->userId,
                $this->formCategory,
                $this->finance);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function run()
    {
        if(!$settingEntrant = $this->isOpenZuk()) {
            return "Данные хреновые";
        }
        if(!$settingEntrant->open()) {
            return $settingEntrant->note;
        }
        $model = Statement::find()->defaultWhereNoStatus(
            $this->facultyId,
            $this->specialityId,
            $this->specialRight,
            $this->eduLevel,
            $this->formCategory,
            $this->finance)
            ->user($this->userId)
            ->all();
        return $this->render('index', [
            'statements'=> $model,
        ]);
    }

    private function isOpenZuk() {
        return SettingEntrant::find()
            ->type(SettingEntrant::ZUK)
            ->eduFinance($this->finance)
            ->specialRight($this->specialRight)
            ->eduLevel($this->eduLevel)
            ->faculty(DictFacultyHelper::getKeyFacultySetting($this->facultyId))
            ->eduForm(DictCompetitiveGroupHelper::categoryForm()[$this->formCategory])->one();
    }
}
