<?php
$this->breadcrumbs=array(
         Yii::t('menu','Patient')=>array('admin'),
	    'Update',
);
?>

<?php
    //$fullname = ucwords($model->first_name . ' ' . $model->last_name);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Update Patient'),
              'headerIcon' => 'ace-icon fa fa-user',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_form', array('model'=>$model,), true),
 )); ?>  

<?php $this->endWidget(); ?>