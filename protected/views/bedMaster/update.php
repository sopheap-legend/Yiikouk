<?php
$this->breadcrumbs=array(
	'Master Room'=>array('admin'),
	'Update',
);
?>

<?php
//$fullname = ucwords($model->first_name . ' ' . $model->last_name);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
	'title' => Yii::t('app','Update Bed'),
	'headerIcon' => 'ace-icon fa fa-user',
	'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
	'content' => $this->renderPartial('_form', array('model'=>$model,
					'category_room' => $category_room,
					'room_master'=>$room_master,
					'drd_room_no'=>$drd_room_no,
					'drd_floor'=>$drd_floor,
					'bed_update_form'=>'bed_update_form'
				), true),
)); ?>

<?php $this->endWidget(); ?>