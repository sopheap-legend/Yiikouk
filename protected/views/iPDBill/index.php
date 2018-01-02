<?php
/* @var $this IPDBillController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ipdbills',
);

$this->menu=array(
	array('label'=>'Create IPDBill', 'url'=>array('create')),
	array('label'=>'Manage IPDBill', 'url'=>array('admin')),
);
?>

<h1>Ipdbills</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
