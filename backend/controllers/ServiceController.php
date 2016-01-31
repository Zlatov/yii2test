<?php

namespace backend\controllers;

use Yii;

use common\models\Service;
use common\models\SecService;

use backend\models\ServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
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
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Service model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $secService = $model->getSecs()->all();
        return $this->render('view', [
            'model' => $model,
            'secService' => $secService,
        ]);
    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Service();
        $secServiceList = SecService::find()->select(['id','header'])->all();
        $secServiceList = ArrayHelper::map($secServiceList,'id','header');
        // или
        // $secServiceList = SecService::find()->select(['header', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Service::getDb()->beginTransaction();
            if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $transaction->rollBack();
                return $this->render('create', [
                    'model' => $model,
                    'secServiceList' => $secServiceList,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'secServiceList' => $secServiceList,
            ]);
        }
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->getSectionsId();

        $secServiceList = SecService::find()->select(['id','header'])->all();
        $secServiceList = ArrayHelper::map($secServiceList,'id','header');
        // или
        // $secServiceList = SecService::find()->select(['header', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post())) {
            
            $transaction = Service::getDb()->beginTransaction();
            if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $transaction->rollBack();
                return $this->render('update', [
                    'model' => $model,
                    'secServiceList' => $secServiceList,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'secServiceList' => $secServiceList,
            ]);
        }
    }

    /**
     * Deletes an existing Service model.
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
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
