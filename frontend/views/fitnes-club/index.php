<?php

use yii\web\View;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use frontend\models\search\FitnesClubSearch;

/**
 * @var View $this
 * @var FitnesClubSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Фитнес залы';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <?= Html::a('Create fitnes-club', ['fitnes-club/create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px;']) ?>
</div>
<?php Pjax::begin(['id' => 'fitnes-clubs-pjax']) ?>
<?= $this->render('@app/views/fitnes-club/index/_search', [
    'model' => $searchModel,
]) ?>
<?= GridView::widget([
    'id' => 'fitnes-clubs',
    'dataProvider' => $dataProvider,
    'showFooter' => true,
    'tableOptions' => ['class' => 'table table-hover table-responsive dataTable'],
    'columns' => [
        'name',
        'address',
        [
            'attribute' => 'is_published',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->is_published) {
                    return '<span class="glyphicon glyphicon-ok text-success"></span>';
                } else {
                    return '<span class="glyphicon glyphicon-remove text-danger"></span>';
                }
            },
            'contentOptions' => ['class' => 'text-center'],
        ],
        'created_at',
        'updated_at',
        [
            'class' => ActionColumn::class,
            'template' => '{view} {update} {delete}',
        ],
    ]
]) ?>
<?php Pjax::end(); ?>