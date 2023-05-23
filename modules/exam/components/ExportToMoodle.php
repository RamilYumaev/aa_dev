<?php
namespace modules\exam\components;

use dictionary\models\DictDiscipline;
use modules\exam\helpers\ExamQuestionHelper;
use modules\exam\models\ExamAnswer;
use modules\exam\models\ExamAnswerNested;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamQuestionNested;

class ExportToMoodle
{
    private $filename;

    public function export($discipline_id)
    {
        $discipline = DictDiscipline::findOne($discipline_id);
        $this->setFilename($discipline->name.'.xml');

        $dom = new \DOMDocument("1.0", "utf-8"); // Создаём XML-документ версии 1.0 с кодировкой utf-8
        $root = $dom->createElement("quiz"); // Создаём корневой элемент
        $dom->appendChild($root);

        $question = $dom->createElement("question");
        $question->setAttribute("type", 'category');
        $category = $dom->createElement("category");
        $text = $dom->createElement('text', $discipline->name);

        $category->appendChild($text);
        $question->appendChild($category);
        $info = $dom->createElement("info");
        $info->setAttribute('format','moodle_auto_format');
        $info->appendChild( $dom->createElement('text', $discipline->name));
        $question->appendChild($info);
        $idnumber = $dom->createElement('idnumber');
        $question->appendChild($idnumber);
        $root->appendChild($question);
        /**
         * @var int $index
         * @var ExamQuestion $examQuestion
         */
        foreach (ExamQuestion::find()->andWhere(['discipline_id' => $discipline_id])
                     ->all() as $index => $examQuestion) {
            $count = $examQuestion->getAnswer()->count();
            if ($count > 1 || in_array($examQuestion->type_id, [ExamQuestionHelper::TYPE_FILE, ExamQuestionHelper::TYPE_ANSWER_DETAILED, ExamQuestionHelper::TYPE_CLOZE])) {
                $question = $dom->createElement("question");
                $question->setAttribute("type",
                    $this->setTypeName($examQuestion->type_id));
                $name = $dom->createElement("name");
                $text = $dom->createElement('text', $examQuestion->title . " _" . $examQuestion->discipline->name . "_");
                $name->appendChild($text);
                $question->appendChild($name);

                $questiontext = $dom->createElement('questiontext');
                $questiontext->setAttribute('format', 'html');
                $description = $questiontext->appendChild($dom->createElement('text'));
                $description->appendChild($dom->createCDATASection($examQuestion->type_id == ExamQuestionHelper::TYPE_CLOZE ? $this->getClozeTextForQuestion($examQuestion) : $examQuestion->text));
                $questiontext->appendChild($description);
                $question->appendChild($questiontext);

                if(in_array($examQuestion->type_id, [ExamQuestionHelper::TYPE_SELECT_ONE, ExamQuestionHelper::TYPE_CLOZE])) {
                    $generalfeedback = $dom->createElement('generalfeedback');
                    $generalfeedback->setAttribute('format', 'html');
                    $generalfeedback->appendChild($dom->createElement('text'));
                    $question->appendChild($generalfeedback);
                }
                if($examQuestion->type_id != ExamQuestionHelper::TYPE_CLOZE) {
                    $defaultgrade = $dom->createElement('defaultgrade', '1.0000000');
                    $question->appendChild($defaultgrade);
                }
                $penalty = $dom->createElement('penalty', '1.0000000');
                $question->appendChild($penalty);

                $hidden = $dom->createElement('hidden', 0);
                $question->appendChild($hidden);

                $idnumber = $dom->createElement('idnumber');
                $question->appendChild($idnumber);

                if($examQuestion->type_id == ExamQuestionHelper::TYPE_SELECT_ONE) {
                    $single = $dom->createElement('single', 'true');
                    $question->appendChild($single);
                }

                if(!in_array($examQuestion->type_id, [ExamQuestionHelper::TYPE_FILE, ExamQuestionHelper::TYPE_ANSWER_DETAILED, ExamQuestionHelper::TYPE_CLOZE])) {
                    $shuffleanswers = $dom->createElement('shuffleanswers', 'true');
                    $question->appendChild($shuffleanswers);
                }

                if($examQuestion->type_id == ExamQuestionHelper::TYPE_SELECT_ONE) {
                    $answernumbering = $dom->createElement('answernumbering', 'none');
                    $question->appendChild($answernumbering);

                    $showstandardinstruction = $dom->createElement('showstandardinstruction', '0');
                    $question->appendChild($showstandardinstruction);
                }

                if(!in_array($examQuestion->type_id, [ExamQuestionHelper::TYPE_FILE, ExamQuestionHelper::TYPE_ANSWER_DETAILED, ExamQuestionHelper::TYPE_CLOZE])) {
                    $correctfeedback = $dom->createElement('correctfeedback');
                    $correctfeedback->setAttribute('format', 'html');
                    $correctfeedback->appendChild($dom->createElement('text', 'Ваш ответ верный.'));
                    $question->appendChild($correctfeedback);

                    $partiallycorrectfeedback = $dom->createElement('partiallycorrectfeedback');
                    $partiallycorrectfeedback->setAttribute('format', 'html');
                    $text = $dom->createElement('text', 'Ваш ответ частично правильный.');
                    $partiallycorrectfeedback->appendChild($text);
                    $question->appendChild($partiallycorrectfeedback);

                    $incorrectfeedback = $dom->createElement('incorrectfeedback');
                    $incorrectfeedback->setAttribute('format', 'html');
                    $incorrectfeedback->appendChild($dom->createElement('text', 'Ваш ответ неправильный.'));
                    $question->appendChild($incorrectfeedback);

                    $shownumcorrect = $dom->createElement('shownumcorrect');
                    $question->appendChild($shownumcorrect);
                }

                if(in_array($examQuestion->type_id, [ExamQuestionHelper::TYPE_FILE, ExamQuestionHelper::TYPE_ANSWER_DETAILED])) {
                    $responseformat = $dom->createElement('responseformat', $examQuestion->type_id == ExamQuestionHelper::TYPE_FILE ? 'editorfilepicker': 'editor');
                    $question->appendChild($responseformat);

                    $responserequired = $dom->createElement('responserequired', '1');
                    $question->appendChild($responserequired);

                    $responsefieldlines = $dom->createElement('responsefieldlines', '20');
                    $question->appendChild($responsefieldlines);

                    $minwordlimit = $dom->createElement('minwordlimit', '0');
                    $question->appendChild($minwordlimit);

                    $maxwordlimit = $dom->createElement('maxwordlimit', '0');
                    $question->appendChild($maxwordlimit);

                    $attachmentsrequired = $dom->createElement('attachmentsrequired', '0');
                    $question->appendChild($attachmentsrequired);

                    $maxbytes = $dom->createElement('maxbytes', '0');
                    $question->appendChild($maxbytes);

                    $filetypeslist = $dom->createElement('filetypeslist');
                    $question->appendChild($filetypeslist);

                    $graderinfo = $dom->createElement('graderinfo');
                    $graderinfo->setAttribute('format', 'html');
                    $graderinfo->appendChild($dom->createElement('text'));
                    $question->appendChild($graderinfo);

                    $responsetemplate = $dom->createElement('responsetemplate');
                    $responsetemplate->setAttribute('format', 'html');
                    $responsetemplate->appendChild($dom->createElement('text'));
                    $question->appendChild($responsetemplate);
                }

                /**
                 * @var int $key
                 * @var ExamAnswer $answer
                 */
                foreach ($examQuestion->answer as $key => $answer) {
                    if ($examQuestion->type_id == ExamQuestionHelper::TYPE_SELECT_ONE) {
                        $answerXml = $dom->createElement('answer');
                        $answerXml->setAttribute('format', 'html');
                        $answerXml->setAttribute('fraction', $answer->is_correct ? 100 : 0);
                        $answerXml->appendChild($dom->createElement('text', $answer->name));
                        $feedback = $dom->createElement('text', $answer->name);
                        $feedback->setAttribute('format','html');
                        $feedback->appendChild($dom->createElement('text'));
                        $answerXml->appendChild($feedback);
                        $question->appendChild($answerXml);
                    } else {
                        $subquestion = $dom->createElement('subquestion');
                        $subquestion->setAttribute('format', 'html');
                        $subquestion->appendChild($dom->createElement('text', $answer->name));
                        $answerXml = $dom->createElement('answer');
                        $answerXml->appendChild($dom->createElement('text', $answer->answer_match));
                        $subquestion->appendChild($answerXml);
                        $question->appendChild($subquestion);
                    }
                }
                $root->appendChild($question);
            }
        }
        return $dom->save($this->getFilename());
    }

    private function setTypeName($type) {
        switch ($type) {
            case ExamQuestionHelper::TYPE_SELECT_ONE:
                return 'multichoice';
            case ExamQuestionHelper::TYPE_CLOZE:
                return 'cloze';
            case  ExamQuestionHelper::TYPE_FILE:
            case  ExamQuestionHelper::TYPE_ANSWER_DETAILED:
                return 'essay';
            default:
                return 'matching';
        }
    }

    private function getClozeTextForQuestion(ExamQuestion $examQuestion) {
        $questionNesteds = $examQuestion->questionNested;
        $text = $examQuestion->text .'<p>';
        if ($questionNesteds) {
            /** @var ExamQuestionNested $questionNested */
            foreach ($questionNesteds as $questionNested) {
                $answers = $questionNested->getAnswer()->orderBy(['is_correct' => SORT_DESC])->all();
                $textAnswer = '';
                if($answers) {
                    $textAnswer .= '{:MULTICHOICE:';
                    /** @var ExamAnswerNested $answer */
                    foreach ($answers as $answer) {
                        if($answer->is_correct) {
                            $textAnswer .= '='.$answer->name;
                        }else {
                            $textAnswer .= '~'.$answer->name;
                        }
                    }
                    $textAnswer .= '}';
                }
                if($questionNested->is_start) {
                    $text .= $textAnswer.' '.$questionNested->name.' ';
                }
                else {
                    $text .= $questionNested->name.' '.$textAnswer.' ';
                }
            }
        }
        $text .= '</p>';
        return $text;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
}