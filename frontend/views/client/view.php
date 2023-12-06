<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\client\Client;

/**
 * @var yii\web\View $this
 * @var common\models\client\Client $client
 */

$this->title = $client->first_name . ' ' . $client->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="client-view">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    <?= DetailView::widget([
        'model' => $client,
        'attributes' => [
            'id',
            'first_name',
            'middle_name',
            'last_name',
            [
                'attribute' => 'gender',
                'value' => function ($client) {
                    return ($client->gender === Client::GENDER_MAN) ? 'Мужчина' : 'Женщина';
                }
            ],
            [
                'attribute' => 'is_deleted',
                'value' => function ($client) {
                    return $client->is_deleted ? 'Да' : 'Нет';
                }
            ],
            'birth_date',
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>