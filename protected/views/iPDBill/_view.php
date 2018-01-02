<?php
/* @var $this IPDBillController */
/* @var $data IPDBill */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admit_id')); ?>:</b>
	<?php echo CHtml::encode($data->admit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_number')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_date')); ?>:</b>
	<?php echo CHtml::encode($data->bill_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_amount')); ?>:</b>
	<?php echo CHtml::encode($data->total_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount')); ?>:</b>
	<?php echo CHtml::encode($data->discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exchange_rate')); ?>:</b>
	<?php echo CHtml::encode($data->exchange_rate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('prepare_by')); ?>:</b>
	<?php echo CHtml::encode($data->prepare_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>