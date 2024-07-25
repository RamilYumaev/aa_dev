<?php

namespace modules\entrant\modules\ones_2024\model;

use yii\base\Model;

/**
 * Our data model extends yii\base\Model class so we can get easy to use and yet
 * powerful Yii 2 validation mechanism.
 */
class EpkSearch extends Model
{
    public $fio, $number, $phone, $snils_number,$exam_1 ,$exam_2,$exam_3,$sum_exams,
        $sum_individual,
        $sum_ball,
        $name_exams,
        $priority,
        $original,
        $right,
        $is_pay,$document,
        $organization,
        $status_ss,
        $priority_ss,
         $is_paper_original_ss,
         $is_el_original_ss,
         $is_hostel,
         $quid_profile,
         $is_first_status,
        $is_epk,
        $is_ss,
        $document_target;

    public $entrants;

    public function __construct($data, $config = [])
    {
        $this->entrants = $data;
        parent::__construct($config);
    }

    /**
     * Here we can define validation rules for each filtered column.
     * See http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     * for more information about validation.
     */
    public function rules()
    {
        return [
            [['fio', 'number','phone','snils_number','exam_1','exam_2','exam_3','sum_exams',
                'sum_individual',
                'sum_ball',
                'name_exams',
                 'status_ss',
                'priority_ss',
                'is_paper_original_ss',
                'is_el_original_ss',
                'is_hostel',
                 'quid_profile',
                 'is_first_status',
                'priority',
                'is_ss',
                 'is_epk',
                'original','right','is_pay','document','document_target', 'organization'], 'string'],
            // our columns are just simple string, nothing fancy
        ];
    }

    /**
     * In this example we keep this special property to know if columns should be
     * filtered or not. See search() method below.
     */
    private $_filtered = false;

    /**
     * This method returns ArrayDataProvider.
     * Filtered and sorted if required.
     */
    public function search($params)
    {
        if ($this->load($params) && $this->validate()) {
            $this->_filtered = true;
        }

        return new \yii\data\ArrayDataProvider([
            // ArrayDataProvider here takes the actual data source
            'allModels' => $this->getData(),
            'sort' => [
                // we want our columns to be sortable:
                'attributes' => ['fio', 'number','phone','snils_number','exam_1','exam_2','exam_3','sum_exams',
                    'sum_individual',
                    'sum_ball',
                    'is_first_status',
                    'name_exams',
                    'status_ss',
                    'priority_ss',
                    'is_paper_original_ss',
                    'is_el_original_ss',
                    'is_hostel',
                    'quid_profile',
                    'priority',
                    'is_epk',
                    'original','right','is_pay','document','document_target', 'organization'
                ],
            ],
        ]);
    }

    /**
     * Here we are preparing the data source and applying the filters
     * if _filtered property is set to true.
     */
    protected function getData()
    {
        $data = $this->entrants;

        if (count($data) && $this->_filtered) {
            $data = array_filter($data, function ($value) {
                $conditions = [true];
                if (!empty($this->fio)) {
                    $conditions[] = strpos($value['fio'], $this->fio) !== false;
                }
                if (!empty($this->snils_number)) {
                    $conditions[] = strpos($value['snils_number'], $this->snils_number) !== false;
                }
                return array_product($conditions);
            });
        }

        return $data;
    }

    public function attributeLabels()
    {
        return [
                'number' => 'Номер',
                'fio' => 'ФИО',
                'phone'=> "Телефон" ,
                'snils_number' => "СНИЛС / ID",
                'exam_1' => "Вступительное испытание 1",
                'exam_2' => "Вступительное испытание 2",
                'exam_3' => "Вступительное испытание 3",
                'sum_exams' => "Сумма баллов по предметам",
                'sum_individual' => "Сумма баллов по ИД для конкурса",
                'sum_ball' => "Сумма баллов",
                'name_exams'=> "Набор вступительных испытаний",
                'priority' => "Приоритет EPK",
                'original' => "Оригинал",
                'right' => "Преимущественное право",
                'is_pay' => "Оплачено",
                'is_first_status'=> 'Выводить первым',
                'document' => "Вид документа",
                'document_target' => "Подтверждающий документ целевого направления номер документа",
                'organization' => "Направляющая организация",
                'status_ss' => 'Статус СС',
                'priority_ss' => 'Прирориет СС',
                'is_paper_original_ss' => 'Бумажный оригинал СС',
                'is_el_original_ss' => 'Электронный оригинал СС',
                'is_hostel' => 'Нуждается в общежитии',
                'quid_profile' =>  'quid профиля',
                'is_ss' => 'Наличия заявления СС',
                'is_epk' => 'Наличия заявления EPK '
        ];
    }
}