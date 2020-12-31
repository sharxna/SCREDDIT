<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaire */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="questionnaire-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
       
    </p>
         <?php $form = ActiveForm::begin(); ?>
					<?php
						foreach($selectedQuestionnaireDataProvider->getModels() as $index => $questionnaireModel)
						{
							echo $form->field($questionnaireModel, "[$index]id")->hiddenInput()->label(false);
							echo $form->field($questionnaireModel, "[$index]answer")->textInput(['maxlength' => true])->label($questionnaireModel->questionnaire->title);
							echo $form->field($questionnaireModel, "[$index]id_answer")->hiddenInput()->label(false);
							echo $form->field($questionnaireModel, "[$index]id_questionnaire")->hiddenInput()->label(false);

						}

					?>
	<div class="form-group">
	<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

	<?php ActiveForm::end(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'question:ntext',
            'score',
            'answer:boolean',
        ],
    ]) ?>

</div>
