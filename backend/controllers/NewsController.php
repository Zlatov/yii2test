<?php

namespace backend\controllers;

use Yii;
use common\models\News;
use common\models\SecNews;
use backend\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {

        $db = Yii::$app->db;
        $news_count = $db->createCommand('call news_count_in_sections()')
            ->queryAll();

        // $a = $db->createCommand('call news_count_in_sections()')
        //     ->queryOne();
         
        // $a = $db->createCommand('call news_count_in_sections()')
        //     ->queryColumn();
         
        // $a = $db->createCommand('call news_count_in_sections()')
        //     ->queryScalar();

        // echo "<pre>";
        // print_r($a);
        // die;

        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'news_count' => $news_count,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $section = SecNews::find()->select(['header'])->where(['id'=>$model->sec])->all();
        // echo "<pre>";
        // print_r($model->sec);
        // die;
        return $this->render('view', [
            'model' => $model,
            'sectionheader' => $section[0]->header,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($sectionid)
    {
        $model = new News();
        // $sections = SecNews::find()->select(['id','header'])->asArray()->all();
        $sections = SecNews::find()->select(['id','header'])->all();
        // $a = [];
        // foreach ($sections as $section) {
        //     $a[$section['id']] = $section['header'];
        // }
        $sections = ArrayHelper::map($sections,'id','header');
        // echo "<pre>";
        // var_dump($a);
        // die;
        $params = [
            'prompt' => 'Выберите секцию…'
        ];
        if (isset($sectionid)) {
            $params['options'] = [$sectionid => ['Selected'=>'selected']];
            // echo "<pre>";
            // print_r($params);
            // die;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'sections' => $sections,
                'params' => $params,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $sections = SecNews::find()->select(['id','header'])->all();
        $sections = ArrayHelper::map($sections,'id','header');
        $params = ['prompt' => 'Выберите секцию…'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'sections' => $sections,
                'params' => $params,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
