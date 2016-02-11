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
		
		$db = Yii::$app->db;
		$current_menu = $db->createCommand('call current_menu(:sid)')
			->bindValue(':sid',$model->sid)
			->queryAll();
		// echo "<pre>";
		// var_dump($current_menu);
		$current_menu = Tree::level($current_menu,$model->pid);
		
		// var_dump($current_menu);
		// die;

		return $this->render('view', [
			'model' => $model,
			'current_menu' => $current_menu,
		]);
	}
}

