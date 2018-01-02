<?php
/* @var $this IPDBillController */
/* @var $model IPDBill */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ipdbill-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'admit_id'); ?>
		<?php echo $form->textField($model,'admit_id'); ?>
		<?php echo $form->error($model,'admit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_number'); ?>
		<?php echo $form->textField($model,'invoice_number',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'invoice_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bill_date'); ?>
		<?php echo $form->textField($model,'bill_date'); ?>
		<?php echo $form->error($model,'bill_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_amount'); ?>
		<?php echo $form->textField($model,'total_amount',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'total_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exchange_rate'); ?>
		<?php echo $form->textField($model,'exchange_rate'); ?>
		<?php echo $form->error($model,'exchange_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prepare_by'); ?>
		<?php echo $form->textField($model,'prepare_by'); ?>
		<?php echo $form->error($model,'prepare_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->