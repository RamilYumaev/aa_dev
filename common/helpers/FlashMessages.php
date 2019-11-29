<?php

namespace common\helpers;


class FlashMessages
{

    public static function get()
    {

        return [
            "olympicNotFound" => "Олимпиада не найдена",
            "successRegistration" => "Спасибо за регистрацию. 
                Вам отправлено письмо. Для активации учетной записи, пожалуйста, следуйте инструкциям в письме.",
            "successDodRegistrationInsideCabinet"=> "Спасибо за регистрацию.",
            "noFoundRegistrationOnDod" => "Регистрация на День открытых дверей не найдена.",
            "noFoundRegistrationOnOlympic" => "Регистрация на олимпиаду не найдена.",
            "notFoundHttpException" => "Страница не найдена.",
            "saveError"=> "Ошибка при сохранении объекта.",
            "deleteError"=> "Ошибка при удалении объекта.",
        ];

    }
}

