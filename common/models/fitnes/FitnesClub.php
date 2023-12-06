<?php

namespace common\models\fitnes;

use yii\db\ActiveQuery;
use common\models\ActiveRecord;
use common\models\client\Client;
use common\models\query\FitnesClubQuery;
use common\models\behaviors\ActionLogBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property bool $is_published
 * @property bool $is_deleted
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property FitnesClubClient[] $fitnesClubClients
 * @property Client[] $clients
 */
class FitnesClub extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%fitnes_club}}';
    }

    /**
     * @inheritdoc
     */
    public static function find(): FitnesClubQuery
    {
        $query = new FitnesClubQuery(static::class);
        $query->notDeleted();

        return $query;
    }

    /**
     * @return array
     */
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'actionLogBehavior' => [
                'class' => ActionLogBehavior::class,
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'is_deleted' => parent::IS_DELETED,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['address'], 'string'],
            [['is_published', 'is_deleted'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFitnesClubClients(): ActiveQuery
    {
        return $this->hasMany(FitnesClubClient::class, ['fitnes_club_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getClients(): ActiveQuery
    {
        return $this->hasMany(Client::class, ['id' => 'client_id'])->via('fitnesClubClients');
    }
}
