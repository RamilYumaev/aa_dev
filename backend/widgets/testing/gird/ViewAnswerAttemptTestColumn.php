<?php

namespace backend\widgets\testing\gird;

use testing\helpers\AnswerHelper;
use testing\helpers\QuestionPropositionHelper;
use testing\helpers\TestQuestionHelper;
use testing\models\Answer;
use testing\models\AnswerCloze;
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
        return  $this->getQuestions($model).$this->getCorrectAnswer($model);
    }

    private function getQuestions(TestResult $model): string
    {
        switch (TestQuestionHelper::questionType($model->question_id)):
            case TestQuestionHelper::TYPE_SELECT:
                $data = $this->data($model->result);
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>';
                if ($data &&  array_key_exists('select', $data)) {
                $answer = $data ? $data['select'] : "";
                $text.= ($answer ? Html::tag('h4','Ответы: '.implode(", ", AnswerHelper::answerNameAll($answer))) : '');
                }
                break;
            case TestQuestionHelper::TYPE_SELECT_ONE:
                $data = $this->data($model->result);
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>';
                if ($data && array_key_exists('select-one', $data)) {
                 $answer = $data ? $data['select-one'] : "";
                $text.= ($answer ? Html::tag('h4','Ответ: '.AnswerHelper::answerNameOne($answer)) : '');
                }
                break;
            case TestQuestionHelper::TYPE_ANSWER_DETAILED:
                $data = $this->data($model->result);
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>';
                if ($data &&  array_key_exists('detailed', $data)) {
                $answer = $data ? $data['detailed'] : "";
                $text.= ($answer ?  Html::tag('h4','Ответ: '.$answer) : '');
                }
                break;
            case TestQuestionHelper::TYPE_MATCHING:
                $data = $this->data($model->result);
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>';
                if ($data && array_key_exists('matching', $data)) {
                $answer = $data ? $data['matching'] : "";
                $text.=   Html::tag('h4',"Ответ");
                foreach (AnswerHelper::answerMatching($model->question_id) as $id => $value) {
                    $text.=   Html::tag('h4',$value ." - ". ($answer ? $answer[$id] : ""));
                }
            }
                break;
            case TestQuestionHelper::TYPE_ANSWER_SHORT:
                $data = $this->data($model->result);
                $text = TestQuestionHelper::questionTextName($model->question_id).'</br>';
                if ($data && array_key_exists('short', $data)) {
                $answer = $data ? $data['short'] :"";
                $text.=($answer ? Html::tag('h4','Ответ: '.$answer) : '');
                }
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
                    $text.= Html::tag('h4', "Ответ");
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
        return $text ?? "";
    }

    private function getCorrectAnswer(TestResult $model): string
    {
        $answers = Answer::find()->where([ 'is_correct' => true,'quest_id'=>$model->question_id]);
        switch (TestQuestionHelper::questionType($model->question_id)):
            case TestQuestionHelper::TYPE_SELECT:
                $answerText = "Правильные ответы: ";
                foreach ($answers->all() as $answer) {
                  $answerText .= $answer->name.', ';
                }
                $text = Html::tag('h4',$answerText);
                break;
            case TestQuestionHelper::TYPE_SELECT_ONE:
                $answerText = "Правильный ответ: ";
                $answerText .= $answers->one()->name.' ';
                $text = Html::tag('h4',$answerText);
                break;
            case TestQuestionHelper::TYPE_CLOZE:
                $text= Html::tag('h4', "Правильный ответ ");
                $text.= Html::beginTag('h4');
                foreach (QuestionPropositionHelper::questionPropositionList($model->question_id) as $index => $item) {
                    $answers = AnswerCloze::find()->where([ 'is_correct' => true, 'quest_prop_id'=>$index]);
                    $drop = "(";
                    foreach ($answers->all() as  $answer) {
                        $drop .= $answer->name;
                    }
                    $drop.= ")";
                    if (QuestionPropositionHelper::type($index) == TestQuestionHelper::CLOZE_SELECT) {
                        $text .= QuestionPropositionHelper::isStart($index) ? $drop . " " . $item : $item . " " . $drop;
                        $text .= " ";
                    } elseif (QuestionPropositionHelper::type($index) == TestQuestionHelper::CLOZE_TEXT) {

                        $text .= QuestionPropositionHelper::isStart($index) ? $drop . " " . $item : $item . " " . $drop;
                        $text .= " ";
                    } else {
                        $text .= $item;
                    }
                }
                $text.=  Html::endTag('h4');
                break;
            case TestQuestionHelper::TYPE_MATCHING:
                $answerText = "Правильные ответы: ";
                foreach ($answers->all() as $answer) {
                    $answerText .= $answer->name.' - '.$answer->answer_match ."; ";
                }
                $text = Html::tag('h4',$answerText);
                break;
            case TestQuestionHelper::TYPE_ANSWER_SHORT:
                $answerText = "Правильный(-ые) ответ(-ы): ";
                foreach ($answers->all() as $answer) {
                    $answerText .= $answer->name.', ';
                }
                $text = Html::tag('h4',$answerText);
                break;
            default:
                $text = "";
                break;
        endswitch;
        return $text ?? "";
    }
    private function data($data) {
        return Json::decode($data);
    }
}