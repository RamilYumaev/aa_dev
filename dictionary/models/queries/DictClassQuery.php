<?php


namespace dictionary\models\queries;


use dictionary\models\DictClass;

class DictClassQuery extends \yii\db\ActiveQuery
{
    /**
     * @param  $type
     * @return $this
     */
    public function typeClassAndOrderById(array  $type)
    {
        return $this->andWhere(['in', 'type', $type])->orderBy('id');
    }

}