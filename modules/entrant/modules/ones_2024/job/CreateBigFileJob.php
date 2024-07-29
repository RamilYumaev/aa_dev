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
        foreach (CgSS::find()->all() as $key => $item) {

            if (file_exists($item->getPathFullEpk().'/'.$item->getFile())) {
                $statemnts = $item->getList();
                $new = array_map(function($x) use($item) {
                    $x['name'] = $item->name;
                    $x['faculty'] = $item->faculty->full_name;
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
        $sheet->setCellValue('C1', 'Номер');
        $sheet->setCellValue('D1', 'ФИО');
        $sheet->setCellValue('E1', 'Телефон');
        $sheet->setCellValue('F1', 'СНИЛС / ID');

        $sheet->setCellValue('G1', 'Вступительное испытание 1');
        $sheet->setCellValue('H1', 'Вступительное испытание 2');
        $sheet->setCellValue('I1', 'Вступительное испытание 3');

        $sheet->setCellValue('J1', 'Сумма баллов по предметам');
        $sheet->setCellValue('K1', 'Сумма баллов по ИД для конкурса');
        $sheet->setCellValue('L1', 'Сумма баллов');

        $sheet->setCellValue('M1', 'Набор вступительных испытаний');
        $sheet->setCellValue('N1', 'Выводить первым');
        $sheet->setCellValue('O1', 'Статус СС');
        $sheet->setCellValue('P1', 'Приоритет EPK');

        $sheet->setCellValue('Q1', 'Прирориет СС');
        $sheet->setCellValue('S1', 'Наличия заявления СС');
        $sheet->setCellValue('R1', 'Наличия заявления EPK');
        $sheet->setCellValue('T1', 'Оригинал');
        $sheet->setCellValue('U1', 'Оригинал  МПГУ');
        $sheet->setCellValue('V1', 'Вуз, в который подан оригинал');

        $sheet->setCellValue('W1', 'Вид документа');
        $sheet->setCellValue('X1', 'Бумажный оригинал CC');
        $sheet->setCellValue('Y1', 'Электронный оригинал CC');
        $sheet->setCellValue('Z1', 'Нуждается в общежитии');
        $sheet->setCellValue('AA1',  'ID профиля');
        $sheet->setCellValue('AB1', 'Преимущественное право');
        $sheet->setCellValue('AC1', 'Оплачено');
        $sheet->setCellValue('AD1', 'Подтверждающий документ целевого направления номер документа');
        $sheet->setCellValue('AE1', 'Направляющая организация');
        $start = 2;
        foreach ($data as $key => $v) {
            $row = ($key+$start);
            $sheet->setCellValue('A'.($row), $v['name']);
            $sheet->setCellValue('B'.($row), $v['faculty']);
            $sheet->setCellValue('C'.($row), $v['number']);
            $sheet->setCellValue('D'.($row), $v['fio']);
            $sheet->setCellValue('E'.($row), $v['phone']);
            $sheet->setCellValue('F'.($row), $v['snils_number']);

            $sheet->setCellValue('G'.($row), $v['exam_1']);
            $sheet->setCellValue('H'.($row), $v['exam_2']);
            $sheet->setCellValue('I'.($row), $v['exam_3']);
            $sheet->setCellValue('J'.($row), $v['sum_exams']);
            $sheet->setCellValue('K'.($row), $v['sum_individual']);
            $sheet->setCellValue('L'.($row), key_exists('sum_ball', $v) ? $v['sum_ball'] : "");

            $sheet->setCellValue('M'.($row), $v['name_exams']);
            $sheet->setCellValue('N'.($row), $v['is_first_status']);
            $sheet->setCellValue('O'.($row), $v['status_ss']);
            $sheet->setCellValue('P'.($row), $v['priority']);
            $sheet->setCellValue('Q'.($row), $v['priority_ss']);
            $sheet->setCellValue('R'.($row), $v['is_ss']);
            $sheet->setCellValue('S'.($row), $v['is_epk']);
            $sheet->setCellValue('T'.($row), $v['original']);
            $sheet->setCellValue('U'.($row), $v['is_original']);
            $sheet->setCellValue('V'.($row), $v['vuz_original']);
            $sheet->setCellValue('W'.($row), $v['document']);

            $sheet->setCellValue('X'.($row), $v['is_paper_original_ss']);
            $sheet->setCellValue('Y'.($row), $v['is_el_original_ss']);
            $sheet->setCellValue('Z'.($row), $v['is_hostel']);
            $sheet->setCellValue('AA'.($row), $v['quid_profile']);
            $sheet->setCellValue('AB'.($row), $v['right']);
            $sheet->setCellValue('AC'.($row), $v['is_pay']);
            $sheet->setCellValue('AD'.($row), $v['document_target']);
            $sheet->setCellValue('AE'.($row), $v['organization']);
          }
        $writer = new Xlsx($spreadsheet);
        $writer->save($file);

//        $tbs = new TbsWrapper();
//        $tbs->openTemplate($filePath);
//        $tbs->merge('list', $data);
//        $tbs->saveAsFile($file);
    }
}