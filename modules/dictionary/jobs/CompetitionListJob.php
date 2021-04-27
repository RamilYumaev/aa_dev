<?php


namespace modules\dictionary\jobs;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\RegisterCompetitionList;
use yii\base\BaseObject;
use yii\helpers\FileHelper;

class CompetitionListJob extends BaseObject implements \yii\queue\JobInterface
{
    public $url;

    /** @var RegisterCompetitionList $register */

    public $register;
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
        $this->saveRegister(RegisterCompetitionList::STATUS_SEND);
        //$result =  (new Client())->postData($this->url, $this->data);
        if(key_exists($this->register->ais_cg_id, $this->getData())) {
            foreach ($this->getData() as $aisCg => $value) {
                foreach ($value as $key => $item){
                    $model = new CompetitionList();
                    $dateObject = new \DateTime($item['date']);
                    $ymd = $dateObject->format("Ymd");
                    $path = '/entrant/files/'.$ymd.'/'.$this->register->typeName.$this->register->number_update.'/'.$item['type'];
                    $alias =  \Yii::getAlias('@modules');
                    $fileName = $aisCg.'.json';
                    FileHelper::createDirectory($alias.$path);
                    file_put_contents($alias.$path.'/'.$fileName, json_encode($value[$key]));
                    $model->data($aisCg, $this->register->id, $item['type'], $item['date'], $path.'/'.$fileName);
                    $model->save();
                }
            }
            $this->saveRegister(RegisterCompetitionList::STATUS_SUCCESS);
        }
        if(key_exists('error_message', $this->getData())) {
            $this->saveRegister(RegisterCompetitionList::STATUS_ERROR, $this->getData()['error']);
        }

    }

    protected function saveRegister ($status, $message = '') {
        $this->register->setStatus($status);
        $this->register->setErrorMessage($message);
        $this->register->save();
    }

    private function getData() {
       return
           [571 => [[
            'year' => '2021/2022',
            'type'=>1,
            'date' => '2020-03-17 14:00:00',
            'kcp' => [
                'transferred' => 0,
                'sum' => 15,
                'quota' => 2,
                'target' => 1,
            ],
            'price_per_semester' => '92500 руб/семестр',
            'entrants' => [
                ['incoming_id' => 123,
                    'last name' => "Иванов",
                    'first name' => "Иван",
                    'patronymic' => "Александрович",
                    'snils' => "158-155-988-70",
                    'subjects' => [
                        ['subject_id' => 29, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject_id' => 30, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject_id' => 31, 'ball' => 90, 'check_status' => 1, 'subject_type' => 1],
                    ],
                    'individual_archievments ' => [
                        ['name_of_individual_archievment' => "АсО", 'ball' => 5],
                        ['name_of_individual_archievment' => "ГТО", 'ball' => 2],],
                    'sum_of_individual' => 7,
                    'zos' => 1,
                    'original_of_document ' => 1,
                    'hostel_need_status' => 0,
                    'total_sum' => 287,
                    'incoming_date' => '2021-06-19',
                ],
                ['incoming_id' => 122,
                    'last_name' => "Иванов",
                    'first_name' => "Иван",
                    'patronymic' => "Александрович",
                    'snils' => "158-155-988-70",
                    'subjects' => [
                        ['subject' => 29, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject' => 30, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject' => 31, 'ball' => 89, 'check_status' => 1, 'subject_type' => 1],
                    ],
                    'individual_archievments ' => [
                        ['name_of_individual_archievment' => "АсО", 'ball' => 5],
                        ['name_of_individual_archievment' => "ГТО", 'ball' => 2],],
                    'sum_of_individual' => 7,
                    'zos' => 1,
                    'original_of_document ' => 1,
                    'hostel_status' => 0,
                    'total_sum' => 286,
                    'incoming_date' => '2021-06-18',
                ],
            ],
        ],[
            'year' => '2021/2022',
            'type'=>4,
            'date' => '2020-03-17  14:00:00',
            'kcp' => [
                'transferred' => 0,
                'sum' => 15,
                'quota' => 2,
                'target' => 1,
            ],
            'price_per_semester' => '92500 руб/семестр',
            'entrants' => [
                ['incoming_id' => 123,
                    'last name' => "Иванов",
                    'first name' => "Иван",
                    'patronymic' => "Александрович",
                    'snils' => "158-155-988-70",
                    'subjects' => [
                        ['subject_id' => 29, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject_id' => 30, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject_id' => 31, 'ball' => 90, 'check_status' => 1, 'subject_type' => 1],
                    ],
                    'individual_archievments ' => [
                        ['name_of_individual_archievment' => "АсО", 'ball' => 5],
                        ['name_of_individual_archievment' => "ГТО", 'ball' => 2],],
                    'sum_of_individual' => 7,
                    'zos' => 1,
                    'original_of_document ' => 1,
                    'hostel_need_status' => 0,
                    'total_sum' => 287,
                    'incoming_date' => '2021-06-19',
                ],
                ['incoming_id' => 122,
                    'last_name' => "Иванов",
                    'first_name' => "Иван",
                    'patronymic' => "Александрович",
                    'snils' => "158-155-988-70",
                    'subjects' => [
                        ['subject' => 29, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject' => 30, 'ball' => 95, 'check_status' => 1, 'subject_type' => 1],
                        ['subject' => 31, 'ball' => 89, 'check_status' => 1, 'subject_type' => 1],
                    ],
                    'individual_archievments ' => [
                        ['name_of_individual_archievment' => "АсО", 'ball' => 5],
                        ['name_of_individual_archievment' => "ГТО", 'ball' => 2],],
                    'sum_of_individual' => 7,
                    'zos' => 1,
                    'original_of_document ' => 1,
                    'hostel_status' => 0,
                    'total_sum' => 286,
                    'incoming_date' => '2021-06-18',
                ],
            ],
        ]
            ]];
    }
}