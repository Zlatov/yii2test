<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Что-то там в этом файле ;) :</p>

    <p><code><?= __FILE__ ?></code></p>
    
    <pre><?= print_r($identity) ?></pre>

</div>
