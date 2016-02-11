<?php 
use  yii\helpers\Html;
use  yii\helpers\Url;
?>


<div class="panel-group" id="accordionZtree">
	<div class="panel panel-default">


<?php 

// echo "<pre>";
// var_dump($ztree);
// die;

foreach ($ztree as $key => $val) {
	
	if ($val['level']===0) {
		if ((isset($ztree[$key + 1])) && ($ztree[$key + 1]['level'] > $val['level'])) {
?>
<div class="panel-heading">
<a href="<?= Url::to(['page/view','sid'=>$val['sid']]) ?>">
<span class="pull-right" data-toggle="collapse" data-parent="#accordionZtree" href="#collapse<?= $val['id'] ?>"><span class="caret"></span></span>
<?= $val['header'] ?> 
</a>
</div>
<div class="panel-collapse collapse" id="collapse<?= $val['id'] ?>">
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


			// $result.= $this->render('lia',[
			// 	'val'=>$val,
			// 	'enableDel'=>((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] > $val['level']))?false:true,
			// ]);

			// if ((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] > $val['level']))
			// 	$result.= '<ul>';

			// if ((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] == $val['level'])) {
			// 	$result.= '</li>';
			// }

			// if ((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] < $val['level']))
			// 	$result.= str_repeat('</li>'.'</ul>', $val['level'] - $this->ztree[$key + 1]['level']);

			// if (!isset($this->ztree[$key + 1]))
			// 	$result.= '</li>'.str_repeat('</ul>'.'</li>', $val['level']);
?>

	</div>
</div>