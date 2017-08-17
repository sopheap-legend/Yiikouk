<?php
/* @var $this TreatmentItemDetailController */
/* @var $model TreatmentItemDetail */
?>
<?php

$this->breadcrumbs=array(
	'Lab Details'=>array('admin'),
	'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
	'title' => Yii::t('app','New Patient'),
	'headerIcon' => 'ace-icon fa fa-user',
	'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
	'content' => $this->renderPartial('_form', array('model'=>$model,'group'=>$group), true),
)); ?>

<?php $this->endWidget(); ?>