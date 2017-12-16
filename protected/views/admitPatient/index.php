<?php
/* @var $this AdmitPatientController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Admit Patients',
);

$this->menu=array(
	array('label'=>'Create AdmitPatient', 'url'=>array('create')),
	array('label'=>'Manage AdmitPatient', 'url'=>array('admin')),
);
?>

<h1>Admit Patients</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
