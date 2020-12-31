<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Backend Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="backend-user-view">

<?php if ($message != "n"): ?>
        <script>alert('<?= $message ?>')</script>
    <?php endif ?>
<!--
    <p>
        <?php // Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */
        ?>
    </p> -->
    <?php if ($model->consent && $model->questionnaire_done): ?>
<h2>  <?php  echo "Welcome back, " . $model->user_name ?></h2>
       <br>
       <?php if (!$model->control_group): ?>
       <h3><center><?php  highlight_string("Social Credit Score: " . $model->score) ?></h3> </center> 
       <h4><center>  <?php  highlight_string("Score category: " . $model->getScoreCategory($model->score)) ?><a href="index.php?r=site%2Fscoreinfo">⍰</a></h4></center> 
       
       <br>

       <?php endif ?> 
       <h4><strong> Personal Information </strong></h4>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'user_name',
                'age',
                'email',
              
            ],
        ])
        ?>

        <h2>Due Tasks</h2>
        <?=
        GridView::widget([
            'dataProvider' => $dueAnswerDataProvider,
            'filterModel' => $dueAnswerSearchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                'task.title',
                //'User_id',
                //'task.description',
                'endDate',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $url = Url::to(['answer/update', 'id' => $model->id]);
                            return Html::a('<button class="btn btn-primary">go</button>', $url, ['title' => 'update']);
                        },
                    //'update' => function ($url, $model) {
                    //    $url = Url::to(['answer/update', 'id' => $model->id]);
                    //   return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'view']);
                    //},
                    ]
                ],
            ],
        ]);
        ?>

        <h2>Uncompleted questionnaire</h2>
        <?=
        GridView::widget([
            'dataProvider' => $acceptedAnswerDataProvider,
            'filterModel' => $acceptedAnswerSearchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                'task.title',
                //'task.description',
                //'User_id',
                //'input:ntext',
                //'accepted:boolean',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $url = Url::to(['answer/update', 'id' => $model->id]);
                            return Html::a('<button class="btn btn-primary">fill in</button>', $url, ['title' => 'update']);
                        },
                    ]
                ],
            ],
        ]);
        ?>         
    <?php elseif($model->consent && !$model->questionnaire_done): ?>
        <?php $form = ActiveForm::begin(); ?>
        <h3> In the past year, I ... </h3><br>
        <?php
        foreach ($selectedUserXQuestionnaireDataProvider->getModels() as $index => $questionnaireModel) {
            echo $form->field($questionnaireModel, "[$index]id")->hiddenInput()->label(false);
            //echo $form->field($questionnaireModel, "[$index]answer")->hiddenInput()->label($questionnaireModel->questionnaire->question);
            echo $form->field($questionnaireModel, "[$index]answer")->checkbox(['checked' => false, 'label' => $questionnaireModel->questionnaire->question]);

            echo $form->field($questionnaireModel, "[$index]id_user")->hiddenInput()->label(false);
            echo $form->field($questionnaireModel, "[$index]id_questionnaire")->hiddenInput()->label(false);
        }
        ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

            <?php ActiveForm::end(); ?>
        <?php endif ?>   

    </div>
