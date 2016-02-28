<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Page;
use common\components\helpers\Tree;

class PageController extends Controller
{

	public function actionMainpage()
	{
		return $this->render('mainpage', [
		]);
	}
	
	public function actionView($sid)
	{
		$model = Page::find()->where(['sid'=>$sid])->one();
		$models = Page::find()->select(['id','pid','sid','header'])->asArray()->indexBy('id')->all();
		$mode = $models[$model->id];
		$branch[] = $mode;
		while (!is_null($mode['pid'])) {
			$mode = $models[$mode['pid']];
			$branch[] = $mode;
		}
		krsort($branch);
		$db = Yii::$app->db;
		$current_menu = $db->createCommand('call current_menu(:sid)')
			->bindValue(':sid',$model->sid)
			->queryAll();
		$current_menu = Tree::level($current_menu,$model->pid);
		return $this->render('view', [
			'model' => $model,
			'current_menu' => $current_menu,
			'branch' => $branch,
		]);
	}
}

