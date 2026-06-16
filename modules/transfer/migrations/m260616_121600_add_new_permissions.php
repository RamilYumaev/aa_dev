<?php

namespace modules\transfer\migrations;
use \yii\db\Migration;

class m260616_121600_add_new_permissions extends Migration
{

    public function safeUp()
    {
        $this->insert(
            '{{%auth_item}}',
            [
                'name' => 'deleteTransferFile',
                'type' => 2, // 2 = permission
                'description' => 'Удаление файлов ПиВ',
                'rule_name' => null,
                'data' => null,
                'created_at' => time(),
                'updated_at' => time(),
            ]
        );

        $this->insert(
            '{{%auth_item}}',
            [
                'name' => 'deleteTransferStatement',
                'type' => 2, // 2 = permission
                'description' => 'Удаление заявление ПиВ',
                'rule_name' => null,
                'data' => null,
                'created_at' => time(),
                'updated_at' => time(),
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('{{%auth_item}}', ['name' => 'permission1']);
        $this->delete('{{%auth_item}}', ['name' => 'permission2']);
    }
}
