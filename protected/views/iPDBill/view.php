<?php
/* @var $this IPDBillController */
/* @var $model IPDBill */

$this->breadcrumbs=array(
	'Ipdbills'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List IPDBill', 'url'=>array('index')),
	array('label'=>'Create IPDBill', 'url'=>array('create')),
	array('label'=>'Update IPDBill', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete IPDBill', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IPDBill', 'url'=>array('admin')),
);
?>

<h1>View IPDBill #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'admit_id',
		'invoice_number',
		'bill_date',
		'total_amount',
		'discount',
		'exchange_rate',
		'prepare_by',
		'status',
	),
)); ?>
