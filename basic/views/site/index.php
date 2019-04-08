<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LinkForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create minified link';
$this->registerCss(".field-linkform-source_link {position: relative; width: 80%; height: 46px; float: left;} .field-linkform-source_link .help-block {position: absolute; top: 120%;} .field-linkform-source_link input {display: block; width: 100% !important; border: 1px solid #777777; border-right: 0 !important; border-radius: 0;} .generate-button {width: 20%; float: right; border-radius: 0;}");
?>
<div class="link-form text-center">
	<h1><?php echo $this->title; ?></h1>
	<p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>
	<br/>
	<br/>
	<br/>
    <?php $form = ActiveForm::begin([
		'enableClientValidation' => true,
		'enableAjaxValidation' => true,
		'validationUrl'=>['/site/createlinkvalidate'],
		'validateOnSubmit' => true,
		'action'=>['/site/createlink'],
		'id'=>'create-link-form-id',
		'options'=>['class'=>'create-link-form']
		]); ?>
	<div class="form-input-group">
		<?= $form->field($model, 'source_link')->textInput(['maxlength' => true, 'placeholder'=>'Paste your link here', 'class'=>'form-group input-lg'])->label(false); ?>

		<?= Html::submitButton('Generate', ['class' => 'btn btn-primary btn-lg generate-button', 'style'=>'with: 20%']) ?>
		<div class="clearfix"></div>
	</div>
	

    <?php ActiveForm::end(); ?>
	
	<div class="h2 url_container"></div>

</div>
<?php
	$this->registerJs('$("form#create-link-form-id").on("beforeSubmit", function (e) {
		
		var form = $(this);
		var formData = form.serialize();
		$.ajax({
			url: form.attr("action"),
			type: form.attr("method"),
			data: formData,
			beforeSend: function (data) {
				$(".url_container").empty();
			},
			success: function (data) {
				
				if (data.message == "") {
					$(".url_container").html(data.link);
				} else {
					alert(data.message);
				}
			},
			error: function () {
				alert("Something has gone wrong");
			}
		});
	}).on("submit", function (e) {
		e.preventDefault();
	});');
?>
