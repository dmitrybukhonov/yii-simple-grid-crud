<?php

use yii\web\View;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use frontend\models\search\ClientSearch;

/**
 * @var View $this
 * @var ClientSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <?= Html::a('Create client', ['client/create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px;']) ?>
</div>
<?php Pjax::begin(['id' => 'client-pjax']) ?>
<?= $this->render('@app/views/client/index/_search', [
    'model' => $searchModel,
]) ?>
<?= GridView::widget([
    'id' => 'client',
    'dataProvider' => $dataProvider,
    'showFooter' => true,
    'tableOptions' => ['class' => 'table table-hover table-responsive dataTable'],
    'columns' => [
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'created_at',
        [
            'label' => 'Фитнес-клубы',
            'value' => function (ClientSearch $model) {
                $clubs = [];
                foreach ($model->fitnesClubs as $club) {
                    $clubs[] = $club->name;
                }
                return implode(', ', $clubs);
            },
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{view} {update} {delete}',
        ],
    ]
]) ?>
<?php Pjax::end(); ?>