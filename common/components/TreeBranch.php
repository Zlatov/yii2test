<?php
namespace common\components;

use Yii;

trait TreeBranch {
	public static function treeBranch($str) {
		$page = self::find()->where(['sid'=>$str])->select(['id','pid','sid','header'])->one();
		$pages = self::find()->select(['id','pid','sid','header'])->asArray()->indexBy('id')->all();
		$mode = $pages[$page->id];
		$branch[] = $mode;
		while (!is_null($mode['pid'])) {
			$mode = $pages[$mode['pid']];
			$branch[] = $mode;
		}
		krsort($branch);
		return $branch;
	}
}
