<?php
$this->breadcrumbs=array(
	'Category'=>array('admin'),
	'Update',
);
?>

<?php
//$fullname = ucwords($model->first_name . ' ' . $model->last_name);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
	'title' => Yii::t('app','Update Category'),
	'headerIcon' => 'ace-icon fa fa-user',
	'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
	'content' => $this->renderPartial('_form', array('model'=>$model,'category_room' => $category_room), true),
)); ?>

<?php $this->endWidget(); ?>