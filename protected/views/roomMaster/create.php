<?php
/* @var $this TreatmentController */
/* @var $model Treatment */
?>

<?php
$this->breadcrumbs=array(
	'Master Room'=>array('admin'),
	'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
	'title' => Yii::t('app','New Room'),
	'headerIcon' => 'ace-icon fa fa-user',
	'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
	'content' => $this->renderPartial('_form', array('model'=>$model,'category_room'=>$category_room), true),
)); ?>

<?php $this->endWidget(); ?>