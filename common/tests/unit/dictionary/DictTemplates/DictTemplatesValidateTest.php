<?php

namespace common\tests\unit\dictionary\DictTemplates;

use dictionary\forms\TemplatesCreateForm;
use dictionary\models\Templates;

class DictTemplatesValidateTest extends \Codeception\Test\Unit
{
    public function testValidateEmpty()
    {
        $model = new TemplatesCreateForm();
        $model->type_id = "";
        $model->name = "";
        $model->text = "";
        $model->name_for_user = "";
        $this->assertFalse($model->validate());
    }

    public function testValidateSuccess()
    {
        $model = new TemplatesCreateForm();
        $model->type_id = 1;
        $model->name = "Тестовый шаблон";
        $model->text = "Большой текст ";
        $model->name_for_user = "Тестовый шаблон вид для пользователей";
        $this->assertTrue($model->validate());
    }

    public function testValidateErrorType()
    {
        $model = new TemplatesCreateForm();
        $model->type_id = "";
        $model->name = "Тестовый шаблон";
        $model->text = "Большой текст ";
        $model->name_for_user = "Тестовый шаблон вид для пользователей";
        $this->assertFalse($model->validate());
    }

    public function testValidateErrorName()
    {
        $model = new TemplatesCreateForm();
        $model->type_id = 1;
        $model->name = "";
        $model->text = "Большой текст ";
        $model->name_for_user = "Тестовый шаблон вид для пользователей";
        $this->assertFalse($model->validate());
    }

    public function testValidateErrorText()
    {
        $model = new TemplatesCreateForm();
        $model->type_id = 1;
        $model->name = "Тестовый шаблон";
        $model->text = "";
        $model->name_for_user = "Тестовый шаблон вид для пользователей";
        $this->assertFalse($model->validate());
    }

    public function testValidateErrorNameForUser()
    {
        $model = new TemplatesCreateForm();
        $model->type_id = 1;
        $model->name = "Тестовый шаблон";
        $model->text = "Большой текст ";
        $model->name_for_user = "";
        $this->assertFalse($model->validate());
    }
}