<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="backend-user-form">

    <?php if (!$model->consent): ?>
        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'age')->textInput() ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password2')->passwordInput(['maxlength' => true]) ?>

        <?php
        echo '<i style="color:red ;">
      *Note that your password can be seen by the researcher, so do not use any passwords you use for other platforms </i> ';
        ?>
        <br>
        <?php
        echo '<i style="color:red ;">
      *You must remember your username and password to log in! </i> ';
        ?>

        <br><br>

        <h3> Study Information for SCREDDIT  </h3>
        In the following PDF you will find all the information regarding the experiment. You can also find the study information on the homepage or in the navigation bar/ dropdown menu after you signed up.<br>
        <?php if (Yii::$app->controller->action->id == "create"): ?>
            <a href="img/SCREDDIT Study Information & Informed Consent.pdf" target="_blank">Study Information </a>
        <?php else: ?>
            <a href="img/Study Information & Informed Consent SCREDDIT.pdf" target="_blank">Study Information </a>
        <?php endif; ?>

        <h3> Consent Form for SCREDDIT  </h3>

        <h4>By ticking on the box</h4>
        <p>
            I confirm that: <br><br>
            •	I was satisfactorily informed about the study in writing, by means of the 
            <?php if (Yii::$app->controller->action->id == "create"): ?>
                <a href="img/SCREDDIT Study Information & Informed Consent.pdf" target="_blank">Study Information </a>
            <?php else: ?>
                <a href="img/Study Information & Informed Consent SCREDDIT.pdf" target="_blank">Study Information </a>
            <?php endif; ?>. <br>
            •	I have carefully considered participation in the experiment<br>
            •	I am 18 years or older.<br>
            •	I participate voluntarily.<br><br>

            I agree that:<br><br>
            •	I voluntarily share the following data: pictures, text-based answers, time stamps, answers on the build-in questionnaires, age, e-mail address, SCREDDIT password and LimeSurvey answers.<br>
            •	My research data will be acquired and stored for scientific purposes for at most 1 year after the research has been finalized.<br>
            •       I agree that research data gathered for this study may be published or made available provided my name or other identifying information is not used.<br>
            •	By giving consent, I also give consent for the final LimeSurvey questionnaire, which will be stored on the Radboud servers for at most 1 year.<br>
            •	My information can be quoted in research outputs.<br><br>

            I understand that:<br><br>
            •	I have the right to withdraw from the experiment without having to give a reason.<br>
            •	I understand that information I provide will be used strictly only for educational purposes, namely a Bachelor thesis and (the) relative presentation(s).<br>
            •       The data - without any personal information that could identify me - may be shared with others.<br>
            •	My consent will be sought every time I participate in a new experiment. <br><br>
        </p>

        <strong<?php echo $form->field($model, 'consent')->checkbox() ?></strong><br>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php
        echo '<i style="color:red ;">
      *Please wait until your account is created and do not click on other buttons! </i> ';
        ?>
        <br>
             <?php
        echo '<i style="color:red ;">
      It can take a short while, but you will be automatically redirected to your homepage! </i> ';
        ?>   
        
        <?php ActiveForm::end(); ?>
    <?php endif ?>  

</div>
