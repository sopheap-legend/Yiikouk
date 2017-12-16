<?php
/* @var $this CategoryRoomController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ipd Tbl Category Rooms',
);

$this->menu=array(
	array('label'=>'Create IpdTblCategoryRoom', 'url'=>array('create')),
	array('label'=>'Manage IpdTblCategoryRoom', 'url'=>array('admin')),
);
?>

<h1>Ipd Tbl Category Rooms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
