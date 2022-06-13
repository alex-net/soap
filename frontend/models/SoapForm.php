<?php 

namespace frontend\models;

use Yii;


class SoapForm extends \yii\base\Model
{
	/**
	 * город
	 * @var string
	 */
	public $city = '';
	/**
	 * Имя
	 * @var string
	 */
	public $name = '';
	/**
	 * дата в формате yyyy-mm-dd
	 * @var string
	 */
	public $date = ''; 
	/**
	 * просто число
	 * @var integer
	 */
	public $param1 = 5; 
	/**
	 * логин для soap
	 * @var string
	 */
	public $user;
	/**
	 * пароль для soap
	 * @var string
	 */
	public $pass;

	public function attributeLabels()
	{
		return [
			'city' => 'Город',
			'name' => 'Имя',
			'date' => 'Дата',
			'param1' => 'Просто параметр (число)',
			'user' => 'Логин SOAP',
			'pass' => 'Пароль SOAP',
		];
	}

	public function rules()
	{
		return [
			[['city', 'name', 'date', 'param1'], 'required'],
			['date', 'date', 'format' => 'php:Y-m-d'],
			['param1', 'integer'],
			[['user', 'pass'], 'safe'],
		];
	}
	/**
	 * отсылаем запрос на соап с получением ответа ,.. 
	 * @param  array $post Post запрос 
	 * @return false|object       [description]
	 */
	public function sendSoapQuery($post)
	{
		if (!$this->load($post) || !$this->validate()) {
			return false;
		}

		//
		$data = $this->attributes + ['param2' => ['dd' => 'ewe']];
		// создаём клиента ..ы
		$soap = new \SoapClient(Yii::$app->params['soap-service']);
		// подготовка к логину .. 
		$auth = array(
        	'user' => $data['user'],
        	'pass' => $data['pass'],
        );
        unset($data['user'], $data['pass']);
  		$headers = [new \SoapHeader('testing-soap', 'Login', $auth)];
  		$soap->__setSoapHeaders($headers);

		// выполнение функции.. 
		$res = call_user_func_array([$soap, 'Calculate'], $data);
		
		return $res;
	}


}