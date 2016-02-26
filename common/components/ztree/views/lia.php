<?php 
use  yii\helpers\Html;
use  yii\helpers\Url;
?>


<div class="panel-group" id="accordionZtree">
	<div class="panel panel-default">


<?php 


foreach ($ztree as $key => $val) {
	
	if ($val['level']===0) {
		if ((isset($ztree[$key + 1])) && ($ztree[$key + 1]['level'] > $val['level'])) {
?>
<div class="panel-heading">
<a href="<?= Url::to(['page/view','sid'=>$val['sid']]) ?>"<?=($val['id']==$current_id)?" class=\"text-danger\"":''?>>
<span class="pull-right" data-toggle="collapse" data-parent="#accordionZtree" href="#collapse<?= $val['id'] ?>"><span class="caret"></span></span>
<?= $val['header'] ?> 
</a>
</div>
<div class="panel-collapse<?=($val['id']==$current_id)?"":' collapse'?>" id="collapse<?= $val['id'] ?>">
<div class="list-group">
<?php

		}
		else
		{
?>
<div class="panel-heading">
<a href="<?= Url::to(['page/view','sid'=>$val['sid']]) ?>">
<?= $val['header'] ?>
</a>
</div>
<?php

		}
	}
	else
	{
?>
<li class="list-group-item">
<a href="<?= Url::to(['page/view','sid'=>$val['sid']]) ?>"><?= $val['header'] ?></a>
</li>
<?php

		if (!isset($ztree[$key + 1]) || ($ztree[$key + 1]['level'] < $val['level']) )
		{
?>
</div>
</div>
<?php
		}
	}

}

?>

	</div>
</div>