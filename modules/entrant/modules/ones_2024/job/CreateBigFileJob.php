<?php
namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\model\CgSS;
use yii\base\BaseObject;
use yii\queue\Queue;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class CreateBigFileJob extends BaseObject implements \yii\queue\JobInterface
{
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
        \ini_set('memory_limit', '8000M');

        $filePath = \Yii::getAlias('@common') . '/file_templates/list_ss_all.xlsx';

        $data = [];

        $fileName = "all-list.xlsx";

        $file = \Yii::getAlias('@modules').'/entrant/files/ss/'.$fileName;

        if(file_exists($file)) {
            unlink($file);
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        /**
         * @var $item CgSS
         */
        $start = microtime(true);
        foreach (CgSS::find()->all() as $item) {

            if (file_exists($item->getPathFullEpk().'/'.$item->getFile())) {
                $statemnts = $item->getList();
                $new = array_map(function($x) use($item) {
                    $x['name'] = $item->name;
                    $x['faculty'] = $item->faculty->full_name;
                    $x['comment'] = $item->comment;
                    $x['edu_level'] = $item->education_level;
                    $x['edu_form'] = $item->education_form;
                    $x['type'] = $item->type;
                    return $x;
                }, $statemnts);

                $data = array_merge($data, $new);

                $end = microtime(true);
                $time = $end - $start;

                echo  $item->id." Did fopen test in $time seconds \n";
            }
        }
        $sheet->setCellValue('A1', 'Наименование');
        $sheet->setCellValue('B1', 'Факультет');
        $sheet->setCellValue('C1', 'Наименование 1с');
        $sheet->setCellValue('D1', 'Уровень образования');
        $sheet->setCellValue('E1', 'Форма обучения');
        $sheet->setCellValue('F1', 'Вид мест');
        $sheet->setCellValue('G1', 'Номер');
        $sheet->setCellValue('H1', 'ФИО');
        $sheet->setCellValue('I1', 'Телефон');
        $sheet->setCellValue('J1', 'СНИЛС / ID');

        $sheet->setCellValue('K1', 'Вступительное испытание 1');
        $sheet->setCellValue('L1', 'Вступительное испытание 2');
        $sheet->setCellValue('M1', 'Вступительное испытание 3');

        $sheet->setCellValue('N1', 'Сумма баллов по предметам');
        $sheet->setCellValue('O1', 'Сумма баллов по ИД для конкурса');
        $sheet->setCellValue('Q1', 'Сумма баллов');

        $sheet->setCellValue('P1', 'Набор вступительных испытаний');
        $sheet->setCellValue('R1', 'Выводить первым');
        $sheet->setCellValue('S1', 'Приоритет EPK');
        $sheet->setCellValue('T1', 'Прирориет СС');
        $sheet->setCellValue('U1', 'Статус СС');

        $sheet->setCellValue('V1', 'Наличия заявления EPK');
        $sheet->setCellValue('W1', 'Наличия заявления СС');
        $sheet->setCellValue('X1', 'Оригинал');
        $sheet->setCellValue('Y1', 'Оригинал в МПГУ');
        $sheet->setCellValue('Z1', 'Вуз, в который подан оригинал');

        $sheet->setCellValue('AA1', 'Вид документа');
        $sheet->setCellValue('AB1', 'Бумажный оригинал CC');
        $sheet->setCellValue('AC1', 'Электронный оригинал CC');
        $sheet->setCellValue('AD1', 'Нуждается в общежитии');
        $sheet->setCellValue('AE1',  'ID профиля');
        $sheet->setCellValue('AF1', 'Преимущественное право');
        $sheet->setCellValue('AG1', 'Оплачено');
        $sheet->setCellValue('AH1', 'Подтверждающий документ целевого направления номер документа');
        $sheet->setCellValue('AI1', 'Направляющая организация');
        $start = 2;
        foreach ($data as $key => $v) {
            $row = ($key+$start);
            $sheet->setCellValue('A'.($row), $v['name']);
            $sheet->setCellValue('B'.($row), $v['faculty']);
            $sheet->setCellValue('C'.($row), $v['comment']);
            $sheet->setCellValue('D'.($row), $v['edu_level']);
            $sheet->setCellValue('E'.($row), $v['edu_form']);
            $sheet->setCellValue('F'.($row), $v['type']);

            $sheet->setCellValue('G'.($row), $v['number']);
            $sheet->setCellValue('H'.($row), $v['fio']);
            $sheet->setCellValue('I'.($row), $v['phone']);
            $sheet->setCellValue('J'.($row), $v['snils_number']);

            $sheet->setCellValue('K'.($row), $v['exam_1']);
            $sheet->setCellValue('L'.($row), $v['exam_2']);
            $sheet->setCellValue('M'.($row), $v['exam_3']);
            $sheet->setCellValue('N'.($row), $v['sum_exams']);
            $sheet->setCellValue('O'.($row), $v['sum_individual']);
            $sheet->setCellValue('Q'.($row), key_exists('sum_ball', $v) ? $v['sum_ball'] : "");

            $sheet->setCellValue('P'.($row), $v['name_exams']);
            $sheet->setCellValue('R'.($row), $v['is_first_status']);
            $sheet->setCellValue('S'.($row), $v['priority']);
            $sheet->setCellValue('T'.($row), $v['priority_ss']);
            $sheet->setCellValue('U'.($row), $v['status_ss']);
            $sheet->setCellValue('V'.($row), $v['is_epk']);
            $sheet->setCellValue('W'.($row), $v['is_ss']);
            $sheet->setCellValue('X'.($row), $v['original']);
            $sheet->setCellValue('Y'.($row), $v['is_original']);
            $sheet->setCellValue('Z'.($row), $v['vuz_original']);

            $sheet->setCellValue('AA'.($row), $v['document']);
            $sheet->setCellValue('AB'.($row), $v['is_paper_original_ss']);
            $sheet->setCellValue('AC'.($row), $v['is_el_original_ss']);
            $sheet->setCellValue('AD'.($row), $v['is_hostel']);
            $sheet->setCellValue('AE'.($row), $v['quid_profile']);
            $sheet->setCellValue('AF'.($row), $v['right']);
            $sheet->setCellValue('AG'.($row), $v['is_pay']);
            $sheet->setCellValue('AH'.($row), key_exists('document_target', $v) ? $v['document_target'] : '');
            $sheet->setCellValue('AI'.($row), $v['organization']);
          }
        $writer = new Xlsx($spreadsheet);
        $writer->save($file);
    }
}