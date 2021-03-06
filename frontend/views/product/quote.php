<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\helpers\Text;

end($breadcrumbsBranch);
$endkey = key($breadcrumbsBranch);
prev($breadcrumbsBranch);
$penultimate = key($breadcrumbsBranch);
foreach ($breadcrumbsBranch as $key => $value) {
	if ($key === $endkey) {
		$this->params['breadcrumbs'][] = ['label' => $value['header'],'encode' => false];
		continue;
	}
	if ($key === $penultimate) {
		$this->params['breadcrumbs'][] = ['label' => $value['header'], 'url' => ['product/list', 'category' => $product['category_sid']]];
		continue;
	}
	$this->params['breadcrumbs'][] = ['label' => $value['header'], 'url' => ['page/view', 'sid' => $value['sid']]];
}
?>

<h1><?= $product['header'] ?></h1>
<div class="row">
	<div class="col-sm-2">
		<p>Цена:</p>
		<h2 style="margin-top: 0px;"><?= $product['price'] ?> &#8381;</h2>
	</div>
	<div class="col-sm-10">
		<p>HTML оформление: <?= ($product['quote_html']==='1')?'<strong class="text-success">есть</strong>':'<strong class="text-warning">нет</strong>' ?></p>
	</div>
</div>
<blockquote>
  <p><?= $product['quote_content'] ?></p>
  <footer><cite><?= $product['author_name'] ?></cite></footer>
</blockquote>

<?php $form = ActiveForm::begin(['id' => 'buy-form', 'options' => ['class' => 'form-inline'],]) ?>
    <?= $form->field($buyForm, 'product_id')->hiddenInput()->label(false, ['style'=>'display:none']) ?>
    <?= $form->field($buyForm, 'user_id')->hiddenInput()->label(false, ['style'=>'display:none']) ?>
    <?= $form->field($buyForm, 'count')->input('number', ['size' => 2,'min' => 1,'max' => 99]) ?>
    <?= Html::beginTag('div', ['class' => 'form-group']) ?>
	    <?= Html::submitButton('В корзину', ['class' => 'btn btn-success']) ?>
    	<?= Html::tag('div', null, ['class' => 'help-block']) ?>
    <?= Html::endTag('div') ?>
	<?= Html::beginTag('div', ['class' => 'form-group']) ?>
		<?= Html::submitButton('Удалить этот товар из корзины', ['class' => 'btn btn-primary', 'name'=>'delete']) ?>
		<?= Html::tag('div', null, ['class' => 'help-block']) ?>
	<?= Html::endTag('div') ?>
<?php ActiveForm::end() ?>

<p>В корзине <?= $count ?> <?= Text::declension($count,'таких такой таких') ?> <?= Text::declension($count,'товаров товар товара') ?>.</p>
