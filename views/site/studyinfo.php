<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\BackendUser;
use yii\widgets\DetailView;

$this->title = 'Study Information';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-info">
    <h1>Study Information</h1>
    <br>

    <?php $model = BackendUser::findOne(Yii::$app->user->getId()) ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_name',
            'consent' =>
            [
                'attribute' => 'consent',
                'label' => 'Consented',
                'value' => $model->consent
            ],
            'activated_date' =>
            [
                'attribute' => 'activated_date',
                'label' => 'Time stamp',
                'value' => $model->activated_date
            ]
        ],
    ])
    ?>
    <h5><?php echo '<i style="color:red ;">
    * 1 means you gave consent </i> '; ?></h5><br>
    <?php $model = BackendUser::findOne(Yii::$app->user->getId()) ?>
    <h3>
        Information about the experiment
    </h3>
    <?php if (!$model->control_group): ?>
        <p>
            <br><strong>Background</strong><br>

            The Social Credit System is a system that is invented by the Chinese Communist Party to encourage trustworthiness. The Social Credit System uses its social score as a reward and penalty mechanism. People are rewarded or punished based on their scores, and people’s scores can increase or decrease based on their individual behaviour.

            <br> Some rewards are free health checks, cheaper public transport, discounts on energy bills and priority for school admissions/employment. Types of punishments are exclusion from public transport, less access to credit/loans, public shaming and restricted access to public services.

            <br><br><strong>The SCREDDIT experiment</strong><br>

            During the study you will participate in a simulated Social Credit System experiment. SCREDDIT stands for Social Credit Rating Experiment with Daily Digitally Implemented Tasks. Every day for a week, you will get a few tasks. To complete these tasks, you either have to take a picture (sometimes with time stamp) or give a text-based answer. 

            <br><br>
            When you complete the tasks in time, the points you could gain for the task will be added, but if the due date (1 day) is expired, then these points will be deducted. After each task you have to complete a questionnaire about your task experience. If you do not complete this questionnaire, your points will not be granted. Please do complete those questionnaires. The Social Credit Score will be between 0-10.000 with three categories: Low (0-4000), Middle (4000-8000), High (8000-10.000). If at the end of the week, your score is ‘Low’, then you have to bake something for me. However, if at the end of the week, your score is ‘High’, then I will reward you with a chocolate bar. If you scored ‘Middle’, then you did not perform good or bad, and you will receive no punishment or reward. 


            <br><br><strong>The web-app</strong><br>

            The web-app is available on your phone/computer/tablet browser! It may be easier to use your phone to take pictures for the tasks, but you can choose whichever device you like.

            <br> You can sign up with your own username and password. After that you will be directed to a questionnaire, after which you will be redirected to your personal SCREDDIT page. On this page you will find the tasks and questionnaires you have to fill in. On the navigation bar you can see “Study information”, which contains all the information that is in this document, so you can reread it. You can also go to “Score info” which contains information about what the different score groups mean for you (especially after the experiment) and how your current score is calculated. 

            <br><br><strong>Technical problems/questions</strong><br>

            If you experience any technical problems or questions on how to use the system, please contact me (see contact details of the researcher). However, if your picture is not accepted, when you think it should have been, please try to send it in again (different background, position, lightening, etc.). If it does not get accepted, then this is just a limitation of the system, as it won’t be possible to intervene and thus help you out with this. For the text-based questions, you can expect them to be carefully checked and any fault will be due to some mistake you made.  

            <br><br><strong> After experiment </strong><br>
            After the experiment I will conduct small a LimeSurvey with questions about how you experienced the whole experiment. This survey will be e-mailed to you together with the information about your reward/punishment.  

            <br><br><strong> Purpose of the research </strong><br>
            The purpose of this research is getting insight in some behavioural aspects of humans interacting with the Social Credit System. For the exact details about this, you can get an explanation after the experiment ended for all participants (but you have to email me about this!). 

            <br><br><strong> Benefits and risks of participating </strong><br>
            All my research and research methods have negligible to minimal risks. I hope that the results will contribute to scientific knowledge about human behaviour interacting with the Social Credit System. In case you want to withdraw from the experiment, contact the experimenter and your personal identifiable data will immediately be deleted. 

            <br><br><strong> Use and preservation of your data </strong><br>
            The answers on the tasks and the answers on the questionnaires, which are linked to your profile (name, age, email), will be stored in the database. The data from the LimeSurvey will be stored on the Radboud servers.

            <br> Your research data is stored and archived on my Raspberry PI web server for at most 1 year after the experiment. When this experiment is finalized and a report or article is written on this, the concomitant experimental data are shared or made public, enabling verification, re-use and/or replication of these research results.


            <br><br><strong>Contact details of the researcher </strong><br>
            In case of questions or complaints about the experiment, contact the responsible experimenter (sharonaniesert@live.nl). 
        </p><br>

    <?php elseif ($model->control_group): ?>
        <p>
            <br><strong>The SCREDDIT experiment</strong><br>

            Every day for a week, you will get a few tasks. To complete these tasks, you either have to take a picture (sometimes with time stamp) or give a text-based answer. 
            <br><br>
            You have one day to complete the tasks and if the due date is expired, then the task disappears. After each task you have to complete a questionnaire about your task experience. Please do complete those questionnaires. 

            <br>After the experiment you will be rewarded with a chocolate bar in return for participating!


            <br><br><strong>The web-app</strong><br>

            The web-app is available on your phone/computer/tablet browser! It may be easier to use your phone to take pictures for the tasks, but you can choose whichever device you like.

            <br> You can sign up with your own username and password. After that you will be directed to a small questionnaire, after which you will be redirected to your personal SCREDDIT page. On this page you will find the tasks and questionnaires you have to fill in. On the navigation bar you can see “Study information”, which contains all the information that is in this document, so you can reread it.
            <br><br><strong>Technical problems/questions</strong><br>

            If you experience any technical problems or questions on how to use the system, please contact me (see contact details of the researcher). However, if your picture is not accepted, when you think it should have been, please try to send it in again (different background, position, lightening, etc.). If it does not get accepted, then this is just a limitation of the system, as it won’t be possible to intervene and thus help you out with this. For the text-based questions, you can expect them to be carefully checked and any fault will be due to some mistake you made.  

            <br><br><strong> After experiment </strong><br>
            After the experiment I will conduct small a LimeSurvey with questions about how you experienced the whole experiment. 

            <br><br><strong> Purpose of the research </strong><br>
            The purpose of this research is getting insight in how willing people are to perform tasks in an
            app with pre-made tasks. For the exact details about this, you can get an explanation after the
            experiment ended for all participants (but you have to email me about this!). 
            <br><br><strong> Benefits and risks of participating </strong><br>
            All my research and research methods have negligible to minimal risks. I hope that the results
            will contribute to scientific knowledge about human behaviour interacting with SCREDDIT. In
            case you want to withdraw from the experiment, contact the experimenter and your personal
            identifiable data will immediately be deleted.
            <br><br><strong> Use and preservation of your data </strong><br>
            The answers on the tasks and the answers on the questionnaires, which are linked to your profile (name, age, email), will be stored in the database. The data from the LimeSurvey will be stored on the Radboud servers.

            <br> Your research data is stored and archived on my Raspberry PI web server for at most 1 year after the experiment. When this experiment is finalized and a report or article is written on this, the concomitant experimental data are shared or made public, enabling verification, re-use and/or replication of these research results.


            <br><br><strong>Contact details of the researcher </strong><br>
            In case of questions or complaints about the experiment, contact the responsible experimenter (sharonaniesert@live.nl). 
        </p><br>    
    <?php endif ?>    



    <h3> Consent Form for SCREDDIT  </h3>
    <h5><?php echo '<i style="color:red ;">
    *Note that you already gave consent for this! </i> '; ?></h5><br>
    <p>
        I confirm that: <br><br>
        •	I was satisfactorily informed about the study in writing, by means of the  <?php if (Yii::$app->controller->action->id == "create"): ?>
            <a href="img/SCREDDIT Study Information & Informed Consent.pdf" target="_blank">Study Information </a>
        <?php else: ?>
            <a href="img/Study Information & Informed Consent SCREDDIT.pdf" target="_blank">Study Information </a>
        <?php endif; ?>. <br>
        •	I have carefully considered participation in the experiment.<br>
        •	I am 18 years or older.<br>
        •	I participate voluntarily.<br><br>

        I agree that:<br><br>
        •	I voluntarily share the following data: pictures, text-based answers, time stamps, answers on the build-in questionnaires, age, e-mail address, SCREDDIT password and LimeSurvey answers.<br>
        •	My research data will be acquired and stored for scientific purposes for at most 1 year after the research has been finalized.<br>
        •       I agree that research data gathered for this study may be published or made available provided my name or other identifying information is not used.<br>
        •	By giving consent, I also give consent for the final LimeSurvey questionnaire, which will be stored on the Radboud servers for at most 1 year after the research has been finalized.<br>
        •	My information can be quoted in research outputs.<br><br>

        I understand that:<br><br>
        •	I have the right to withdraw from the experiment without having to give a reason.<br>
        •	I understand that information I provide will be used strictly only for educational purposes, namely a Bachelor thesis and (the) relative presentation(s).<br>
        •       The data - without any personal information that could identify me - may be shared with others.<br>
        •	My consent will be sought every time I participate in a new experiment. <br><br>
    </p>

</div>

