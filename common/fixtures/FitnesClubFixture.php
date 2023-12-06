<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class FitnesClubFixture extends ActiveFixture
{
    public $modelClass = 'common\models\fitnes\FitnesClub';
    public $dataFile = '@common/fixtures/data/fitnesClub.php';
}
