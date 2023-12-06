<?php

namespace common\models\fitnes;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use common\models\client\Client;

/**
 * @property int $id
 * @property int $fitnes_club_id
 * @property int $client_id
 * @property string $created_at
 *
 * @property FitnesClub $fitnesClub
 * @property Client $client
 */
class FitnesClubClient extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%fitnes_club_client}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fitnes_club_id', 'client_id'], 'required'],
            [['fitnes_club_id', 'client_id'], 'integer'],
            [['created_at'], 'safe'],
            [['fitnes_club_id'], 'exist', 'skipOnError' => true, 'targetClass' => FitnesClub::class, 'targetAttribute' => ['fitnes_club_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFitnesClub(): ActiveQuery
    {
        return $this->hasOne(FitnesClub::class, ['id' => 'fitnes_club_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }
}
