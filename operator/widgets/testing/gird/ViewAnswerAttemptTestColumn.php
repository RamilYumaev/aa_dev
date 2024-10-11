<?php

namespace operator\widgets\testing\gird;

use testing\helpers\AnswerHelper;
use testing\helpers\QuestionPropositionHelper;
use testing\helpers\TestQuestionHelper;
use testing\models\TestResult;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;


class ViewAnswerAttemptTestColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return  $this->getQuestions($model);
    }

    private function getQuestions(TestResult $model): string
    {
        switch (TestQuestionHelper::questionType($model->question_id)):
            case TestQuestionHelper::TYPE_SELECT:
                $data = $this->data($model->result);
                $answer = $data ? $data['select'] : "";
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>'.
                    ($answer ? Html::tag('h4','Ответы: '.implode(", ", AnswerHelper::answerNameAll($answer))) : '');
                break;
            case TestQuestionHelper::TYPE_SELECT_ONE:
                $data = $this->data($model->result);
                $answer = $data ? $data['select-one'] : "";
                $answerEntity = AnswerHelper::answerNameOne($answer);
                $textAnswer = $answerEntity ? $answerEntity->name : "Ответ не найден в системе. ID ответа $answer";
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>'.
                    ($answer ? Html::tag('h4','Ответ: '.$textAnswer) : '');
                break;
            case TestQuestionHelper::TYPE_ANSWER_DETAILED:
                $data = $this->data($model->result);
                $answer = $data ? $data['detailed'] : "";
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>'.
                    ($answer ?  Html::tag('h4','Ответ: '.$answer) : '');
                break;
            case TestQuestionHelper::TYPE_URL:
                $data = $this->data($model->result);
                $answer = $data ? $data['url'] : "";
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>'.
                    ($answer ?  Html::a('Внешняя ссылка', $answer, ['target' => '_blank']) : '');
                break;
            case TestQuestionHelper::TYPE_MATCHING:
                $data = $this->data($model->result);
                $answer = $data ? $data['matching'] : "";
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>';
                foreach (AnswerHelper::answerMatching($model->question_id) as $id => $value) {
                    $text.=   Html::tag('h4',$value ." - ". ($answer ? $answer[$id] : ""));
                }
                break;
            case TestQuestionHelper::TYPE_ANSWER_SHORT:
                $data = $this->data($model->result);
                $answer = $data ? $data['short'] :"";
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>'.
                    ($answer ? Html::tag('h4','Ответ: '.$answer) : '');
                break;
            case TestQuestionHelper::TYPE_FILE:
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br> '.
                    ($model->getUploadedFileUrl('result') ?
                     Html::tag('h4','Ответ: '.Html::a("Ссылка", Url::to( $model->getUploadedFileUrl('result')))) : "");
                break;
            default:
                $data = $this->data($model->result);
                $answer = $data ? $data :"";
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>';
                if($answer) {
                    $text.= Html::beginTag('h4');
                    foreach (QuestionPropositionHelper::questionPropositionList($model->question_id) as $index => $item) {
                        if (QuestionPropositionHelper::type($index) == TestQuestionHelper::CLOZE_SELECT) {
                            $drop = $answer['select-cloze'][$index];
                            $text .= QuestionPropositionHelper::isStart($index) ? $drop ." ". $item : $item ." ". $drop;
                            $text.=" ";
                        } elseif (QuestionPropositionHelper::type($index) == TestQuestionHelper::CLOZE_TEXT) {
                            $input = $answer['answer-cloze'][$index];
                            $text .= QuestionPropositionHelper::isStart($index) ? $input ." ".  $item : $item ." ".  $input;
                            $text.=" ";
                        } else {
                            $text .= $item;
                        }
                    }
                    $text.=  Html::endTag('h4');
                }
                break;
        endswitch;
        return $text;
    }

    private function data($data) {
        return Json::decode($data);
    }
}