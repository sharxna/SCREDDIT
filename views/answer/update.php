<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */

$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="answer-view">

    <?php if ($message != "n"): ?>
        <script>alert('<?= $message ?>')</script>
    <?php endif ?>

    <?php //if ($message != "n") echo "|". $message . "|"; ?>


        <h1><?= Html::encode($model->task->title) ?></h1>

    <?php
    $text = $model->task->description;
    if ($model->task->description . strpos($text, '@') == true) {
        $stringParts = array_pad(explode("@", $text), 2, null);
        $picture = $stringParts[1];
        $description = $stringParts[0];
    }
    ?>

	<?php if($model->accepted && ($model->task->input_type == 1 || $model->task->input_type == 3) && Yii::$app->user->getId() == 1): ?>
		<?= Html::img($model->input);?>
		<!--<script>
			setTimeout(function() {
			  location.reload();
			}, 5000);
		</script>
		<h3>Please wait a moment...<h3><br>
                <h4>The Social Credit System is validating your picture<h4>
                        <h6> The page will refresh every 5 seconds. You will be redirected to the questionnaire page, when your picture is accepted.</p><br><br>
        <h5><?php /*echo '<i style="color:red ;">
                *Note that if your picture did not get accepted, you can try again! </i> '; */?></h5>-->
    <?php elseif (!$model->accepted): ?>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'User_id',
                //'Task_id',
                //'task.description:ntext',
                'description' => 
                [
                    'attribute' => 'description',
                    'value' => $description
                ],
                //'input:ntext',
                //'accepted:boolean',
                //'startDate',
                'endDate',
            //'active'
            ],
        ])
        ?>
        <h4><?php
            echo $picture;
            ?></h4><br>
        <?php
        /* @var $this yii\web\View */
        /* @var $model app\models\Answer */

        $this->title = 'Update Answer: ' . $model->id;
        //$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
        //$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
        $this->params['breadcrumbs'][] = 'Update';
        ?>
        <div class="answer-update">

                    <!---<h1><?php //Html::encode($this->title)   ?></h1>--->

            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>


        </div>
    <?php else: ?>
                    <h3><?php echo '<i style="color:red ;">
                Succesfully completed! </i> '; ?></h3>
        <?php
        echo
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                            'description' => 
                [
                    'attribute' => 'description',
                    'value' => $description
                ],
            //'id',
            //'User_id',
            //'Task_id',
            //'task.description:ntext',
            ],
        ])
        ?>
            <br><u><h3>Questionnaire</h3></u><br>
        <h4> Why did you complete this task? </h4>
        <h5> 1 = does not correspond at all, 2 = corresponds very little;
3 = corresponds a little; 4 = corresponds moderately; 5 = corresponds enough; 6 = corresponds a lot; 7 = corresponds
exactly. </h5><br>
        <?php $form = ActiveForm::begin(); ?>
        <?php
        $options = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7);
        foreach ($selectedSIMSDataProvider->getModels() as $index => $simsModel) {
            echo $form->field($simsModel, "[$index]id")->hiddenInput()->label(false);
            echo $form->field($simsModel, "[$index]scale")->radioList($options)->label($simsModel->sIMS->title); //($simsModel, "[$index]scale")->textInput(['maxlength' => true])->label($simsModel->sIMS->title);
            echo $form->field($simsModel, "[$index]id_answer")->hiddenInput()->label(false);
            echo $form->field($simsModel, "[$index]id_SIMS")->hiddenInput()->label(false);
            // echo "<pre>";
            // var_dump($simsModel->scale);
            // echo "</pre>";
        }
        ?>

        <?php /* echo GridView::widget([
          'dataProvider' => $selectedSIMSDataProvider,
          'columns' => [
          'sIMS.title',
          'scale',

          ],
          ]); */ ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end(); ?>
        <?php endif ?>
    </div>
