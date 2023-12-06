<?php

use yii\web\View;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use common\models\client\Client;
use kartik\datetime\DateTimePicker;
use common\components\dropdown\ClientDropDown;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var Client $model
 * @var array $clubList
 */

$this->title = $model->isNewRecord ? 'Create client' : 'Update client';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'first_name') ?>
<?= $form->field($model, 'middle_name') ?>
<?= $form->field($model, 'last_name') ?>
<?= $form->field($model, 'birth_date')->widget(DateTimePicker::class, [
    'options' => ['placeholder' => 'Выберите дату и время'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd hh:ii:ss',
        'todayHighlight' => true,
        'autoclose' => true,
    ]
]) ?>
<?= $form->field($model, 'gender')->radioList(ClientDropDown::getGenderList()) ?>
<?= $form->field($model, 'club_ids')->widget(Select2::class, [
    'data' => $clubList,
    'options' => ['placeholder' => 'Выберите фитнес-клубы...', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Вернуться к списку', ['fitnes-club/index'], ['class' => 'btn btn-default']) ?>

<?php ActiveForm::end(); ?>