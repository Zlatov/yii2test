<?php

/* @var $this yii\web\View */
use yii\widgets\Pjax;
use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Что-то там в этом файле ;) :</p>
    <h2>Тест Pjax</h2>
	<?php Pjax::begin(); ?>
	    <?= Html::a(
	        'Обновить',
	        ['site/about'],
	        ['class' => 'btn btn-lg btn-primary']
	    ) ?>
	    <p>Время сервера: <?= $time ?></p>
	<?php Pjax::end(); ?>
    <p><code><?= __FILE__ ?></code></p>
    
    <pre><?= print_r($identity) ?></pre>

</div>
