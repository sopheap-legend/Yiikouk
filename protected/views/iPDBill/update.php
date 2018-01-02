<?php
/* @var $this IPDBillController */
/* @var $model IPDBill */

$this->breadcrumbs=array(
	'Ipdbills'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List IPDBill', 'url'=>array('index')),
	array('label'=>'Create IPDBill', 'url'=>array('create')),
	array('label'=>'View IPDBill', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage IPDBill', 'url'=>array('admin')),
);
?>

<h1>Update IPDBill <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>