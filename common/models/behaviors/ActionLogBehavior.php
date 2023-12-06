<?php

namespace common\models\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\log\ActionLog;

class ActionLogBehavior extends Behavior
{
    /**
     * @inheritDoc
     */
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'logAction',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'logAction',
            ActiveRecord::EVENT_BEFORE_DELETE => 'logAction',
        ];
    }

    /**
     * @inheritDoc
     */
    public function logAction($event): void
    {
        $actionLog = new ActionLog();
        $actionLog->entity_id = $this->owner->id;
        $actionLog->entity_class = get_class($this->owner);
        $actionLog->user_id = Yii::$app->user->id;
        $actionLog->created_at = date('Y-m-d H:i:s');

        switch ($event->name) {
            case ActiveRecord::EVENT_AFTER_INSERT:
                $actionLog->type = ActionLog::ACTION_CREATE;
                break;
            case ActiveRecord::EVENT_BEFORE_UPDATE:
                $actionLog->type = ActionLog::ACTION_UPDATE;
                break;
            case ActiveRecord::EVENT_BEFORE_DELETE:
                $actionLog->type = ActionLog::ACTION_DELETE;
                break;
        }

        $actionLog->save(false);
    }
}
