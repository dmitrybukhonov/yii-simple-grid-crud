<?php

namespace common\models\client;

use yii\db\ActiveQuery;
use common\models\ActiveRecord;
use common\models\fitnes\FitnesClub;
use common\models\query\ClientQuery;
use common\models\fitnes\FitnesClubClient;
use common\models\behaviors\ActionLogBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property int|null $gender
 * @property bool $is_deleted
 * @property string|null $birth_date
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property FitnesClubClient[] $fitnesClubClients
 * @property FitnesClub[] $fitnesClubs
 */
class Client extends ActiveRecord
{
    const GENDER_MAN = 0;
    const GENDER_WOMAN = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%client}}';
    }

    /**
     * @inheritdoc
     */
    public static function find(): ClientQuery
    {
        $query = new ClientQuery(static::class);
        $query->notDeleted();

        return $query;
    }

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
            [['first_name'], 'required'],
            [['is_deleted'], 'boolean'],
            [['first_name'], 'string', 'max' => 255],
            [['middle_name', 'last_name'], 'string'],
            [['birth_date', 'created_at', 'updated_at', 'club_ids'], 'safe'],
            [['gender'], 'in', 'range' => [self::GENDER_MAN, self::GENDER_WOMAN]],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFitnesClubClients(): ActiveQuery
    {
        return $this->hasMany(FitnesClubClient::class, ['client_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFitnesClubs(): ActiveQuery
    {
        return $this->hasMany(FitnesClub::class, ['id' => 'fitnes_club_id'])->via('fitnesClubClients');
    }
}
