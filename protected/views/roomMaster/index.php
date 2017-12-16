<?php
/* @var $this RoomMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ipd Tbl Rooms',
);

$this->menu=array(
	array('label'=>'Create IpdTblRoom', 'url'=>array('create')),
	array('label'=>'Manage IpdTblRoom', 'url'=>array('admin')),
);
?>

<h1>Ipd Tbl Rooms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
