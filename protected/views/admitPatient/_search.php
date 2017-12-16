<?php
/* @var $this AdmitPatientController */
/* @var $model AdmitPatient */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'patient_id'); ?>
		<?php echo $form->textField($model,'patient_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insurance_id'); ?>
		<?php echo $form->textField($model,'insurance_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bed_id'); ?>
		<?php echo $form->textField($model,'bed_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dept_id'); ?>
		<?php echo $form->textField($model,'dept_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doctor_id'); ?>
		<?php echo $form->textField($model,'doctor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'provosional_diagnosis'); ?>
		<?php echo $form->textField($model,'provosional_diagnosis',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_admit'); ?>
		<?php echo $form->textField($model,'date_admit'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->