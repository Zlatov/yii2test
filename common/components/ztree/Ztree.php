<?php
namespace common\components\ztree;

use yii\base\Widget;

class Ztree extends Widget
{
	public $ztree = [];
	public $current_id;
	public function run()
	{
		return $this->render('lia',[
			'ztree' => $this->ztree,
			'current_id' => $this->current_id,
		]);
	}
}