<?php


namespace testing\models;


use tests\helpers\TestQuestionHelper;
use yii\db\ActiveRecord;

class TestAttempt extends ActiveRecord
{
    const GOLD = 1;
    const SILVER = 2;
    const BRONZE = 3;
    const MEMBER = 4;

    public static function tableName()
    {
        return 'test_attempt';
    }

    public function rules()
    {
        return [
            [['user_id', 'test_id'], 'required'],
            [['user_id', 'test_id', 'status_id'], 'integer'],
            [['start', 'end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['user_id', 'test_id'], 'unique', 'targetAttribute' => ['user_id', 'test_id']],
            ['mark', 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'start' => 'Начало',
            'end' => 'Окончание',
            'test_id' => 'Тест',
            'mark' => 'Результат',
        ];
    }

    /**
     * Пересчитываем результат.
     *
     * @return double|null
     */
    public function evulate()
    {
        if (TestResult::find()
            ->joinWith(['question'], false)
            ->andWhere(['attempt_id' => $this->id])
            ->andWhere(['in', TestQuestion::tableName() . '.type_id', [
                TestQuestionHelper::TYPE_ANSWER_DETAILED,
                TestQuestionHelper::TYPE_FILE,
            ]])
            ->andWhere([TestResult::tableName() . '.mark' => null])
            ->exists()
        ) {
            return null;
        }

        $markSum = 0;
        foreach ($this->results as $currentResult) {
            $question = $currentResult->question;
            if ($currentResult->mark) {
                $markSum += $currentResult->mark;
                continue;
            }
            if (empty($currentResult->resultArray)) {
                continue;
            }

            switch ($question->type_id) {
                case TestQuestionHelper::TYPE_SELECT:
                    $mark = 0;
                    $correctCount = 0;
                    $correctIndexes = [];
                    foreach ($question->optionsArray['isCorrect'] as $index) {
                        $correctIndexes[] = $index;
                        ++$correctCount;
                    }

                    if ($correctCount === 0) {
                        continue 2;
                    }
                    $markPerVariant = $question->mark / $correctCount;

                    foreach ($currentResult->resultArray as $currentResultIndex) {
                        if (\in_array($currentResultIndex, $correctIndexes)) {
                            $mark += $markPerVariant;
                        } else {
                            $mark -= $markPerVariant;
                        }
                    }

                    $mark = \round($mark, 2);
                    if ($mark < 0) {
                        $mark = 0;
                    }
                    $markSum += $mark;
                    break;

                case TestQuestionHelper::TYPE_MATCHING:
                    if (!empty($currentResult->resultArray)) {
                        $mark = 0;
                        $markPerVariant = $question->mark / \count($currentResult->resultArray);
                        foreach ($currentResult->resultArray as $index => $value) {
                            if ($index == $value) {
                                $mark += $markPerVariant;
                            } else {
                                $mark -= $markPerVariant;
                            }
                        }

                        $mark = \round($mark, 2);
                        if ($mark < 0) {
                            $mark = 0;
                        }
                        $markSum += $mark;
                    }
                    break;

                case TestQuestionHelper::TYPE_ANSWER_SHORT:
                    $resultText = \mb_strtolower(\trim($currentResult->resultArray[0]), 'UTF-8');
                    if (\in_array($resultText, $question->optionsArray)) {
                        $markSum += $question->mark;
                    }
                    break;

                case TestQuestionHelper::TYPE_SELECT_ONE:
                    if (!empty($currentResult->resultArray) &&
                        $currentResult->resultArray[0] == $question->optionsArray['isCorrect'][0]
                    ) {
                        $markSum += $question->mark;
                    }
                    break;
            }

            //  echo $markSum . '<br/>';
        }

        if ($this->mark === null) {
            $testMaxMark = $this->getQuestions()->sum('mark');
            $markSum = ($testMaxMark ? \round($markSum / $testMaxMark * 100, 2) : null);
            $this->mark = $markSum;
            $this->save();
        }


        return $markSum;
    }

    /**
     * Количество вопросов в попытке.
     *
     * @return int
     */
    public function getQuestionsCount()
    {
        return TestResult::find()
            ->andWhere(['attempt_id' => $this->id])
            ->count();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    public function getOlimpic()
    {
        return $this->hasOne(Olimpic::className(), ['id' => 'olimpic_id'])->via('test');
    }

    public function getResults()
    {
        return $this->hasMany(TestResult::className(), ['attempt_id' => 'id']);
    }

    public function getQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['id' => 'question_id'])
            ->viaTable(TestResult::tableName(), ['attempt_id' => 'id']);
    }

//    public static function nextQuestion($questionId, $testId)
//    {
//        $model = TestQuestion::find()->andWhere(['test_id' => $testId])->all();
//        $needMarker = 0;
//        $end = count($model) - 1;
//        foreach ($model as $key => $next) {
//            if ($next->id == $questionId && $end !== $key) {
//                $needMarker = $key + 1;
//            }
//        }
//        if ($model[$needMarker]) {
//            return $model[$needMarker]->id;
//        }
//
//    }


    public static function isLastQuestion($attemptId)
    {
        $model = TestResult::find()
            ->andWhere(['attempt_id' => $attemptId])
            ->orderBy(['question_id' => SORT_DESC])
            ->limit(1)
            ->one();

        return $model->question_id;
    }

    public static function nextQuestion($questionId, $attemptId)
    {
        $model = TestResult::find()->andWhere(['attempt_id' => $attemptId])->all();

        $needMarker = 0;
        $end = count($model) - 1;

        foreach ($model as $key => $next) {
            if ($next->question_id == $questionId && $end !== $key) {
                $needMarker = $key + 1;
            }
        }

        if ($model[$needMarker]) {

            return $model[$needMarker]->question_id;
        }

    }

    public static function prevQuestion($questionId, $attemptId)
    {
        $model = TestResult::find()->andWhere(['attempt_id' => $attemptId])->all();
        $needMarker = 0;
        foreach ($model as $key => $next) {
            if ($next->question_id == $questionId && $key !== 0) {
                $needMarker = $key - 1;
            }
        }
        if ($model[$needMarker]) {
            return $model[$needMarker]->question_id;
        }
    }

    public static function isActualOlimpiad($testId)
    {
        return Olimpic::find()
            ->andWhere(['id' => Test::find()
                ->select('olimpic_id')
                ->andWhere(['id' => $testId])
                ->column()])->andWhere(['>=', 'date_time_finish_reg', date('Y-m-d H:i:s')])->exists();

    }

    public function getSchool()
    {
        return $this->hasOne(UserSchool::className(), ['user_id' => 'user_id']);
    }

}