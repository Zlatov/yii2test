<?php

namespace backend\components;

use yii\base\Widget;

class TreeList extends Widget
{
	public $treeList = [];
	public function run()
	{
		$this->view->registerCssFile('css/treeList.css');
		$this->view->registerJsFile('js/treeList.js',['depends' => [\yii\web\JqueryAsset::className()]]);

		$result = '<ul class="ul-tree ul-drop">';
		foreach ($this->treeList as $key => $val) {
			$result.= $this->render('treeListLi',[
				'val'=>$val,
				'enableDel'=>((isset($this->treeList[$key + 1])) && ($this->treeList[$key + 1]['level'] > $val['level']))?false:true,
			]);

			if ((isset($this->treeList[$key + 1])) && ($this->treeList[$key + 1]['level'] > $val['level']))
				$result.= '<ul>';

			if ((isset($this->treeList[$key + 1])) && ($this->treeList[$key + 1]['level'] == $val['level'])) {
				$result.= '</li>';
			}

			if ((isset($this->treeList[$key + 1])) && ($this->treeList[$key + 1]['level'] < $val['level']))
				$result.= str_repeat('</li>'.'</ul>', $val['level'] - $this->treeList[$key + 1]['level']);

			if (!isset($this->treeList[$key + 1]))
				$result.= '</li>'.str_repeat('</ul>'.'</li>', $val['level']);
		}
		$result.= '</ul>';
		return $result;
	}

}
