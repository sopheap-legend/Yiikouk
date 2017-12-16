<?php
/* @var $this BedMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ipd Tbl Beds',
);

$this->menu=array(
	array('label'=>'Create IpdTblBed', 'url'=>array('create')),
	array('label'=>'Manage IpdTblBed', 'url'=>array('admin')),
);
?>

<h1>Ipd Tbl Beds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
