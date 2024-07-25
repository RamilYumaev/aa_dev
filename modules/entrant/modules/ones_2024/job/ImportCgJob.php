<?php
namespace modules\entrant\modules\ones_2024\job;

use dictionary\helpers\DictFacultyHelper;
use dictionary\models\Faculty;
use modules\entrant\modules\ones_2024\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones_2024\model\CgSS;
use modules\entrant\modules\ones_2024\model\FileSS;
use yii\base\BaseObject;
use yii\queue\Queue;

class ImportCgJob extends BaseObject implements \yii\queue\JobInterface
{
    /*  @var FileSS */
    public $model;

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function execute($queue)
    {
        \ini_set('memory_limit', '8000M');
        \proc_nice(10);
        \setlocale(LC_COLLATE, 'ru_RU.UTF-8');
        set_time_limit(6000);
        $filePath = $this->model->getUploadedFilePath('file_name');
        if(file_exists($filePath)) {
            $xlsx = SimpleXLSX::parse($filePath);
            if ($xlsx->success()) {
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }
                    if (!CgSS::findOne(['quid' => $r[2]])) {
                        $model = new CgSS();
                        $model->quid = $r[2];
                        $model->faculty_id = key_exists($r[3], $this->converterFilial()) ? $this->converterFilial()[$r[3]] : null;
                        $model->profile = $r[11];
                        $model->name = $r[3]." ".$r[5]." ".$r[19]." ".$r[20]." ".$r[21];
                        $model->code_spec = $r[6];
                        $model->speciality = $r[7];
                        $model->type = $r[21];
                        $model->education_level = $r[19];
                        $model->education_form = $r[20];
                        $model->kcp = intval($r[22]);
                        if (!$model->save()) {
                            var_dump($model->errors);
                        };
                    }
                }
            } else {
                echo 'xlsx error: ' . $xlsx->error();
            }
        }
    }

    public function converterFilial() {
        return [
            "Покровский филиал МПГУ" => DictFacultyHelper::POKROV_BRANCH,
            "Дербентский филиал МПГУ" => DictFacultyHelper::DERBENT_BRANCH,
            "Ставропольский филиал МПГУ" => DictFacultyHelper::STAVROPOL_BRANCH,
            "Анапский филиал МПГУ" => DictFacultyHelper::ANAPA_BRANCH,
            "филиал МПГУ в г. Черняховске" => DictFacultyHelper::CHERNOHOVSK_BRANCH
        ];
    }

    public function getFacultyId($name) {
        $model  = Faculty::find()->andWhere(['full_name' => $name])->one();
        return $model ? $model->id : null;
    }

}