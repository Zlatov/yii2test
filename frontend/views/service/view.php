<?php

end($branch);
$endkey = key($branch);
prev($branch);
$penultimate = key($branch);
foreach ($branch as $key => $value) {
	if ($key!==$endkey)
	{
		$this->params['breadcrumbs'][] = ['label' => $value['header'], 'url' => ['page/view', 'sid' => $value['sid']]];
	}
	else
	{
		$this->params['breadcrumbs'][] = ['label' => $value['header']];
	}
}

?>

<h1><?= $service->header; ?></h1>
<?= $service->text; ?>