<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\models\News;
use common\models\SecNews;
use Yii;

class NewsController extends Controller
{
	
	public function actionList()
	{
		$limit = 10;
		$page = (is_null(Yii::$app->request->get('page')))?1:Yii::$app->request->get('page');
		$section = (is_null(Yii::$app->request->get('section')))?'no-section':Yii::$app->request->get('section');
		$offset = ((int)$page-1)*$limit;

		$order = ['created_at' => SORT_DESC,'id' => SORT_DESC];
		$news = News::find()
			->select(['news.id','news.sid','news.header','updated_at','created_at','sec'])
			->innerJoinWith('sec0')
			->where(['sec_news.sid' => $section])
			->orderBy($order)
			->offset($offset)
			->limit($limit)
			// ->asArray()
			->all();

		$sections = SecNews::find()->asArray()->all();

		return $this->render('list', [
			'news' => $news,
			'sections' => $sections,
		]);
	}
	
	public function actionView($sid)
	{
		return $this->render('view', [
			'sid' => $sid,
		]);
	}
	
}

