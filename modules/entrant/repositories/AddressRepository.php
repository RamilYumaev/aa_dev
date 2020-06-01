<?php


namespace modules\entrant\repositories;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\Address;

class AddressRepository
{
    public function get($id): Address
    {
        if (!$model = Address::findOne($id)) {
            throw new \DomainException('Адрес не найден.');
        }
        return $model;
    }

    public function getFilesExits($user_id): void
    {
        $addresses =Address::find()->where(['user_id' => $user_id, 'type' => [AddressHelper::TYPE_REGISTRATION, AddressHelper::TYPE_RESIDENCE]])->all();
        if($addresses) {
            foreach ($addresses as $address) {
                if ($address->files) {
                throw  new  \DomainException('Удаление невозможно, так как у вас на этого раздела 
                "Адреса регистрации и проживания" имеется файл сканирования');
                }
            }
        }
    }

    public function save(Address $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Address $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}