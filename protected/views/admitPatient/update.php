<?php
/* @var $this AdmitPatientController */
/* @var $model AdmitPatient */

$this->breadcrumbs=array(
	'Admit Patients'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdmitPatient', 'url'=>array('index')),
	array('label'=>'Create AdmitPatient', 'url'=>array('create')),
	array('label'=>'View AdmitPatient', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AdmitPatient', 'url'=>array('admin')),
);
?>

<h1>Update AdmitPatient <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>