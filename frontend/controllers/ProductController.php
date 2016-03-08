<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use common\models\Page;
use common\models\Product;
use common\models\Fish;
use Yii;

class ProductController extends Controller
{
	
	public function actionIndex()
	{
		$session = Yii::$app->session;
		if (!$session->isActive) $session->open();
		$session->destroy();
		/*
		$fish = new Fish();

		$fish->product_id = 2;
		$fish->html = '1';
		$fish->paragraph = '33';
		$fish->strong = '0';
		$fish->em = '0';

		$product = new Product();

		$product->id = 2;
		$product->header = 'As';
		$product->price = '123.33';
		$product->category_id = 1;

		$fish->populateRelation('product',$product);
		// $product->link('fish',$fish);
		// $fish->link('product',$product);

		echo "<pre>";
		print_r($fish);
		die();
		*/

		$categories = Yii::$app->db->createCommand('call category_list()')
			->queryAll();

		$products = Yii::$app->db->createCommand('call product_index()')
			->queryAll();

		return $this->render('index', [
			'products' => $products,
			'categories' => $categories,
		]);
	}

	public function actionList()
	{
		$session = Yii::$app->session;
		if (!$session->isActive) $session->open();

		$filters = Yii::$app->db->createCommand('call product_filters_' . Yii::$app->request->get('category') . '()')
			->queryOne();
		if (isset($_POST['price_from'])) $session['price_from'] = $_POST['price_from'];
		if (isset($_POST['price_to'])) $session['price_to'] = $_POST['price_to'];
		if (isset($_POST['filter_html'])) $session['filter_html'] = $_POST['filter_html'];
		if (isset($_POST['filter_strong'])) $session['filter_strong'] = $_POST['filter_strong'];
		if (isset($_POST['filter_em'])) $session['filter_em'] = $_POST['filter_em'];
		if (isset($_POST['filter_q'])) $session['filter_q'] = $_POST['filter_q'];
		$filters['price_from'] = (isset($session['price_from']))?$session['price_from']:$filters['price_min'];
		$filters['price_to'] = (isset($session['price_to']))?$session['price_to']:$filters['price_max'];
		$filters['html'] = (isset($session['filter_html']))?$session['filter_html']:'2';
		$filters['strong'] = (isset($session['filter_strong']))?$session['filter_strong']:'2';
		$filters['em'] = (isset($session['filter_em']))?$session['filter_em']:'2';
		$filters['q'] = (isset($session['filter_q']))?$session['filter_q']:'';

		$limit = 10;
		$page = (is_null(Yii::$app->request->get('page')))?1:Yii::$app->request->get('page');
		$offset = ((int)$page-1)*$limit;

		switch (Yii::$app->request->get('category')) {
			case 'fish':
				$products = Yii::$app->db->createCommand('call product_list_fish(:offset,:rows,:from,:to,:html,:strong,:em,:q)')
					->bindValue(':offset',$offset)
					->bindValue(':rows',$limit)
					->bindValue(':from',$filters['price_from'])
					->bindValue(':to',$filters['price_to'])
					->bindValue(':html',$filters['html'])
					->bindValue(':strong',$filters['strong'])
					->bindValue(':em',$filters['em'])
					->bindValue(':q',$filters['q'])
					->queryAll();
				break;
			
			case 'quote':
				$products = Yii::$app->db->createCommand('call product_list_quote(:offset,:rows,:from,:to,:html,:q)')
					->bindValue(':offset',$offset)
					->bindValue(':rows',$limit)
					->bindValue(':from',$filters['price_from'])
					->bindValue(':to',$filters['price_to'])
					->bindValue(':html',$filters['html'])
					->bindValue(':q',$filters['q'])
					->queryAll();
				break;
		}

		$count = Yii::$app->db->createCommand('SELECT FOUND_ROWS() as `count`;')
			->queryOne();
		$pagination = new Pagination(['totalCount' => $count['count'], 'pageSize'=>$limit]);

		$breadcrumbsBranch = Page::treeBranch('products');
		$currentCategory = Yii::$app->db->createCommand('select * from category c where c.sid = \'' . Yii::$app->request->get('category') . '\'' )
			->queryOne();
		$breadcrumbsBranch[] = ['header' => $currentCategory['header'], 'sid' => $currentCategory['sid']];

		return $this->render('list_' . Yii::$app->request->get('category'), [
			'products' => $products,
			'pagination' => $pagination,
			'filters' => $filters,
			'breadcrumbsBranch' => $breadcrumbsBranch,
		]);
	}

	public function actionView()
	{
		$db = Yii::$app->db;
		$product = $db->createCommand('call product_view_'. Yii::$app->request->get('category') .'(:id);')
			->bindValue(':id', (int)Yii::$app->request->get('id'))
			->queryOne();
		$breadcrumbsBranch = Page::treeBranch('products');
		$breadcrumbsBranch[] = ['header' => $product['category_header'], 'sid' => $product['category_sid']];
		$breadcrumbsBranch[] = ['header' => htmlspecialchars_decode($product['header'])];

		return $this->render(Yii::$app->request->get('category'), [
			'product' => $product,
			'breadcrumbsBranch' => $breadcrumbsBranch,
		]);
	}
	
	public function beforeAction($action)
	{
		if ($action->id === 'list') {
			$this->enableCsrfValidation = false;
		}
		return parent::beforeAction($action);
	}
}
