<?php

namespace common\components\dropdown;

use common\models\client\Client;

final class ClientDropDown
{
    /**
     * @inheritDoc
     */
    public static function getGenderList(): array
    {
        return [
            Client::GENDER_MAN => 'Мужчина',
            Client::GENDER_WOMAN => 'Женщина',
        ];
    }
}
