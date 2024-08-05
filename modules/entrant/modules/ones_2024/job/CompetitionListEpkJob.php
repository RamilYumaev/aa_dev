<?php

namespace modules\entrant\modules\ones_2024\job;
use modules\entrant\modules\ones_2024\model\CgSS;
use modules\entrant\modules\ones_2024\model\EntrantCgAppSS;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class CompetitionListEpkJob extends BaseObject implements \yii\queue\JobInterface
{

    /** @var CgSS */

    public $model;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\Exception
     */

    public function execute($queue)
    {
        $this->generate();
    }

    public function generate()
    {
        if($this->model->url) {
            $json = file_get_contents($this->model->url);
            if ($json) {
                $response = Json::decode($json);
                if ($response['success']) {
                    $this->saveCompetitionList($response);
                    $this->model->datetime_url = date("Y-m-d H:i:s");
                    $this->model->save();
                }
            }
        }
    }

    public function saveCompetitionList($response)
    {
        if (key_exists('data', $response)) {
            $data = $response['data'];
            if (key_exists('list_applicants', $data)) {
                $list = $data['list_applicants'];
                if(count($list)) {
                    $this->parsing($list);
                } else {
                    $this->parsing([]);
                }
            }
        }
    }

    public function parsing($list) {
        $data = [];
        $snils = [];
        foreach ($list as $key => $item) {
            $data[$key]['number'] = $item["Номер"];
            $data[$key]['fio'] = $item['ФизическоеЛицо'];

            $data[$key]['snils_number'] = $item["УникальныйКод"];
            /**  @var EntrantCgAppSS $entrantApp
             */
            $snils[$key] = $data[$key]['snils_number'];
            $entrantApp = $this->getEntrantApp($data[$key]['snils_number'],  $data[$key]['fio']);
            /**  @var EntrantSS $entrant
             */
            if($entrantApp) {
                $entrant = $entrantApp->entrant;
                $snils[$key] = $entrant->snils;
            }else {
                $entrant = $this->getEntrant($data[$key]['snils_number']);
            }
            $data[$key]['phone'] = $entrant ? $entrant->phone : "";
            $data[$key]['exam_1'] = $item["Предмет1"];
            $data[$key]['exam_2'] = $item["Предмет2"];
            $data[$key]['exam_3'] = $item["Предмет3"];
            $data[$key]['sum_exams'] = $item["СуммаБалловПоПредметам"];
            $data[$key]['sum_individual'] = $item["СуммаБалловПоИДДляКонкурса"];
            $data[$key]['sum_ball'] = $item["СуммаБаллов"];
            $data[$key]['name_exams'] = $item["НаборВступительныхИспытанийФакт"];
            $data[$key]['priority'] = $item["Приоритет"];
            $data[$key]['status_ss'] = $entrantApp ? $entrantApp->status : "";
            $data[$key]['priority_ss'] = $entrantApp ? $entrantApp->priority_ss : "";
            $data[$key]['is_paper_original_ss'] = $entrantApp ? $entrantApp->is_paper_original: "";
            $data[$key]['is_el_original_ss'] = $entrantApp ? $entrantApp->is_el_original: "";
            $data[$key]['vuz_original'] = $entrantApp ? $entrantApp->vuz_original: "";
            $data[$key]['is_ss'] = $entrantApp ? "Да" : "Нет";
            $data[$key]['is_epk'] =  "Да";
            $data[$key]['is_original'] = $entrant ? ($entrant->is_original ? "Да" : "Нет")  : "";
            $data[$key]['is_hostel'] = $entrant ? $entrant->is_hostel : "";
            $data[$key]['quid_profile'] = $entrant ? $entrant->quid: "";
            $data[$key]['original'] = $item["Оригинал"];
            $data[$key]['right'] = $item["ПреимущественноеПраво"];
            $data[$key]['is_pay'] = $item["Оплачено"];
            $data[$key]['is_first_status'] = 0;
            $data[$key]['document'] = $item["ВидДокумента"];
            $data[$key]['document_target']  = key_exists('ПодтверждающийДокументЦелевогоНаправленияНомерДокумента', $item) ? $item['ПодтверждающийДокументЦелевогоНаправленияНомерДокумента'] : '';
            $data[$key]['organization'] = $item['НаправляющаяОрганизация'];
            $data[$key]['is_change'] = 0;
            $data[$key]['snils_ss'] = $entrant ? $entrant->snils: "";
            $data[$key]['is_el_original_epk'] = $entrant ? ($entrant->is_remote_original ? "Да" : "Нет")  : "";
        }

        $notEpkData = $this->getNotAppEpk($snils);

        if(count($notEpkData)) {
           $data =  array_merge($data, $notEpkData);
        }

        if(count($data)) {
            $this->createFile($data, $this->model->getFile());
            if (!file_exists($this->model->getPathFullEpk() . '/' . $this->model->getFileFok())) {
                $this->createFile($data, $this->model->getFileFok());
            } else {
                //     $this->change($data);
            }
        }
    }

    public function createFile($data, $fileName) {
        if(!FileHelper::createDirectory($this->model->getPathFullEpk())) {
            throw  new \DomainException("Не удалось создать папку ". $this->model->getPathFullEpk());
        }
        file_put_contents($this->model->getPathFullEpk() . '/' . $fileName, json_encode($data));
    }

    /**
     * @param $snils
     * @return array | null
     */
    
    public function getEntrantApp($snils, $fio) {
        $rule1 = ['quid_cg_competitive' => $this->model->quid, 'fio' => $fio];
        $rule = ['quid_cg_competitive' => $this->model->quid, 'snils' => $snils];
        
       return EntrantCgAppSS::find()->joinWith(['entrant'])
            ->andWhere($rule)->orWhere($rule1)->orderBy(['datetime' => SORT_DESC ])->one();
    }

    public function getEntrant($snils) {
        return EntrantSS::find()
            ->andWhere(['snils' => $snils])->one();
    }

    public function getNotAppEpk($snils) {
        /**  @var EntrantCgAppSS $val
         */
    $data = [];
    $snd=[];
        foreach (EntrantCgAppSS::find()->joinWith(['entrant'])
            ->andWhere(['quid_cg_competitive' => $this->model->quid])
            ->andWhere(['not in', 'snils', $snils])->orderBy(['datetime' => SORT_DESC ])->all() as $key => $val) {
            if(in_array($val->entrant->snils, $snd)) {
                continue;
            }
            $data[$key]['number'] = '';
            $data[$key]['fio'] = $val->entrant->fio;
            $data[$key]['snils_number'] = $val->entrant->snils;
            $data[$key]['phone'] = $val->entrant->phone;
            $data[$key]['exam_1'] = '';
            $data[$key]['exam_2'] = '';
            $data[$key]['exam_3'] = '';
            $data[$key]['sum_exams'] = '';
            $data[$key]['sum_individual'] = '';
            $data[$key]['sum_ball'] = '';
            $data[$key]['name_exams'] = '';
            $data[$key]['priority'] = '';
            $data[$key]['is_original'] = $val->entrant->is_original ? "Да" : "Нет";
            $data[$key]['status_ss'] = $val->status;
            $data[$key]['priority_ss'] = $val->priority_ss;
            $data[$key]['is_paper_original_ss']  = $val->is_paper_original;
            $data[$key]['is_el_original_ss'] = $val->is_el_original;
            $data[$key]['is_ss'] =  "Да";
            $data[$key]['is_epk'] =  "Нет";
            $data[$key]['is_hostel'] = $val->entrant->is_hostel;
            $data[$key]['quid_profile'] = $val->quid_profile;
            $data[$key]['vuz_original'] = $val->vuz_original;
            $data[$key]['original'] = '';
            $data[$key]['right'] = '';
            $data[$key]['is_pay'] = '';
            $data[$key]['is_first_status'] = 0;
            $data[$key]['document'] = '';
            $data[$key]['document_target']  = '';
            $data[$key]['organization'] = '';
            $data[$key]['is_change'] = 0;
            $data[$key]['snils_ss'] = $val->entrant->snils;
            $data[$key]['is_el_original_epk'] = $val->entrant->is_remote_original ? "Да" : "Нет";
            $snd[] = $val->entrant->snils;
        };

        return $data;
    }

    public function change($data) {
        $newData = $data;
        $json = file_get_contents($this->model->getPathFullEpk() . '/' . $this->model->getFileFok());
        if($json) {
            $old = json_decode($json, true);

        foreach ($newData as $key => $value) {
            $number = array_column($old, 'snils_number');
            $k = array_search(trim($value['snils_number']), $number);
            if (is_int($k) && $old[$k]['is_change']) {
                $newData[$key] = $old[$k];
            }
        }

        foreach ($old as $key => $value) {
            if(!$value['is_change']) {
                $number = array_column($newData, 'snils_number');
                $k = array_search(trim($value['snils_number']), $number);
                if (is_int($k)) {
                    $old[$key] = $newData[$k];
                }
            }
        }

        ArrayHelper::multisort($newData, ['sum_ball', 'is_first_status'], [SORT_DESC, SORT_DESC]);
        $this->createFile($newData, $this->model->getFile());
        ArrayHelper::multisort($old, ['sum_ball', 'is_first_status'], [SORT_DESC, SORT_DESC]);
        $this->createFile($old,$this->model->getFileFok());
        }
    }

    public function isSpec() {
        return $this->model == "Отдельная квота";
    }
}