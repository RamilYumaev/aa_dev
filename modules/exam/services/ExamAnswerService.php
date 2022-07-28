<?php


namespace modules\exam\services;;

use modules\exam\helpers\ExamQuestionHelper;
use modules\exam\models\ExamAnswer;
use modules\exam\models\ExamAnswerNested;
use modules\exam\repositories\ExamAttemptRepository;
use modules\exam\repositories\ExamQuestionInTestRepository;
use modules\exam\repositories\ExamQuestionRepository;
use modules\exam\repositories\ExamResultRepository;
use modules\exam\repositories\ExamTestRepository;
use testing\helpers\TestQuestionHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class ExamAnswerService
{
    private $repository,
        $testRepository,
        $testQuestionRepository,
        $testAndQuestionsRepository,
        $testAttemptRepository;

    function __construct(ExamResultRepository $repository,
                         ExamTestRepository $testRepository,
                         ExamQuestionRepository $testQuestionRepository,
                         ExamQuestionInTestRepository $testAndQuestionsRepository,
                         ExamAttemptRepository $testAttemptRepository)
    {
        $this->testAttemptRepository =  $testAttemptRepository;
        $this->testRepository = $testRepository;
        $this->testQuestionRepository = $testQuestionRepository;
        $this->repository = $repository;
        $this->testAndQuestionsRepository= $testAndQuestionsRepository;
    }

    public function addAnswer($data, $attempt_id) {
        $key = $this->getKey($data);
        $keyTqId = $this->getKeyTqId($data);
        $mark = $this->isTypeData($data);
        $resultTest = $this->repository->get($attempt_id, $key, $keyTqId);
        unset($data['key'], $data['keyTqId']);
        if (ExamQuestionHelper::questionType($key) !== TestQuestionHelper::TYPE_FILE) {
            $json = Json::encode($data);
            $resultTest->edit($json, $mark);
        }else {
            $resultTest->setFile($this->getFile());
        }
        $this->repository->save($resultTest);

    }

    public function isTypeData($data) {
        $key = $this->getKey($data);
        $keyTqId = $this->getKeyTqId($data);
        $tqId = $this->testAndQuestionsRepository->get($keyTqId);
        $answer = ExamAnswer::find()->where([ 'is_correct' => true,'question_id'=>$key]);
        $mark = 0;
        switch (ExamQuestionHelper::questionType($key)):
            case ExamQuestionHelper::TYPE_SELECT:
                if(!array_key_exists('select', $data)) {
                    throw new \DomainException( 'Выберите вариант(-ы) ответа.');
                }
                $valid = true;
                $data = $data['select'];
                $count = $answer->count();
                $column = $answer->select('id')->column();
                foreach ($data as $value) {
                    if(!in_array($value, $column)){
                        $valid = $valid && false;
                    }
                }
                $mark = $valid && count($data) == $count? $tqId->mark  : 0;
                \Yii::$app->session->addFlash('success','Ваш ответ сохранен!');
            break;
            case ExamQuestionHelper::TYPE_SELECT_ONE:
                if(!array_key_exists('select-one', $data)) {
                    throw new \DomainException( 'Выберите вариант ответа.');
                }
                $answer = $answer->andWhere(['in','id',$data['select-one']])->exists();
                $mark = $answer ? $tqId->mark  : 0;
                \Yii::$app->session->addFlash('success','Ваш ответ сохранен!');
            break;
            case ExamQuestionHelper::TYPE_ANSWER_DETAILED:
                if(!$data['detailed']) {
                    throw new \DomainException( 'Напишите эссе.');
                }

                $mark = null;
                \Yii::$app->session->addFlash('success','Ваш ответ сохранен!');
                break;
            case TestQuestionHelper::TYPE_MATCHING_SAME:
            case TestQuestionHelper::TYPE_MATCHING:
                 $data = $data['matching'];
                 $a = 0;
                foreach ($data as $index => $value) {
                    if(ExamAnswer::find()
                        ->where([ 'is_correct' => true,'question_id'=>$key])
                        ->andWhere(['id' => $index, 'answer_match'=> $value])->exists()){
                        ++$a;
                    }
                }
                $mark = $a == count($data) ? $tqId->mark  : 0;
                \Yii::$app->session->addFlash('success','Ваш ответ сохранен!');
                break;
            case ExamQuestionHelper::TYPE_ANSWER_SHORT:
                    if(!$data['short']) {
                    throw new \DomainException('Введите краткий ответ');
                }
                $answer = $answer->andWhere(['in','name', trim($data['short'])])->exists();
                $mark = $answer ? $tqId->mark  : 0;
                \Yii::$app->session->addFlash('success','Ваш ответ сохранен!');
                break;
            case ExamQuestionHelper::TYPE_FILE:
                if(!$this->getFile()) {
                    throw new \DomainException('Загрузите файл');
                }
                $mark = null;
                \Yii::$app->session->addFlash('success','Файл успешно загружен!');
                break;
        default:
            $dataAnswerCloze = array_key_exists('answer-cloze', $data) ? $data['answer-cloze'] :[];
            $dataSelectCloze  = array_key_exists('select-cloze', $data) ? $data['select-cloze'] :[];
            $countArray =  count($dataAnswerCloze) + count($dataSelectCloze);
            $b = 0;
            if($dataAnswerCloze) {
                foreach ($dataAnswerCloze as $index => $value) {
                    if(ExamAnswerNested::find()
                        ->where(['is_correct' => true])
                        ->andWhere(["question_nested_id" => $index, 'name' => $value])
                        ->exists()) {
                        ++$b;
                    }
                }
            }
            $c = 0;
            if ($dataSelectCloze) {
                foreach ($dataSelectCloze as $index1 => $value1) {
                    if(ExamAnswerNested::find()
                        ->where(['is_correct' => true])
                        ->andWhere(["question_nested_id" => $index1, 'name' => $value1])
                        ->exists()) {
                        ++$c;
                    }
                }
            }
            $sum = $b + $c;
            $mark = $sum == $countArray ? $tqId->mark : 0;
            \Yii::$app->session->addFlash('success','Ваш ответ сохранен!');
        endswitch;
        return $mark;
    }
    private function getKey($data) {
        return $data['key'];
    }

    private function getKeyTqId($data) {
        return $data['keyTqId'];
    }

    private function getFile() {
       return UploadedFile::getInstanceByName('AnswerAttempt[file]');
    }

}