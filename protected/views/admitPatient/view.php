<?php
/* @var $this AdmitPatientController */
/* @var $model AdmitPatient */

$this->breadcrumbs=array(
	'Admit Patients'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AdmitPatient', 'url'=>array('index')),
	array('label'=>'Create AdmitPatient', 'url'=>array('create')),
	array('label'=>'Update AdmitPatient', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AdmitPatient', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AdmitPatient', 'url'=>array('admin')),
);
?>

<h1>View AdmitPatient #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'patient_id',
		'insurance_id',
		'bed_id',
		'dept_id',
		'doctor_id',
		'status',
		'provosional_diagnosis',
		'comment',
		'date_admit',
	),
)); ?>
