<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'User_id')->textInput() ?>

    <?php //echo $form->field($model, 'Task_id')->textInput() ?>

    <?php if ($model->task->input_type === 2): ?>
        <?= $form->field($model, 'input')->textarea(['rows' => 6]) ?>

    <?php elseif ($model->task->input_type === 1 || $model->task->input_type === 3): ?>
        <?= $form->field($model, 'image')->fileInput() ?>

    

    <?php elseif ($model->task->input_type === 4):    /* source: https://www.w3schools.com/html/tryit.asp?filename=tryhtml5_webstorage_local_clickcount */?>
    <?php $buttontaps = 0; ?>
	<?= $form->field($model, 'input')->textarea(['rows' => 6])->label(false); ?>
        <html>
            <head>
                <script>
					clicks = 0;
					document.getElementById("answer-input").style.display = "none";
                    function clickCounter() {
                        clicks++;
						document.getElementById("result").innerHTML = "You clicked the button " + clicks + " times!";
						document.getElementById("answer-input").innerHTML = clicks;
                    }
                </script>
            </head>
            <body>

                <p><button onclick="clickCounter()" type="button">Click me!</button></p>
                <div id="result"></div>
                <p>Click the button to see the counter increase.</p>

            </body>
        </html>
        
        <!-- <button>Submit</button> --->

    <?php endif ?>
    <?php //echo $form->field($model, 'accepted')->checkbox() ?>

    <?php //echo $form->field($model, 'completed')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
