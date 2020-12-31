<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\BackendUser;


$this->title = 'Score Info';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="score-info">
    <h2> Score Information </h2>
    <br>

    <h3>
        Score categories
    </h3>
    The Social Credit Score will be between 0-10.000 with three categories: Low (0-4000), Middle (4000-8000), High (8000-10.000). 
    <br><br><strong> Low </strong><br>
    If at the end of the experiment, your score is ‘Low’, then you have to bake something for me. 
    <br><br><strong> Middle </strong><br>
    If you scored ‘Middle’ at the end of the experiment, then you did not perform good or bad, and you will receive no punishment or reward. 
    <br><br><strong> High </strong><br>
    If at the end of the experiment, your score is ‘High’, then I will reward you with a chocolate bar. 
    
   <?php $model = BackendUser::findOne(Yii::$app->user->getId()) ?>
            <h3> Credit History </h3>
            <p><?php echo $model->getScoreHistory()?></p><br>  
</div>
