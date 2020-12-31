<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TaskType
/* @var $this yii\web\View */
/* @var $model app\models\TaskType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')
     ->dropDownList(
            ArrayHelper::map(TaskType::find()->asArray()->all(), 'parent_id', 'title')
            )
?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
