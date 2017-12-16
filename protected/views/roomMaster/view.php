<?php
/* @var $this RoomMasterController */
/* @var $model IpdTblRoom */

$this->breadcrumbs=array(
	'Ipd Tbl Rooms'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List IpdTblRoom', 'url'=>array('index')),
	array('label'=>'Create IpdTblRoom', 'url'=>array('create')),
	array('label'=>'Update IpdTblRoom', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete IpdTblRoom', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IpdTblRoom', 'url'=>array('admin')),
);
?>

<h1>View IpdTblRoom #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'catg_room_id',
		'floor',
		'room_no',
		'total_bed',
		'price',
	),
)); ?>
