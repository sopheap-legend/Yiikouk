<?php
/* @var $this TreatmentController */
/* @var $model Treatment */
/* @var $form TbActiveForm */
?>

<div class="form">
	<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		'alerts'=>array( // configurations per alert type
			'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
			'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
		),
	)); ?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'employee-form',
		'enableAjaxValidation'=>false,
		'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	)); ?>
	<?php echo $form->dropDownListControlGroup($category_room,'id',  CHtml::listData(IpdTblCategoryRoom::model()->findall(),'id','room_type'),
		array('span'=>5,'maxlength'=>30,'data-required'=>'true')) ?>

	<?php echo $form->textFieldControlGroup($model,'floor',array('span'=>5)); ?>
	<?php echo $form->textFieldControlGroup($model,'room_no',array('span'=>5)); ?>
	<?php echo $form->textFieldControlGroup($model,'total_bed',array('span'=>5)); ?>
	<?php echo $form->textFieldControlGroup($model,'price',array('span'=>5)); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
			'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
			//'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->