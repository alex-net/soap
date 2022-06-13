<?php 
use \yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerJsFile('@web/js/test-form.js',[
	'depends' => [\yii\web\JqueryAsset::className()],
]);

$f = ActiveForm::begin(['id' => 'tst-form']);
echo $f->field($form, 'city');
echo $f->field($form, 'name');
echo $f->field($form, 'date')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999-99-99']);
echo $f->field($form, 'param1');

echo $f->field($form, 'user');
echo $f->field($form, 'pass');
echo Html::submitButton('Поехали');

ActiveForm::end();

?>
<div class="errrmes"></div>
<div class="succmess"></div>