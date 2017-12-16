<?php
/* @var $this BedMasterController */
/* @var $model IpdTblBed */

$this->breadcrumbs=array(
	'Ipd Tbl Beds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List IpdTblBed', 'url'=>array('index')),
	array('label'=>'Create IpdTblBed', 'url'=>array('create')),
	array('label'=>'Update IpdTblBed', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete IpdTblBed', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IpdTblBed', 'url'=>array('admin')),
);
?>

<h1>View IpdTblBed #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'room_id',
		'bed_no',
		'status',
	),
)); ?>
