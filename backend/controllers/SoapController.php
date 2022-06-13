<?php 

namespace backend\controllers;

use Yii;
use backend\models\SoapModel;
use common\models\User;

class SoapController extends \yii\web\Controller
{
	/**
	 * признак авторизованности
	 * @var boolean
	 */
	private $isLogined = false;

	public function actions()
	{
		return [
			'index' => [
				'class' => \mongosoft\soapserver\Action::className()
			],
		];
	}

	/**
	 * Убрать с POST запроса проверку csrf токена 
	 * @param  [type] $act [description]
	 * @return [type]      [description]
	 */
	public function beforeAction($act)
	{
		$this->enableCsrfValidation = false;
		if (!parent::beforeAction($act)) {
			return false;
		}
		return true;
	}

	/**
	 * логин по soap 
	 */
	public function Login($args)
	{
		$data = [];
		foreach($args->item as $y) {
			$data[$y->key] = $y->value;
		}
		if (empty($data['user']) || empty($data['pass'])) {
			return ;
		}
		// ищем юзера 
		$u = User::find()->where(['and', ['=', 'username', $data['user']], ['>', 'status', 0]])->limit(1)->one();
		if ($u && $u->validatePassword($data['pass'])) {
			$this->isLogined = true;
		}
		

	}

	/**
	 * просто функция .. 
	 * @param string $city   город
	 * @param string $name   Имя
	 * @param date $date   дата yyyy-mm-dd
	 * @param integer $param1 Число
	 * @param Object $param2 просто объект
	 * @soap
	 * @return Object 
	 */
	public function Calculate($city = '', $name = '', $date = '', $param1 = '', $param2 =' ')
	{
		if (!$this->isLogined) {
			return ['error' => 'Не авторезован!'];
		}
		$m = new SoapModel([
			'city' => $city,
			'name' => $name,
			'date' => $date,
			'param1' => $param1,
			'param2' => $param2
		]);

		if ($m->validate()) {
			return [
				'price' => rand(),
				'info' => Yii::$app->security->generateRandomString(),
			];
		}
		
		return ['error' => $m->errors];

		
	}

	
}

