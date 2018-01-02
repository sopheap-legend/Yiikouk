<?php
/* @var $this IPDBillController */
/* @var $model IPDBill */
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
		<?php echo $form->label($model,'admit_id'); ?>
		<?php echo $form->textField($model,'admit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_number'); ?>
		<?php echo $form->textField($model,'invoice_number',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bill_date'); ?>
		<?php echo $form->textField($model,'bill_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_amount'); ?>
		<?php echo $form->textField($model,'total_amount',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exchange_rate'); ?>
		<?php echo $form->textField($model,'exchange_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prepare_by'); ?>
		<?php echo $form->textField($model,'prepare_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->