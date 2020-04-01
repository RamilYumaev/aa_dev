<?php


namespace dictionary\models;


use dictionary\forms\DictDisciplineCreateForm;
use dictionary\forms\DictDisciplineEditForm;
use modules\dictionary\helpers\DictCseSubjectHelper;
use modules\entrant\helpers\CseSubjectHelper;

class DictDiscipline extends \yii\db\ActiveRecord
{

    const DVI_STATUS = 1;
    const COMPOSITE_DISCIPLINE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_discipline';
    }

    public static function create(DictDisciplineCreateForm $form)
    {
        $discipline = new static();
        $discipline->name = $form->name;
        $discipline->links = $form->links;
        $discipline->cse_subject_id = $form->cse_subject_id;
        $discipline->ais_id = $form->ais_id;
        $discipline->dvi = $form->dvi;
        $discipline->composite_discipline = $form->composite_discipline;
        return $discipline;
    }

    public function edit(DictDisciplineEditForm $form)
    {
        $this->name = $form->name;
        $this->links = $form->links;
        $this->cse_subject_id = $form->cse_subject_id;
        $this->ais_id = $form->ais_id;
        $this->dvi = $form->dvi;
        $this->composite_discipline = $form->composite_discipline;
    }

    public function getCseSubject()
    {
        return DictCseSubjectHelper::name($this->cse_subject_id);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название дисциплины',
            'links' => 'Ссылка на сайте',
            'cse_subject_id' => "Предмет ЕГЭ",
            'ais_id' => "ID АИС ВУЗ",
            'dvi' => "Дополнительное вступительное испытание бакалавриата",
            'composite_discipline' => "Составная дисциплина",
        ];
    }

    public static function labels(): array
    {
        $discipline = new static();
        return $discipline->attributeLabels();
    }

    public static function aisToSdoConverter($key)
    {
        $model = self::find()->andWhere(['ais_id' => $key])->one();

        if ($model !== null) {
            return $model->id;
        }

        throw new \DomainException("Не найдена дисциплина " . $key);

    }

    public static function cseToDisciplineConverter(array $cseId): array
    {
        return self::find()->select("id")->andWhere(['in', 'cse_subject_id', $cseId])->column();
    }

    public static function dviDiscipline(): array
    {
        return self::find()->select("id")
            ->andWhere(['dvi' => self::DVI_STATUS])
            ->column();
    }

    public static function compositeDiscipline()
    {
        $model = self::find()
            ->select("id")
            ->andWhere(["composite_discipline" => self::COMPOSITE_DISCIPLINE])
            ->column();

        return $model;
    }

    public static function finalUserSubjectArray($userArray)
    {
        $dviArray = DictDiscipline::dviDiscipline();
        $unionArray = array_merge($userArray, $dviArray);

        $foreignLanguage = DictDiscipline::cseToDisciplineConverter(DictCseSubjectHelper::foreignLanguagesIdArray());
        if (array_uintersect($foreignLanguage, $userArray, "strcasecmp")) {
            return array_merge($unionArray, DictDiscipline::compositeDiscipline());
        }

        return $unionArray;
    }


}