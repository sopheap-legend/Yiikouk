<?php
/* @var $this RoomMasterController */
/* @var $model IpdTblRoom */
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
		<?php echo $form->label($model,'catg_room_id'); ?>
		<?php echo $form->textField($model,'catg_room_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor'); ?>
		<?php echo $form->textField($model,'floor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_no'); ?>
		<?php echo $form->textField($model,'room_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_bed'); ?>
		<?php echo $form->textField($model,'total_bed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->