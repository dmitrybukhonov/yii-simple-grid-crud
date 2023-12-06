<?php

use yii\web\View;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use common\models\log\ActionLog;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'User action logs';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= GridView::widget([
    'id' => 'action_log',
    'dataProvider' => $dataProvider,
    'showFooter' => true,
    'tableOptions' => ['class' => 'table table-hover table-responsive dataTable'],
    'columns' => [
        'entity_id',
        'entity_class',
        'user_id',
        [
            'label' => 'Target action',
            'value' => function (ActionLog $model) {
                $action = '';
                switch ($model->type) {
                    case ActionLog::ACTION_CREATE:
                        $action = 'Create';
                        break;
                    case ActionLog::ACTION_UPDATE:
                        $action = 'Update';
                        break;
                    case ActionLog::ACTION_DELETE:
                        $action = 'Delete';
                        break;
                }
                return $action;
            },
        ],
        'created_at',
        [
            'class' => ActionColumn::class,
            'template' => '{view} {update} {delete}',
        ],
    ]
]) ?>
