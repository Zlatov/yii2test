<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use common\models\Page;
use common\models\Service;
use common\models\SecService;
use common\models\SecSer;
use yii\helpers\ArrayHelper;
use Yii;

class ServiceController extends Controller
{
	
	public function actionList()
	{
		$limit = 10;
		$page = (is_null(Yii::$app->request->get('page')))?1:Yii::$app->request->get('page');
		$offset = ((int)$page-1)*$limit;

		$order = ['service.order' => SORT_ASC,'id' => SORT_DESC];
		if (is_null(Yii::$app->request->get('section'))) {
			$service = Service::find()
				->select(['service.id','service.sid','service.header'])
				->innerJoinWith('secs')
				->orderBy($order)
				->offset($offset)
				->limit($limit)
				->all();
			$pagination = new Pagination(['totalCount' => Service::find()->count(), 'pageSize'=>$limit]);
		}else{
			$service = Service::find()
				->select(['service.id','service.sid','service.header'])
				->innerJoinWith('secs')
				->where(['sec_service.sid' => Yii::$app->request->get('section')])
				->orderBy($order)
				->offset($offset)
				->limit($limit)
				->all();
			$pagination = new Pagination(['totalCount' => Service::find()->innerJoinWith('secs')->where(['sec_service.sid' => Yii::$app->request->get('section')])->count(), 'pageSize'=>$limit]);
		}

		$sections = SecService::find()->asArray()->all();

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
			'service' => $service,
			'sections' => $sections,
			'pagination' => $pagination,
			'branch' => $branch,
		]);
	}
	
	public function actionView($sid)
	{
		$service = Service::find()
			->select('*')
			->innerJoinWith('secs')
			->where(['service.sid'=>$sid])
			->one();
		$page = Page::find()->where(['sid'=>Yii::$app->controller->id])->select(['id','pid','sid','header'])->one();
		$pages = Page::find()->select(['id','pid','sid','header'])->asArray()->indexBy('id')->all();
		$mode = $pages[$page->id];
		$branch[] = $mode;
		while (!is_null($mode['pid'])) {
			$mode = $pages[$mode['pid']];
			$branch[] = $mode;
		}
		krsort($branch);
		$branch[] = ['header'=>$service->header];

		return $this->render('view', [
			'service' => $service,
			'branch' => $branch,
		]);
	}
	
}

