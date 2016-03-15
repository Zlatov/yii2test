<?php
namespace console\controllers;

use Yii;
use \yii\web\User;
use \yii\console\Controller;
use common\components\rbac\UserRoleRule;

class RbacController extends Controller
{
	// public function actionInit()
	// {
	// 	$auth = Yii::$app->getAuthManager();
	// 	$auth->removeAll();

	// 	$user = $auth->createRole('user');
	// 	$auth->add($user);

	// 	$admin = $auth->createRole('admin');
	// 	$auth->add($admin);

	// 	$auth->addChild($admin,$user);

	// 	$this->stdout('Done' . PHP_EOL);
	// }

    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
        //Создадим для примера права для доступа к админке
        $dashboard = $auth->createPermission('dashboard');
        $dashboard->description = 'Админ панель';
        $auth->add($dashboard);
        //Включаем наш обработчик
        $rule = new UserRoleRule();
        $auth->add($rule);
        //Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName = $rule->name;
        $auth->add($user);
        $moder = $auth->createRole('moder');
        $moder->description = 'Модератор';
        $moder->ruleName = $rule->name;
        $auth->add($moder);
        //Добавляем потомков
        $auth->addChild($moder, $user);
        $auth->addChild($moder, $dashboard);
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moder);
		$this->stdout('Done' . PHP_EOL);
    }

	public function actionTest($value='')
	{
		Yii::$app->set('request', new \yii\web\Request());

		$user = new User(['id' => 1, 'userName' => 'User']);

		Yii::$app->user->login($user);
	}
}