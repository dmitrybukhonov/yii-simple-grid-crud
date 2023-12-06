<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use common\models\client\Client;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

class ClientQuery extends ActiveQuery
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
                    'is_deleted' => Client::IS_DELETED,
                ],
                'notDeletedCondition' => [
                    'is_deleted' => Client::IS_NOT_DELETED,
                ]
            ],
        ];
    }
}
