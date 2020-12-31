<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="answer-view">


    <?php if(!$model->accepted): ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'User_id',
            //'Task_id',
			'task.description:ntext',
            'input:ntext',
            'accepted:boolean',
        ],
    ]) ?>

    <p>
        <?php if (!$model->accepted) echo Html::a('Submit answer', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php else: ?>
    <h2>Questionnaire</h2>
    <br>
            <?php echo
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                //'User_id',
                //'Task_id',
                'task.title:ntext',
                'task.description:ntext',
            ],
        ])
        ?>
    <br>
    <h3> Why did you complete this task?<h3/>
        <h5> <?php $form = ActiveForm::begin(); ?>
					<?php
                                        $options = array('1'=>1, '2'=>2, '3'=>3, '4'=>4, '5'=>5, '6'=>6, '7'=>7);
						foreach($selectedSIMSDataProvider->getModels() as $index => $simsModel)
						{
							echo $form->field($simsModel, "[$index]id")->hiddenInput()->label(false);
							echo $form->field($simsModel, "[$index]scale")->radioList($options)->label($simsModel->sIMS->title);//($simsModel, "[$index]scale")->textInput(['maxlength' => true])->label($simsModel->sIMS->title);
							echo $form->field($simsModel, "[$index]id_answer")->hiddenInput()->label(false);
							echo $form->field($simsModel, "[$index]id_SIMS")->hiddenInput()->label(false);
							// echo "<pre>";
							// var_dump($simsModel->scale);
							// echo "</pre>";
						}
						
						
					
					
					?> <h5/>
			
                    <?php /*echo GridView::widget([
                        'dataProvider' => $selectedSIMSDataProvider,                    
                        'columns' => [                          
                            'sIMS.title',
                            'scale',

                        ],
                    ]);*/ ?>
					<div class="form-group">
	<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

	<?php ActiveForm::end(); ?>
    <?php endif ?>
</div>
