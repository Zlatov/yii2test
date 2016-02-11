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

		$result = '<ul class="ul-tree ul-drop">';
		foreach ($this->ztree as $key => $val) {
			$result.= $this->render('lia',[
				'val'=>$val,
				'enableDel'=>((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] > $val['level']))?false:true,
			]);

			if ((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] > $val['level']))
				$result.= '<ul>';

			if ((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] == $val['level'])) {
				$result.= '</li>';
			}

			if ((isset($this->ztree[$key + 1])) && ($this->ztree[$key + 1]['level'] < $val['level']))
				$result.= str_repeat('</li>'.'</ul>', $val['level'] - $this->ztree[$key + 1]['level']);

			if (!isset($this->ztree[$key + 1]))
				$result.= '</li>'.str_repeat('</ul>'.'</li>', $val['level']);
		}
		$result.= '</ul>';
		return $result;
	}
}