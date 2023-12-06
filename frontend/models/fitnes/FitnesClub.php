<?php

namespace frontend\models\fitnes;

use common\models\fitnes\FitnesClub as FitnesClubCommon;

class FitnesClub extends FitnesClubCommon
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Name',
            'address' => 'Address',
        ];
    }
}
