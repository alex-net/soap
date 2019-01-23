<?php 

namespace frontend\controllers;

use Yii;
use frontend\models\SoapForm;

use yii\helpers\Html;

class TestController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$f=new SoapForm();
		if (Yii::$app->request->isPost && Yii::$app->request->isAjax){
			Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
			$post=Yii::$app->request->post();
			$res=$f->sendSoapQuery($post);
			if ($res)
				return $res;
			
			else{
				// валидацию не прошли возвращаем ошибки ...
				$errs=[];
				// переделываем ошибки под id полей формы ..
				foreach($f->errors as $x=>$y)
					$errs[Html::getInputId($f,$x)]=$y;
				return ['formerrors'=>$errs];
			}
			
		}
		return $this->render('index',['form'=>$f]); 
	}
}
?>