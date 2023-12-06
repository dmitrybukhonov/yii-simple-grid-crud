<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\fitnes\FitnesClub $fitnesClub
 */

$this->title = $fitnesClub->name;
$this->params['breadcrumbs'][] = ['label' => 'Фитнес залы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>
    <?= Html::encode($this->title) ?>
</h1>
<?= DetailView::widget([
    'model' => $fitnesClub,
    'attributes' => [
        'id',
        'address',
        [
            'attribute' => 'is_published',
            'value' => function ($client) {
                return $client->is_published ? 'Да' : 'Нет';
            }
        ],
        [
            'attribute' => 'is_deleted',
            'value' => function ($client) {
                return $client->is_deleted ? 'Да' : 'Нет';
            }
        ],
        'created_at',
        'updated_at',
    ],
]) ?>