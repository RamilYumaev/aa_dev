<?php
namespace modules\entrant\modules\ones_2024\model;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $quid_statement
 * @property string $quid_cg
 * @property string $quid_profile
 * @property string $quid_cg_competitive
 * @property string $priority_vuz
 * @property string $priority_ss
 * @property string $actual
 * @property string $source
 * @property string $datetime
 * @property string $status
 * @property boolean $is_el_original
 * @property boolean $is_paper_original
 *
 * @property-read EntrantSS $entrant
 */

class EntrantCgAppSS extends ActiveRecord
{
    public $check;

    public static function tableName(): string
    {
        return '{{%entrant_cg_app_2024_ss}}';
    }

    public function rules(): array
    {
        return [
            [[
                'quid_statement',
                'quid_cg',
                'quid_profile',
                'quid_cg_competitive',
                'priority_vuz',
                'priority_ss',
                'actual',
                'source',
                'status',
                'is_el_original',
                'is_paper_original',
                ], 'safe',
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'quid_statement' => 'ID заявления',
            'quid_cg' => 'ID конурса',
            'quid_profile' => "ID абитуриента",
            'quid_cg_competitive' => 'ID КГ',
            'priority_vuz' => 'Приоритет Вуза',
            'priority_ss' => 'Приоритет Суперсервиса',
            'actual' => "Актуальность",
            'source' => 'Источник',
            'status' => 'Статус',
            'is_el_original' => 'Электронный оригинал',
            'is_paper_original' => 'Бумажный оригинал',
        ];
    }

    public function getCg() {
        return $this->hasOne(CgSS::class,['quid' => 'quid_cg_competitive']);
    }

    public function getEntrant() {
        return $this->hasOne(EntrantSS::class,[ 'quid' => 'quid_profile' ]);
    }
}
