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
        ];

    }
}

