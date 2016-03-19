<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use frontend\models\BuyForm;
use yii\widgets\Pjax;

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(['id' => 'basket']) ?>

	<?php foreach ($basket as $item): ?>
		<div class="row">
			<?php $form = ActiveForm::begin([
					'id' => 'buy-form',
					'options' => ['data-pjax' => '', 'class' => 'form-inline'],
					]) ?>
				<?php $buyForm = new BuyForm(); ?>
				<?php $buyForm->count = $item['basket_count']; ?>
				<?php $buyForm->product_id = $item['product_id']; ?>
				<?php $buyForm->user_id = Yii::$app->user->identity->id; ?>
				<div class="col-sm-5">
					<p><a href="<?= Url::to(['product/view','category'=>$item['category_sid'],'id'=>$item['product_id']]) ?>"><?= $item['product_header'] ?></a> (<?= $item['category_header'] ?>)</p>
					<div style="display: none;">
				    <?= $form->field($buyForm, 'product_id')->hiddenInput()->label(false, ['style'=>'display:none']) ?>
				    <?= $form->field($buyForm, 'user_id')->hiddenInput()->label(false, ['style'=>'display:none']) ?>
				    </div>
				</div>
				<div class="col-sm-3">
					<?= $form->field($buyForm, 'count')->input('number', ['size' => 2,'min' => 1,'max' => 99,'class' => "form-control input-sm"])->label(false, ['style'=>'display:none']) ?>
					<?= Html::beginTag('div', ['class' => 'form-group']) ?>
						<?= Html::submitButton('Установить', ['class' => 'btn btn-primary btn-sm']) ?>
						<?= Html::tag('div', null, ['class' => 'help-block']) ?>
					<?= Html::endTag('div') ?>
				</div>
				<div class="col-sm-1">
					<p><?= $item['product_price'] ?></p>
				</div>
				<div class="col-sm-1">
					<p><?= $item['price_sum'] ?></p>
				</div>
				<div class="col-sm-2">
					<?= Html::beginTag('div', ['class' => 'form-group']) ?>
						<?= Html::submitButton('Удалить', ['class' => 'btn btn-primary btn-sm', 'name'=>'delete']) ?>
						<?= Html::tag('div', null, ['class' => 'help-block']) ?>
					<?= Html::endTag('div') ?>
				</div>
			<?php ActiveForm::end() ?>
		</div>
	<?php endforeach ?>
<?php Pjax::end() ?>

<?php if (count($basket)): ?>
	<?= Html::beginForm(['site/buy'], 'post', ['enctype' => 'multipart/form-data']) ?>
		<?= Html::hiddenInput('user_id', Yii::$app->user->identity->id) ?>
		<?= Html::submitButton('Оформить заказ (здесь - уже приобрести)', ['class' => 'btn btn-success', 'name'=>'buy']) ?>
	<?= Html::endForm() ?>
<?php else: ?>
	<p>Корзина пуста.</p>
<?php endif ?>
