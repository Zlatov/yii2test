<?php

end($branch);
$endkey = key($branch);
prev($branch);
$penultimate = key($branch);
foreach ($branch as $key => $value) {
	if ($key!==$endkey)
	{
		if ($key === $penultimate) {
			$this->params['breadcrumbs'][] = ['label' => $value['header'], 'url' => ['news/list', 'section' => $value['sid']]];
		}
		else
		{
			$this->params['breadcrumbs'][] = ['label' => $value['header'], 'url' => ['page/view', 'sid' => $value['sid']]];
		}
	}
	else
	{
		$this->params['breadcrumbs'][] = ['label' => $value['header']];
	}
}

?>

<h1><?= $news->header; ?></h1>
<?= $news->text; ?>