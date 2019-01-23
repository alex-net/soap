<?php 

namespace backend\models;

use Yii;

class SoapModel extends \yii\base\Model
{
	public $city;
	public $name;
	public $date;
	public $param1;
	public $param2;

	public function rules()
	{
		return [
			[['city','name','date','param1','param2'],'required'],
			['date','date','format'=>'php:Y-m-d'],
			['param1','integer'],
			['date','testDate'],
		];
	}

	/**
	 * валидация даты .. 
	 */
	public function testDate($attr,$params)
	{
		$date=strtotime($this->$attr);
		$now=strtotime(date('Y-m-d'));

		if ($date<$now)
			$this->addError($attr,'Дата в прошлом!');
	}
}