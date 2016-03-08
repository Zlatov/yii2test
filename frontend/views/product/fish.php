<?php

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
		<p>Количество параграфов: <?= $product['fish_paragraph'] ?></p>
		<p>HTML форматирование: 
		<?php if ($product['fish_html']==='1'): ?>
			<strong class="text-success">есть</strong>
		<?php else: ?>
			<strong class="text-warning">нет</strong>
		<?php endif ?>
		</p>
		<p>Наличие strong: 
		<?php if ($product['fish_strong']==='1'): ?>
			<strong class="text-success">есть</strong>
		<?php else: ?>
			<strong class="text-warning">нет</strong>
		<?php endif ?>
		</p>
		<p>Наличие em: 
		<?php if ($product['fish_em']==='1'): ?>
			<strong class="text-success">есть</strong>
		<?php else: ?>
			<strong class="text-warning">нет</strong>
		<?php endif ?>
		</p>
	</div>
</div>
<pre><?= htmlentities($product['fish_content']) ?></pre>
