<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use common\models\Page;
use common\models\News;
use common\models\SecNews;
use yii\helpers\ArrayHelper;
use Yii;

class NewsController extends Controller
{
	
	public function actionList()
	{
		$limit = 10;
		$page = (is_null(Yii::$app->request->get('page')))?1:Yii::$app->request->get('page');
		$offset = ((int)$page-1)*$limit;

		$order = ['created_at' => SORT_DESC,'id' => SORT_DESC];
		if (is_null(Yii::$app->request->get('section'))) {
			$news = News::find()
				->select(['news.id','news.sid','news.header','updated_at','created_at','sec'])
				->innerJoinWith('sec0')
				->orderBy($order)
				->offset($offset)
				->limit($limit)
				->all();
			$pagination = new Pagination(['totalCount' => News::find()->count(), 'pageSize'=>$limit]);
		}else{
			$news = News::find()
				->select(['news.id','news.sid','news.header','updated_at','created_at','sec'])
				->innerJoinWith('sec0')
				->where(['sec_news.sid' => Yii::$app->request->get('section')])
				->orderBy($order)
				->offset($offset)
				->limit($limit)
				->all();
			$pagination = new Pagination(['totalCount' => News::find()->innerJoinWith('sec0')->where(['sec_news.sid' => Yii::$app->request->get('section')])->count(), 'pageSize'=>$limit]);
		}

		$sections = SecNews::find()->asArray()->all();

		$pagination->pageSizeParam = false;

		$page = Page::find()->where(['sid'=>Yii::$app->controller->id])->select(['id','pid','sid','header'])->one();
		$pages = Page::find()->select(['id','pid','sid','header'])->asArray()->indexBy('id')->all();
		$mode = $pages[$page->id];
		$branch[] = $mode;
		while (!is_null($mode['pid'])) {
			$mode = $pages[$mode['pid']];
			$branch[] = $mode;
		}
		krsort($branch);
		$sectionsBySid = ArrayHelper::index($sections, 'sid');
		if (!is_null(Yii::$app->request->get('section'))) $branch[] = ['header'=>$sectionsBySid[Yii::$app->request->get('section')]['header']];

		return $this->render('list', [
			'news' => $news,
			'sections' => $sections,
			'pagination' => $pagination,
			'branch' => $branch,
		]);
	}
	
	public function actionView($sid,$section)
	{
		$news = News::find()->select('*')->where(['sid'=>$sid])->one();
		$sectionM = SecNews::find()->select(['id','sid','header'])->where(['sid'=>$section])->asArray()->one();
		$page = Page::find()->where(['sid'=>Yii::$app->controller->id])->select(['id','pid','sid','header'])->one();
		$pages = Page::find()->select(['id','pid','sid','header'])->asArray()->indexBy('id')->all();
		$mode = $pages[$page->id];
		$branch[] = $mode;
		while (!is_null($mode['pid'])) {
			$mode = $pages[$mode['pid']];
			$branch[] = $mode;
		}
		krsort($branch);
		$branch[] = $sectionM;
		$branch[] = ['header'=>$news->header];

		return $this->render('view', [
			'news' => $news,
			'branch' => $branch,
		]);
	}
	
}

