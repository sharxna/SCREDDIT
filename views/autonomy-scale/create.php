<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SIMS */

$this->title = 'Create Sims';
$this->params['breadcrumbs'][] = ['label' => 'Sims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sims-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
