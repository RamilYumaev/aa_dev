<?php


namespace testing\helpers;


use testing\models\TestQuestion;
use yii\helpers\ArrayHelper;

class TestQuestionHelper
{

    public $optionsArray = [];

    const TYPE_SELECT = 1;
    const TYPE_MATCHING = 2;
    const TYPE_ANSWER_SHORT = 3;
    const TYPE_ANSWER_DETAILED = 4;
    const TYPE_FILE = 5;
    const TYPE_SELECT_ONE = 6;
    const TYPE_CLOZE = 7;

    const FILE_TYPE_IMAGE = 1;
    const FILE_TYPE_TEXT = 2;
    const FILE_TYPE_MEDIA = 3;

    const YES_ANSWER = 1;
    const NO_ANSWEW  = 0;

    const CLOZE_TEXT = 2;
    const CLOZE_SELECT = 1;

    const FILE_VALIDATE_RULES = [
        self::FILE_TYPE_IMAGE => [
            'extensions' => ['bmp', 'jpg', 'png', 'pdf', 'tif', 'gif'],
            'maxSize' => 50 * 1024 * 1024,
        ],
        self::FILE_TYPE_TEXT => [
            'extensions' => ['doc', 'docx', 'pdf', 'txt', 'rtf'],
            'maxSize' => 10 * 1024 * 1024,
        ],
        self::FILE_TYPE_MEDIA => [
            'extensions' => ['docx', 'ppt', 'pptx', 'pptm', 'mp3', 'wav', 'mpeg', 'avi'],
            'maxSize' => 50 * 1024 * 1024,
        ],
    ];

    public static function getAllTypes()
    {
        return [
            self::TYPE_SELECT => 'Выбрать вариант(ы)',
            self::TYPE_SELECT_ONE => 'Выбрать вариант',
            self::TYPE_MATCHING => 'Сопоставить',
            self::TYPE_ANSWER_SHORT => 'Краткий ответ',
            self::TYPE_ANSWER_DETAILED => 'Развернутый ответ',
            self::TYPE_FILE => 'Загрузка файла',
            self::TYPE_CLOZE => 'Вложенные ответы',
        ];
    }

    public static function getAllFileTypes()
    {
        return [
            self::FILE_TYPE_IMAGE => 'Изображение',
            self::FILE_TYPE_TEXT => 'Текст',
            self::FILE_TYPE_MEDIA => 'Мультимедиа',
        ];
    }

    public static function getAllTypeCloze()
    {
        return [
            self::CLOZE_SELECT => 'Список',
            self::CLOZE_TEXT => 'Краткий ответ',
        ];
    }

    public static function getAllStatusAnswer()
    {
        return [
            self::NO_ANSWEW => 'Нет',
            self::YES_ANSWER => 'Да',
        ];
    }

    public static function allTypesVlid()
    {
        return [
            self::TYPE_SELECT,
            self::TYPE_SELECT_ONE,
            self::TYPE_MATCHING,
            self::TYPE_ANSWER_SHORT,
            self::TYPE_ANSWER_DETAILED,
            self::TYPE_FILE,
            self::TYPE_CLOZE
        ];
    }

    public static function allFileTypesValid()
    {
        return [
            self::FILE_TYPE_IMAGE,
            self::FILE_TYPE_TEXT,
            self::FILE_TYPE_MEDIA,
        ];
    }

    public static function fileTypeName($key)
    {
        return ArrayHelper::getValue(self::getAllFileTypes(), $key);
    }

    public static function typeName($key)
    {
        return ArrayHelper::getValue(self::getAllTypes(), $key);
    }

    public static function questionGroupCount ($id)
    {
        return TestQuestion::find()->where(['group_id' => $id])->count();
    }

    public static function questionList($id)
    {
        return ArrayHelper::map(TestQuestion::find()->where(['group_id' => $id])->all(), 'id', 'title');
    }

    public static function questionTypeList()
    {
        return ArrayHelper::map(TestQuestion::find()->all(), 'id', 'type_id');
    }

    public static function questionTypeFileList()
    {
        return ArrayHelper::map(TestQuestion::find()->all(), 'id', 'file_type_id');
    }

    public static function questionType($id)
    {
        return ArrayHelper::getValue(self::questionTypeList(), $id);
    }

    public static function questionTypeFile($id)
    {
        return ArrayHelper::getValue(self::questionTypeFileList(), $id);
    }

    public static function questionTextList()
    {
        return ArrayHelper::map(TestQuestion::find()->all(), 'id', 'text');
    }


    public static function questionTextName($id): ?string
    {
        return ArrayHelper::getValue(self::questionTextList(), $id);
    }


    public static function questionOlympicList($id)
    {
        return ArrayHelper::map(TestQuestion::find()->where(['olympic_id' => $id, 'group_id' => null])->all(), 'id', 'title');
    }

}