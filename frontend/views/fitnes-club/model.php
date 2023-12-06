<?php

use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 */

$this->title = $model->isNewRecord ? 'Cоздание фитнес-клуба' : 'Редактирование фитнес-клуба';
$this->params['breadcrumbs'][] = ['label' => 'Фитнес залы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'address')->textarea() ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Вернуться к списку', ['fitnes-club/index'], ['class' => 'btn btn-default']) ?>

<?php ActiveForm::end(); ?>