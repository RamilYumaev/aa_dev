<?php


namespace tests\helpers;


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

    const FILE_TYPE_IMAGE = 1;
    const FILE_TYPE_TEXT = 2;
    const FILE_TYPE_MEDIA = 3;

    const FILE_VALIDATE_RULES = [
        self::FILE_TYPE_IMAGE => [
            'extensions' => 'bmp, jpg, png, pdf, tif, gif',
            'maxSize' => 50 * 1024 * 1024,
        ],
        self::FILE_TYPE_TEXT => [
            'extensions' => 'doc, docx, pdf, txt, rtf',
            'maxSize' => 10 * 1024 * 1024,
        ],
        self::FILE_TYPE_MEDIA => [
            'extensions' => 'docx, ppt, pptx, pptm, mp3, wav, mpeg, avi',
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

    public static function allTypesVlid()
    {
        return [
            self::TYPE_SELECT,
            self::TYPE_SELECT_ONE,
            self::TYPE_MATCHING,
            self::TYPE_ANSWER_SHORT,
            self::TYPE_ANSWER_DETAILED,
            self::TYPE_FILE,
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
}