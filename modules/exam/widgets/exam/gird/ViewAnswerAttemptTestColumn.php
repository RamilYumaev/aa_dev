<?php

namespace modules\exam\widgets\exam\gird;

use modules\exam\helpers\ExamAnswerHelper;
use modules\exam\helpers\ExamQuestionNestedHelper;
use modules\exam\models\ExamAnswerNested;
use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamResult;
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
        return  $this->getQuestions($model).$this->getCorrectAnswer($model).'<br/> <br/>'.
            ($model->note ? "Комментарий экзаменатора: ".$model->note : "");
    }

    private function getQuestions(ExamResult $model): string
    {
        switch ($model->question->type_id):
            case TestQuestionHelper::TYPE_SELECT:
                $data = $this->data($model->result);
                $text = $model->question->text.'</br>';
                if ($data &&  array_key_exists('select', $data)) {
                $answer = $data ? $data['select'] : "";
                $text.= ($answer ? Html::tag('h4','Ответы: '.implode(", ", ExamAnswerHelper::answerNameAll($answer))) : '');
                }
                break;
            case TestQuestionHelper::TYPE_SELECT_ONE:
                $data = $this->data($model->result);
                $text = $model->question->text.'</br>';
                if ($data && array_key_exists('select-one', $data)) {
                 $answer = $data ? $data['select-one'] : "";
                $text.= ($answer ? Html::tag('h4','Ответ: '.ExamAnswerHelper::answerNameOne($answer)) : '');
                }
                break;
            case TestQuestionHelper::TYPE_ANSWER_DETAILED:
                $data = $this->data($model->result);
                $text =  $model->question->text.'</br>';
                if ($data &&  array_key_exists('detailed', $data)) {
                $answer = $data ? $data['detailed'] : "";
                $text.= ($answer ?  Html::tag('h4','Ответ: '.$answer) : '');
                }
                break;
            case TestQuestionHelper::TYPE_MATCHING:
                $data = $this->data($model->result);
                $text =  $model->question->text.'</br>';
                if ($data && array_key_exists('matching', $data)) {
                $answer = $data ? $data['matching'] : "";
                $text.=   Html::tag('h4',"Ответ");
                foreach (ExamAnswerHelper::answerMatching($model->question_id) as $id => $value) {
                    $text.=   Html::tag('h4',$value ." - ". ($answer ? $answer[$id] : ""));
                }
            }
                break;
            case TestQuestionHelper::TYPE_ANSWER_SHORT:
                $data = $this->data($model->result);
                $text = $model->question->text.'</br>';
                if ($data && array_key_exists('short', $data)) {
                $answer = $data ? $data['short'] :"";
                $text.=($answer ? Html::tag('h4','Ответ: '.$answer) : '');
                }
                break;
            case TestQuestionHelper::TYPE_FILE:
                $text =  $model->question->text.'</br> '.
                    ($model->getUploadedFileUrl('result') ?
                     Html::tag('h4','Ответ: '.Html::a("Ссылка", Url::to( $model->getUploadedFileUrl('result')))) : "");
                break;
            default:
                $data = $this->data($model->result);
                $answer = $data ? $data :"";
                $text =  $model->question->text.'</br>';
                if($answer) {
                    $text.= Html::tag('h4', "Ответ");
                    $text.= Html::beginTag('h4');
                    foreach (ExamQuestionNestedHelper::questionPropositionList($model->question_id) as $index => $item) {
                        if (ExamQuestionNestedHelper::type($index) == TestQuestionHelper::CLOZE_SELECT) {
                            $drop = $answer['select-cloze'][$index];
                            $text .= ExamQuestionNestedHelper::isStart($index) ? $drop ." ". $item : $item ." ". $drop;
                            $text.=" ";
                        } elseif (ExamQuestionNestedHelper::type($index) == TestQuestionHelper::CLOZE_TEXT) {
                            $input = $answer['answer-cloze'][$index];
                            $text .= ExamQuestionNestedHelper::isStart($index) ? $input ." ".  $item : $item ." ".  $input;
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

    private function getCorrectAnswer(ExamResult $model): string
    {
        $answers = $model->question->answerCorrect;
        switch ($model->question->type_id):
            case TestQuestionHelper::TYPE_SELECT:
                $answerText = "Правильные ответы: ";
                foreach ($answers as $answer) {
                  $answerText .= $answer->name.', ';
                }
                $text = Html::tag('h4',$answerText);
                break;
            case TestQuestionHelper::TYPE_SELECT_ONE:
                $answerText = "Правильный ответ: ";
                foreach ($answers as $answer) {
                $answerText .= $answer->name.' ';
                }
                $text = Html::tag('h4',$answerText);
                break;
            case TestQuestionHelper::TYPE_CLOZE:
                $text= Html::tag('h4', "Правильный ответ ");
                $text.= Html::beginTag('h4');
                foreach (ExamQuestionNestedHelper::questionPropositionList($model->question_id) as $index => $item) {
                    $answers = ExamAnswerNested::find()->where([ 'is_correct' => true, 'question_nested_id'=>$index]);
                    $drop = "(";
                    foreach ($answers->all() as  $answer) {
                        $drop .= $answer->name;
                    }
                    $drop.= ")";
                    if (ExamQuestionNestedHelper::type($index) == TestQuestionHelper::CLOZE_SELECT) {
                        $text .= ExamQuestionNestedHelper::isStart($index) ? $drop . " " . $item : $item . " " . $drop;
                        $text .= " ";
                    } elseif (ExamQuestionNestedHelper::type($index) == TestQuestionHelper::CLOZE_TEXT) {

                        $text .= ExamQuestionNestedHelper::isStart($index) ? $drop . " " . $item : $item . " " . $drop;
                        $text .= " ";
                    } else {
                        $text .= $item;
                    }
                }
                $text.=  Html::endTag('h4');
                break;
            case TestQuestionHelper::TYPE_MATCHING:
                $answerText = "Правильные ответы: ";
                foreach ($answers as $answer) {
                    $answerText .= $answer->name.' - '.$answer->answer_match ."; ";
                }
                $text = Html::tag('h4',$answerText);
                break;
            case TestQuestionHelper::TYPE_ANSWER_SHORT:
                $answerText = "Правильный(-ые) ответ(-ы): <br/>";
                foreach ($answers as $answer) {
                    $answerText .= $answer->name.'<br/>';
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