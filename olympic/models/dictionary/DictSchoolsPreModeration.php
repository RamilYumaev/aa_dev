<?php


namespace olympic\models\dictionary;


use olympic\forms\dictionary\DictSchoolsPreModerationForm;

class DictSchoolsPreModeration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_schools_pre_moderation';
    }

    public static function create(DictSchoolsPreModerationForm $form)
    {
        $preModeration = new static();

        $preModeration->name = $form->name;
        $preModeration->dict_school_id = $form->dict_school_id;
        $preModeration->country_id = $form->country_id;
        $preModeration->region_id = $form->region_id;

        return $preModeration;
    }

    public function edit(DictSchoolsPreModerationForm $form)
    {
        $this->name = $form->name;
        $this->dict_school_id = $form->dict_school_id;
        $this->country_id = $form->country_id;
        $this->region_id = $form->region_id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название учебной организации',
            'country_id' => 'Страна',
            'region_id' => 'Регион',
        ];
    }

    public static function labels()
    {
        $preModeration = new static();
        return $preModeration->attributeLabels();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictSchool()
    {
        return $this->hasOne(DictSchools::className(), ['id' => 'dict_school_id']);
    }

    public static function getAllSchool()
    {
        $country = DictCountry::find()->indexBy('id')->orderBy(['cis' => SORT_DESC])->column();
        $region = DictRegion::find()->select('name')->indexBy('id')->column();
        $school = ArrayHelper::map(DictSchoolsPreModeration::find()
            ->orderBy(['id' => SORT_ASC, 'name' => SORT_ASC])
            ->groupBy('name')
            ->all(), 'id',
            function ($model) use ($region, $country) {
                if ($model->dict_school_id === null) {
                    $result = $model->name;
                    $result .= ', ';

                    if ($model->region_id) {
                        $result .= $region[$model->region_id];
                    } else {
                        $result .= $country[$model->country_id];
                    };
                    $result .= ' (название проверяется)';

                    return $result;

                } else {

                    $result = $model->name;
                    $result .= ', ';

                    if ($model->region_id) {
                        $result .= $region[$model->region_id];
                    } else {
                        $result .= $country[$model->country_id];
                    };

                    return $result;

                }


            });
        return $school;
    }

}