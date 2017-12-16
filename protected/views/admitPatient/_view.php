<?php
/* @var $this AdmitPatientController */
/* @var $data AdmitPatient */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('patient_id')); ?>:</b>
	<?php echo CHtml::encode($data->patient_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insurance_id')); ?>:</b>
	<?php echo CHtml::encode($data->insurance_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bed_id')); ?>:</b>
	<?php echo CHtml::encode($data->bed_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dept_id')); ?>:</b>
	<?php echo CHtml::encode($data->dept_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_id')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('provosional_diagnosis')); ?>:</b>
	<?php echo CHtml::encode($data->provosional_diagnosis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_admit')); ?>:</b>
	<?php echo CHtml::encode($data->date_admit); ?>
	<br />

	*/ ?>

</div>