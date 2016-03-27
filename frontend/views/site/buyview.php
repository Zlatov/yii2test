<?php
use common\components\helpers\Text;

$this->title = 'Покупка';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php foreach ($list as $item): ?>
	<h2><?= $item['product_header'] ?></h2>
	<p><?= $item['product_count'] ?> <?= Text::declension($item['product_count'], 'штук штука штуки') ?></p>
	<pre><?= $item['product_content'] ?></pre>
<?php endforeach ?>