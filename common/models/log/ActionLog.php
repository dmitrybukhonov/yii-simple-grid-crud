<?php

namespace common\models\log;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $type
 * @property int $user_id
 * @property int $entity_id
 * @property string $created_at
 * @property string $entity_class
 */
class ActionLog extends ActiveRecord
{
    const ACTION_CREATE = 1;
    const ACTION_UPDATE = 2;
    const ACTION_DELETE = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%action_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['entity_id', 'entity_class', 'type', 'user_id'], 'required'],
            [['entity_id', 'type', 'user_id'], 'integer'],
            [['entity_class'], 'string'],
            [
                ['type'], 'in', 'range' => [
                    self::ACTION_CREATE,
                    self::ACTION_UPDATE,
                    self::ACTION_DELETE,
                ]
            ],
            [['created_at'], 'safe'],
        ];
    }
}
