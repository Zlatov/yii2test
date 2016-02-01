<?php

namespace backend\controllers;

use Yii;
use common\models\Page;
use backend\models\PageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\components\helpers\Tree;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageList = Page::find()->select(['id','pid','header'])->asArray()->all();
        $pageList = Tree::level($pageList);

        // $searchModel = new PageSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'pageList' => $pageList,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $pageList = Page::find()->select(['id','header','pid'])->asArray()->all();

        // $pageList = Tree::level($pageList);
        $pageList = Tree::header($pageList);
        $pageList = ArrayHelper::map($pageList,'id','header');

        $paramsPageList = [
            'prompt' => 'Эта страница будет родительская',
            'encode' => false,
            'size' => 20,
        ];


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'pageList' => $pageList,
                'paramsPageList' => $paramsPageList,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->delete()) {
            // echo "<pre>";
            // print_r($model->getErrors());
            // die;
            $errors = $model->getErrors();
            $pageList = Page::find()->select(['id','pid','header'])->asArray()->all();
            $pageList = Tree::level($pageList);
            return $this->render('index', [
                'pageList' => $pageList,
                'errors' => $errors,
            ]);
        }else{
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
