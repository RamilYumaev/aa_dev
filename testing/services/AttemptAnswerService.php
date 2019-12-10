<?php


namespace testing\services;

use testing\helpers\TestQuestionHelper;
use testing\models\Answer;
use testing\models\AnswerCloze;
use testing\repositories\TestAndQuestionsRepository;
use testing\repositories\TestAttemptRepository;
use testing\repositories\TestQuestionRepository;
use testing\repositories\TestRepository;
use testing\repositories\TestResultRepository;
use yii\helpers\Json;
use yii\web\UploadedFile;

class AttemptAnswerService
{
    private  $repository,
        $testRepository,
        $testQuestionRepository,
        $testAndQuestionsRepository,
        $testAttemptRepository;

    function __construct(TestResultRepository $repository,
                         TestRepository $testRepository,
                         TestQuestionRepository $testQuestionRepository,
                         TestAndQuestionsRepository $testAndQuestionsRepository,
                         TestAttemptRepository $testAttemptRepository)
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
        if (TestQuestionHelper::questionType($key) !== TestQuestionHelper::TYPE_FILE) {
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
        $answer = Answer::find()->where([ 'is_correct' => true,'quest_id'=>$key]);
        $mark = 0;
        switch (TestQuestionHelper::questionType($key)):
            case TestQuestionHelper::TYPE_SELECT:
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
            break;
            case TestQuestionHelper::TYPE_SELECT_ONE:
                if(!array_key_exists('select-one', $data)) {
                    throw new \DomainException( 'Выберите вариант ответа.');
                }
                $answer = $answer->andWhere(['in','id',$data['select-one']])->exists();
                $mark = $answer ? $tqId->mark  : 0;
            break;
            case TestQuestionHelper::TYPE_ANSWER_DETAILED:
                if(!$data['detailed']) {
                    throw new \DomainException( 'Напишите эссе.');
                }
                $mark = null;
                break;
            case TestQuestionHelper::TYPE_MATCHING:
                 $data = $data['matching'];
                 $a = 0;
                foreach ($data as $index => $value) {
                    if(Answer::find()
                        ->where([ 'is_correct' => true,'quest_id'=>$key])
                        ->andWhere(['id' => $index, 'answer_match'=> $value])->exists()){
                        ++$a;
                    }
                }
                $mark = $a == count($data) ? $tqId->mark  : 0;
                break;
            case TestQuestionHelper::TYPE_ANSWER_SHORT:
                    if(!$data['short']) {
                    throw new \DomainException('Введите краткий ответ');
                }
                $answer = $answer->andWhere(['in','name', trim($data['short'])])->exists();
                $mark = $answer ? $tqId->mark  : 0;
                break;
            case TestQuestionHelper::TYPE_FILE:
                if(!$this->getFile()) {
                    throw new \DomainException('Загружите файл');
                }
                $mark = null;
                break;
        default:
            $dataAnswerCloze = $data['answer-cloze'];
            $dataSelectCloze  = $data['select-cloze'];
            $countArray =  count($dataAnswerCloze) + count($dataSelectCloze);
            $b = 0;
            foreach ($dataAnswerCloze as $index => $value) {
                if(AnswerCloze::find()
                    ->where(['is_correct' => true])
                    ->andWhere(["quest_prop_id" => $index, 'name' => $value])
                    ->exists()) {
                    ++$b;
                }
            }
            $c = 0;
            foreach ($dataSelectCloze as $index1 => $value1) {
                if(AnswerCloze::find()
                    ->where(['is_correct' => true])
                    ->andWhere(["quest_prop_id" => $index1, 'name' => $value1])
                    ->exists()) {
                    ++$c;
                }
            }
            $sum = $b + $c;
            $mark = $sum == $countArray ? $tqId->mark : 0;

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