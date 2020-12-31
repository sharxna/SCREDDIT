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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>
    <?php if(!$model->accepted): ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'User_id',
            'Task_id',
            'input:ntext',
            'accepted:boolean',
        ],
    ]) ?>
    <?php else: ?>
    <h2>SIMS</h2>
                    <?= GridView::widget([
                        'dataProvider' => $selectedSIMSDataProvider,                    
                        'columns' => [                          
                            'sIMS.title',
                            'scale',

                        ],
                    ]); ?>
    <?php endif ?>
	
	<?php $form = ActiveForm::begin(); ?>

    

    
	<?php foreach ($products as $index => $product) {
    //echo $form->field($product, "[$index]scale")->label($product['id_SIMS']);
	echo "<pre>";
		var_dump($product['scale']);//['title'];
	echo "</pre>";
    //echo $form->field($product, "[$index]scale")->label($product->scale);
	}
	?>
	<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
	<?php ActiveForm::end(); ?>


</div>
