<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use common\models\fitnes\FitnesClub;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

class FitnesClubQuery extends ActiveQuery
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'softDelete' => [
                'class' => SoftDeleteQueryBehavior::class,
                'deletedCondition' => [
                    'is_deleted' => FitnesClub::IS_DELETED,
                ],
                'notDeletedCondition' => [
                    'is_deleted' => FitnesClub::IS_NOT_DELETED,
                ]
            ],
        ];
    }

    /**
     * @return FitnesClubQuery
     */
    public function published(): FitnesClubQuery
    {
        return $this->andWhere(['fitnes_club.is_published' => FitnesClub::IS_PUBLISHED]);
    }
}
