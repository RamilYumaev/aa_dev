<?php


namespace testing\models;


use yii\db\ActiveRecord;

class TestResult extends ActiveRecord
{
    const ANSWER_FILES_PATH = '@webroot/uploads/answer_files';
    const ANSWER_FILES_PATH_WEB = '@web/uploads/answer_files';
    const FILES_SALT = 'FJurfd4875645fsFrr';

    public $resultArray = [];
    /** @var \yii\web\UploadedFile */
    public $resultFile;

    public static function tableName()
    {
        return 'test_result';
    }

    public function rules()
    {
        return [
            [['attempt_id', 'question_id'], 'required'],
            [['attempt_id', 'question_id'], 'integer'],
            ['mark', 'number'],
            [['result'], 'string'],
            [['attempt_id', 'question_id'], 'unique', 'targetAttribute' => ['attempt_id', 'question_id']],

            ['resultArray', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'attempt_id' => 'Попытка',
            'question_id' => 'Вопрос',
            'updated' => 'Обновление',
            'result' => 'Результат',
            'mark' => 'Оценка',

            'resultFile' => 'Файл с ответом',
        ];
    }

    public function afterFind()
    {
        $this->resultArray = $this->result ? \json_decode($this->result, true) : [];

        parent::afterFind();
    }

    public function beforeValidate()
    {
        if (!$this->isNewRecord) {
            if ($this->question->type_id == TestQuestion::TYPE_FILE) {
                $this->validators[] =
                    Validator::createValidator(
                        'file',
                        $this,
                        'resultFile',
                        TestQuestion::FILE_VALIDATE_RULES[$this->question->file_type_id]
                    );
                $this->validators[] =
                    Validator::createValidator(
                        'required',
                        $this,
                        'resultFile'
                    );
            }

            if (\count($this->resultArray) !== 0 && $this->question->type_id == TestQuestion::TYPE_MATCHING) {
                $result = [];
                foreach ($this->resultArray as $optionText) {
                    $result[] = \array_search($optionText, $this->question->optionsArray['option']);
                }
                if (\count($result) !== 0) {
                    $this->resultArray = $result;
                }
            }
        }

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->result = \json_encode($this->resultArray);

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            if ($this->question->type_id == TestQuestion::TYPE_FILE) {
                $oldFileName = $this->getResultFileName();
                if ($oldFileName !== null) {
                    \unlink($oldFileName);
                }

                if ($this->resultFile !== null) {
                    $this->resultFile->saveAs($this->generateFileName() . '.' . $this->resultFile->extension);
                }
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function getResultFileName()
    {
        return \glob($this->generateFileName() . '.*')[0] ?? null;
    }

    public function afterDelete()
    {
        $fileName = $this->getResultFileName();
        if ($fileName !== null) {
            @\unlink($fileName);
        }

        parent::afterDelete();
    }

    protected function generateFileName()
    {
        return Yii::getAlias(self::ANSWER_FILES_PATH) . DIRECTORY_SEPARATOR .
            \md5(self::FILES_SALT . '_' . $this->attempt_id . '_' . $this->question_id);
    }

    public function getAttempt()
    {
        return $this->hasOne(TestAttempt::className(), ['id' => 'attempt_id']);
    }

    public function getQuestion()
    {
        return $this->hasOne(TestQuestion::className(), ['id' => 'question_id']);
    }

}