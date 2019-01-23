<?php 

namespace console\controllers;

use Yii;
use common\models\User;

class UserCreatorController extends \yii\console\Controller
{
	/**
	 * Добавление бзепей .. 
	 * @param  string $login логин
	 * @param  string $pass  пароль
	 */
	public function actionAdd($login,$pass)
	{
		$u=new User(['username'=>$login,'email'=>$login.'@site.com']);
		$u->setPassword($pass);
		$u->generateAuthKey();
		$u->save();
		
	}
}