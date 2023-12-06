<?php

namespace common\components\dropdown;

use common\models\fitnes\FitnesClub;

final class FitnesClubDropDown
{
    /**
     * @inheritDoc
     */
    public static function getClubList(): array
    {
        return FitnesClub::find()
            ->select('name')
            ->published()
            ->indexBy('id')
            ->column();
    }
}
