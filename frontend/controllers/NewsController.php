<?php
namespace frontend\controllers;

use yii\web\Controller;
use Yii;

class NewsController extends Controller
{
	
	public function actionList()
	{
		$page = (is_null(Yii::$app->request->get('page')))?0:Yii::$app->request->get('var');
		return $this->render('list', [
			'page' => $page,
		]);
	}
	
	public function actionView($sid)
	{
		return $this->render('view', [
			'sid' => $sid,
		]);
	}
	
}

