<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

end($breadcrumbsBranch);
$endkey = key($breadcrumbsBranch);
foreach ($breadcrumbsBranch as $key => $value) {
	if ($key===$endkey)
	{
		$this->params['breadcrumbs'][] = ['label' => $value['header']];
		continue;
	}
	$this->params['breadcrumbs'][] = ['label' => $value['header'], 'url' => ['page/view', 'sid' => $value['sid']]];
}

?>

<h1>Рыбный текст</h1>
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<?php foreach ($products as $key => $value): ?>
			<h3><a href="<?= Url::to(['product/view','category'=>$value['category_sid'],'id'=>$value['id']]) ?>"><?= $value['header'] ?><span class="pull-right"><?= $value['price'] ?></span></a></h3>
		<?php endforeach ?>
		<?= LinkPager::widget(['pagination' => $pagination,]); ?>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<form action="" method="POST" role="form" class="form-horizontal">
			<legend>Фильтр</legend>
			<p>Поиск</p>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="input-group">
						<span class="input-group-addon">Строка содержит</span>
						<input type="text" name="filter_q" value="<?= $filters['q'] ?>" class="form-control" placeholder="Введите более двух символов">
					</div>
				</div>
			</div>
			<p>Цена</p>		
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">От</label>
				<div class="col-sm-10">
					<input type="range" name="price_from" value="<?= $filters['price_from'] ?>" min="<?= $filters['price_min'] ?>" max="<?= $filters['price_max'] ?>" step="0.01" class="form-control" id="">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">До</label>
				<div class="col-sm-10">
					<input type="range" name="price_to" value="<?= $filters['price_to'] ?>" min="<?= $filters['price_min'] ?>" max="<?= $filters['price_max'] ?>" step="0.01" class="form-control" id="">
				</div>
			</div>
			<p>Параметры текста</p>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Наличие HTML форматирования</h3>
				</div>
				<div class="panel-body">
					<div class="radio">
						<label><input type="radio" name="filter_html" value="2"<?= ($filters['html']==='2')?' checked':'' ?>>Неважно</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="filter_html" value="1"<?= ($filters['html']==='1')?' checked':'' ?>>Есть</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="filter_html" value="0"<?= ($filters['html']==='0')?' checked':'' ?>>Нет</label>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Наличие тега strong</h3>
				</div>
				<div class="panel-body">
					<div class="radio">
						<label><input type="radio" name="filter_strong" value="2"<?= ($filters['strong']==='2')?' checked':'' ?>>Неважно</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="filter_strong" value="1"<?= ($filters['strong']==='1')?' checked':'' ?>>Есть</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="filter_strong" value="0"<?= ($filters['strong']==='0')?' checked':'' ?>>Нет</label>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Наличие тега em</h3>
				</div>
				<div class="panel-body">
					<div class="radio">
						<label><input type="radio" name="filter_em" value="2"<?= ($filters['em']==='2')?' checked':'' ?>>Неважно</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="filter_em" value="1"<?= ($filters['em']==='1')?' checked':'' ?>>Есть</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="filter_em" value="0"<?= ($filters['em']==='0')?' checked':'' ?>>Нет</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Применить</button>
				</div>
			</div>
		</form>
	</div>
</div>