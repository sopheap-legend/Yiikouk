<?php
/* @var $this CategoryRoomController */
/* @var $model IpdTblCategoryRoom */

$this->breadcrumbs=array(
	'Ipd Tbl Category Rooms'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List IpdTblCategoryRoom', 'url'=>array('index')),
	array('label'=>'Create IpdTblCategoryRoom', 'url'=>array('create')),
	array('label'=>'Update IpdTblCategoryRoom', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete IpdTblCategoryRoom', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IpdTblCategoryRoom', 'url'=>array('admin')),
);
?>

<h1>View IpdTblCategoryRoom #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'room_type',
		'remarks',
	),
)); ?>
