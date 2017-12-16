<?php
/* @var $this AdmitPatientController */
/* @var $model AdmitPatient */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admit-patient-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'patient_id'); ?>
		<?php echo $form->textField($model,'patient_id'); ?>
		<?php echo $form->error($model,'patient_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insurance_id'); ?>
		<?php echo $form->textField($model,'insurance_id'); ?>
		<?php echo $form->error($model,'insurance_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bed_id'); ?>
		<?php echo $form->textField($model,'bed_id'); ?>
		<?php echo $form->error($model,'bed_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dept_id'); ?>
		<?php echo $form->textField($model,'dept_id'); ?>
		<?php echo $form->error($model,'dept_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doctor_id'); ?>
		<?php echo $form->textField($model,'doctor_id'); ?>
		<?php echo $form->error($model,'doctor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'provosional_diagnosis'); ?>
		<?php echo $form->textField($model,'provosional_diagnosis',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'provosional_diagnosis'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_admit'); ?>
		<?php echo $form->textField($model,'date_admit'); ?>
		<?php echo $form->error($model,'date_admit'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->