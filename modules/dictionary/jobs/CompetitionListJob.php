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
        $item = $this->getData();
            $this->saveCompetitionList($item, 'list', 'list_bvi');
            $this->saveCompetitionList($item, 'list_bvi', 'list');
            $this->saveRegister(RegisterCompetitionList::STATUS_SUCCESS);
        //}
        if (key_exists('error_message', $item)) {
            $this->saveRegister(RegisterCompetitionList::STATUS_ERROR, $this->getData()['error']);
        }
    }

    public function saveCompetitionList($item, $key, $keyUnset)
    {
        if (key_exists($key, $item)) {
            $model = new CompetitionList();
            if (key_exists($keyUnset, $item)) {
                unset($item[$keyUnset]);
            }
            $dateObject = new \DateTime($item['date_time']);
            $ymd = $dateObject->format("Ymd");
            $path = '/entrant/files/' . $ymd . '/' . $this->register->typeName .
                $this->register->number_update . '/' .
                $this->register->settingEntrant->edu_level . '/' .
                (is_null($this->register->settingEntrant->special_right) ? 0 : $this->register->settingEntrant->special_right);
            $alias = \Yii::getAlias('@modules');
            $fileName = ($this->register->settingEntrant->isGraduate() ? $this->register->faculty_id . '_' . $this->register->speciality_id : $this->register->ais_cg_id) . "_" . $key . '.json';
            if(FileHelper::createDirectory($alias . $path)) {
                throw  new \DomainException("Не удалось создать папку ". $alias . $path);
            }
            file_put_contents($alias . $path . '/' . $fileName, json_encode($item));
            $model->data($this->register->id, $key, $item['date_time'], $path . '/' . $fileName);
            $model->save();
        }
    }

    protected function saveRegister($status, $message = '')
    {
        $this->register->setStatus($status);
        $this->register->setErrorMessage($message);
        $this->register->save();
    }

    public function getData()
    {
        return json_decode('{
	"date_time": "2020-03-17  14:00:00",
	"kcp": {
		"transferred": 1,
		"sum": 15,
		"quota": 2,
		"target": 1
	},
	"price_per_semester": 92500,
	"list": [{
			"incoming_id": 123,
			"last name": "Иванов",
			"first name": "Иван",
			"patronymic": "Александрович",
			"payment_status": 1,
			"snils": "158-155-988 70",
			"subjects": [{
					"subject_id": 1,
					"ball": 95,
					"subject_type_id": 1,
					"check_status_id": 1
				},
				{
					"subject_id": 2,
					"ball": 80,
					"subject_type_id": 1,
					"check_status_id": 0
				},
				{
					"subject_id": 8,
					"ball": 70,
					"subject_type_id": 1,
					"check_status_id": 1
				}
			],
			"specialization_name": "Общая педагогика",
			"individual_achievements": [{
					"individual_achievement_name": "АсО",
					"ball": 5
				},
				{
					"individual_achievement_name": "ГТО",
					"ball": 2
				}
			],
			"sum_of_individual": 7,
			"zos_status_id": 1,
			"original_status_id": 1,
			"hostel_need_status_id": 0,
			"subject_sum": 245,
			"total_sum": 252,
			"target_organization_name": "ГБОУ ВО \"Московский педагогический государственный университет\"",
			"incoming_date": "2021-06-19",
			"bvi_status_id": 1,
			"bvi_right": "Наличие статуса победителя первенства Европы по тхэквондо",
			"pp_status_id": 1
		},
		{
			"incoming_id": 123,
			"last name": "Иванов",
			"first name": "Иван",
			"patronymic": "Александрович",
			"payment_status": 1,
			"snils": "158-155-988 70",
			"subjects": [{
					"subject_id": 1,
					"ball": 95,
					"subject_type_id": 1,
					"check_status_id": 1
				},
				{
					"subject_id": 2,
					"ball": 80,
					"subject_type_id": 1,
					"check_status_id": 0
				},
				{
					"subject_id": 8,
					"ball": 70,
					"subject_type_id": 1,
					"check_status_id": 1
				}
			],
			"specialization_name": "Общая педагогика",
			"individual_achievements": [{
					"individual_achievement_name": "АсО",
					"ball": 5
				},
				{
					"individual_achievement_name": "ГТО",
					"ball": 2
				}
			],
			"sum_of_individual": 7,
			"zos_status_id": 1,
			"original_status_id": 1,
			"hostel_need_status_id": 0,
			"subject_sum": 245,
			"total_sum": 252,
			"target_organization_name": "ГБОУ ВО \"Московский педагогический государственный университет\"",
			"incoming_date": "2021-06-19",
			"pp_status_id": 1
		}
	],
	"list_bvi": [{
			"incoming_id": 123,
			"last name": "Иванов",
			"first name": "Иван",
			"patronymic": "Александрович",
			"payment_status": 1,
			"snils": "158-155-988 70",
			"subjects": [{
					"subject_id": 1,
					"ball": 95,
					"subject_type_id": 1,
					"check_status_id": 1
				},
				{
					"subject_id": 2,
					"ball": 80,
					"subject_type_id": 1,
					"check_status_id": 0
				},
				{
					"subject_id": 8,
					"ball": 70,
					"subject_type_id": 1,
					"check_status_id": 1
				}
			],
			"specialization_name": "Общая педагогика",
			"individual_achievements": [{
					"individual_achievement_name": "АсО",
					"ball": 5
				},
				{
					"individual_achievement_name": "ГТО",
					"ball": 2
				}
			],
			"sum_of_individual": 7,
			"zos_status_id": 1,
			"original_status_id": 1,
			"hostel_need_status_id": 0,
			"subject_sum": 245,
			"total_sum": 252,
			"target_organization_name": "ГБОУ ВО \"Московский педагогический государственный университет\"",
			"incoming_date": "2021-06-19",
			"bvi_status_id": 1,
			"bvi_right": "Наличие статуса победителя первенства Европы по тхэквондо",
			"pp_status_id": 1
		},
		{
			"incoming_id": 123,
			"last name": "Иванов",
			"first name": "Иван",
			"patronymic": "Александрович",
			"payment_status": 1,
			"snils": "158-155-988 70",
			"subjects": [{
					"subject_id": 1,
					"ball": 95,
					"subject_type_id": 1,
					"check_status_id": 1
				},
				{
					"subject_id": 2,
					"ball": 80,
					"subject_type_id": 1,
					"check_status_id": 0
				},
				{
					"subject_id": 8,
					"ball": 70,
					"subject_type_id": 1,
					"check_status_id": 1
				}
			],
			"specialization_name": "Общая педагогика",
			"individual_achievements": [{
					"individual_achievement_name": "АсО",
					"ball": 5
				},
				{
					"individual_achievement_name": "ГТО",
					"ball": 2
				}
			],
			"sum_of_individual": 7,
			"zos_status_id": 1,
			"original_status_id": 1,
			"hostel_need_status_id": 0,
			"subject_sum": 245,
			"total_sum": 252,
			"target_organization_name": "ГБОУ ВО \"Московский педагогический государственный университет\"",
			"incoming_date": "2021-06-19",
			"bvi_status_id": 1,
			"bvi_right": "Наличие статуса победителя первенства Европы по тхэквондо",
			"pp_status_id": 1
		}
	]
}',true);
    }
}