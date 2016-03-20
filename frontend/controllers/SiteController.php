<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use frontend\models\BuyForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','about'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['about'],
                        'allow' => true,
                        'roles' => ['@'],
                        // 'matchCallback' => function ($rule, $action) {
                        //     return User::isUserAdmin(Yii::$app->user->identity->username);
                        // }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $identity = Yii::$app->user->identity;
        return $this->render('about', [
            'time' => time(),
            'identity' => $identity,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(['/site/index',]);
                    // return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'К сожалению, мы не можем сбросить пароль, попробуйте позднее.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionBasket()
    {
        if (Yii::$app->request->isPost)
        {
            $buyForm = new BuyForm();
            if (Yii::$app->request->post('delete') !== null)
            {
                if ($buyForm->load(Yii::$app->request->post()) && $buyForm->validate()) {
                    $result = Yii::$app->db->createCommand('call basket_delete(:user_id,:product_id);')
                        ->bindValue(':user_id', Yii::$app->user->identity->id)
                        ->bindValue(':product_id', $buyForm->product_id)
                        ->execute();
                } else {
                    $errors = $buyForm->errors;
                }
            }
            else
            {
                if ($buyForm->load(Yii::$app->request->post()) && $buyForm->validate()) {
                    $result = Yii::$app->db->createCommand('call basket_update(:user_id,:product_id,:count);')
                        ->bindValue(':user_id', Yii::$app->user->identity->id)
                        ->bindValue(':product_id', $buyForm->product_id)
                        ->bindValue(':count', $buyForm->count)
                        ->execute();
                } else {
                    $errors = $buyForm->errors;
                }
            }
        }
        $basket = Yii::$app->db->createCommand('call basket_list(:user_id)')
            ->bindValue(':user_id',Yii::$app->user->identity->id)
            ->queryAll();
        return $this->render( 'basket', [
            'basket' => $basket,
        ]);
    }

    public function actionBuy()
    {
        if (Yii::$app->request->isPost)
        {
            if ((Yii::$app->request->post('buy') !== null) && ((integer)Yii::$app->request->post('user_id') === Yii::$app->user->identity->id))
            {
                $basket = Yii::$app->db->createCommand('call basket_list(:user_id)')
                    ->bindValue(':user_id',Yii::$app->user->identity->id)
                    ->queryAll();
                if (count($basket))
                {
                    $result = Yii::$app->db->createCommand('call buy_insert(:user_id);')
                        ->bindValue(':user_id', Yii::$app->user->identity->id)
                        ->execute();
                    Yii::$app->mailer->compose()
                        ->setFrom('noreply@yii.zlatov.net')
                        ->setTo(Yii::$app->user->identity->email)
                        ->setSubject('Покупка')
                        ->setTextBody('Текст сообщения')
                        ->setHtmlBody('<b>текст сообщения в формате HTML</b>')
                        ->send();
                }
            }
            else
            {
            }
        }
        $buyList = Yii::$app->db->createCommand('call buy_list(:user_id)')
            ->bindValue(':user_id',Yii::$app->user->identity->id)
            ->queryAll();
        return $this->render( 'buy', [
            'buyList' => $buyList,
        ]);
    }
}
