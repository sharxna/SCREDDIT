<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\BackendUser;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
	if (!Yii::$app->user->isGuest)
		Yii::$app->homeUrl = "index.php?r=backend-user%2Fview&id=" . Yii::$app->user->getId();
    NavBar::begin([
        'brandLabel' => 'SCREDDIT',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	
	$menuItems = array();
	if (!Yii::$app->user->isGuest)
	{
		$menuItems[] = ['label' => 'Home', 'url' => ['/backend-user/view', 'id' => Yii::$app->user->getId()]];
        if (Yii::$app->user->getId() == 1)
		{
			$menuItems[] =     ['label' => 'Tasks', 'url' => ['/task/index']];
			$menuItems[] =     ['label' => 'SIMS', 'url' => ['/autonomy-scale/index']];
			$menuItems[] =     ['label' => 'Answer', 'url' => ['/answer/index']];
			$menuItems[] =     ['label' => 'Users', 'url' => ['/backend-user/index']];
			$menuItems[] =     ['label' => 'Questionnaire', 'url' => ['/questionnaire1/index']];
			
		}
		if (BackendUser::findOne(Yii::$app->user->getId())->control_group == 0)
		{
			$menuItems[] =     ['label' => 'Score info', 'url' => ['/site/scoreinfo']];
		}
		$menuItems[] =     ['label' => 'Study Information', 'url' => ['/site/studyinfo']];
		$menuItems[] = '<li>' . Html::beginForm(['/site/logout'], 'post')
					. Html::submitButton(
						'Logout (' . Yii::$app->user->identity->user_name . ')',
						['class' => 'btn btn-link logout']
					)
					. Html::endForm()
					. '</li>'
				;
	}
	else
	{
		$menuItems[] =  ['label' => 'Login', 'url' => ['/site/login']];
            
	}
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; SCREDDIT <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
