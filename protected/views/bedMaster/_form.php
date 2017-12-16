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
	<?php if(@$bed_update_form=='bed_update_form')$disabled='disabled' ?>
	<?php echo $form->dropDownListControlGroup($category_room,'id',
			CHtml::listData(IpdTblCategoryRoom::model()->findall(),'id','room_type'),
			array(
				'span'=>5,'maxlength'=>30,
				'data-required'=>'true',
				'disabled'=>@$disabled,
				'ajax' => array(
					'type'=>'POST', //request type
					'url'=>CController::createUrl('BedMaster/Dynamicfloor'),
					'update'=>'#IpdTblRoom_floor',
				)
			)
		)
	?>
	<?php if(!empty($drd_floor)){$f_dropdown=CHtml::listData($drd_floor,'floor','floor');}else{$f_dropdown=array();}?>
	<?php echo $form->dropDownListControlGroup($room_master,'floor',$f_dropdown,
		array(
			'empty'=>'Select Floor',
			'span'=>5,'maxlength'=>30,
			'data-required'=>'true',
			'disabled'=>@$disabled,
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('BedMaster/Dynamicroom'),
				'update'=>'#IpdTblRoom_id'
			)
		)
	)
	?>
	<?php if(!empty($drd_room_no)){$r_dropdown=CHtml::listData($drd_room_no,'id','room_no');}else{$r_dropdown=array();}?>
	<?php echo $form->dropDownListControlGroup($room_master,'id',$r_dropdown,
		array(
			'empty'=>'Select Room',
			'span'=>5,'maxlength'=>30,
			'data-required'=>'true',
			'disabled'=>@$disabled,
			/*'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('BedMaster/Dynamicfloor'),
				'update'=>'#Floor_id'
			)*/
		)
	)
	?>

	<?php //echo $form->textFieldControlGroup($model,'floor',array('span'=>5)); ?>
	<?php //echo $form->textFieldControlGroup($model,'room_id',array('span'=>5)); ?>
	<?php echo $form->textFieldControlGroup($model,'bed_no',array('span'=>5)); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
			'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
			//'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	$('#IpdTblCategoryRoom_id').on('change', function() {
		$('#IpdTblRoom_id').empty().append($('<option>', {
			value: 0,
			text: 'Select Room'
		}, '</option>'))
	})
</script>