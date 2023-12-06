<?php

use yii\web\View;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use frontend\models\search\FitnesClubSearch;

/** 
 * @var View $this
 * @var ActiveForm $form
 * @var FitnesClubSearch $model
 */

$this->registerJs('
 $("document.body").ready(function(){ 
     $("#seach_form").on("pjax:end", function() {
         $.pjax.reload({container:"#fitnes-clubs-pjax"});
     });
 });
');

?>
<?php Pjax::begin(['id' => 'seach_form']) ?>
<?php $form = ActiveForm::begin([
    'method' => 'GET',
    'action' => ['fitnes-club/index'],
    'options' => ['data-pjax' => true]
]) ?>

<div class="form-row">
    <div class="col-md-2">
        <?= $form->field($model, 'created_range')->widget(DateRangePicker::class, [
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y-m-d',
                    'cancelLabel' => 'Очистить',
                ],
            ],
            'pluginEvents' => [
                'cancel.daterangepicker' => "function(ev, picker) {
                    picker.element.val('').trigger('change');
                }",
            ],
        ]) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'name') ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'is_archive')->checkbox() ?>
    </div>
</div>

<?= Html::submitButton('Фильтровать', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Очистить фильтры', Url::to(['fitnes-club/index']), ['class' => 'btn btn-default']) ?>

<?php ActiveForm::end(); ?>
<?php Pjax::end() ?>