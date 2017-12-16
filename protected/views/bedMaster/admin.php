<style>
	.btn-group {
		display: flex !important;
	}
</style>
<div class="row" id="contact">
	<div class="col-xs-12 widget-container-col ui-sortable">
		<?php
		/* @var $this ContactController */
		/* @var $model Contact */
		$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
			'title' => Yii::t('app','List of Bed'),
			'headerIcon' => 'ace-icon fa fa-users',
			'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
		));
		?>
		<?php
		/* @var $this TreatmentController */
		/* @var $model Treatment */
		$this->breadcrumbs=array(
			Yii::t('menu','Master Room')=>array('admin'),
			Yii::t('app','Manage'),
		);

		Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#treatment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
		?>
		<?php //echo TbHtml::linkButton(Yii::t('app','Search'),array('class'=>'search-button btn','size'=>TbHtml::BUTTON_SIZE_SMALL,'icon'=>'ace-icon fa fa-search',)); ?>
		<div class="search-form" style="display:none">
			<?php $this->renderPartial('_search',array(
				'model'=>$model,
			)); ?>
		</div><!-- search-form -->
		<?php echo TbHtml::linkButton(Yii::t( 'app', 'Add New' ),array(
			'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
			'size'=>TbHtml::BUTTON_SIZE_SMALL,
			'icon'=>'glyphicon-plus white',
			'url'=>$this->createUrl('create'),
		)); ?>
		<?php if(Yii::app()->user->hasFlash('success')):?>
			<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
		<?php endif; ?>
		<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'treatment-grid',
			'dataProvider'=>$model->bedMaster(),
			'htmlOptions'=>array('class'=>'table-responsive panel'),
			'columns'=>array(
				array(
					'name' => 'id',
					'header' => 'ID',
					'headerHtmlOptions' => array('style' => 'display:none'),
					'htmlOptions' => array('style' => 'display:none'),
				),
				array('name'=>'bed_no',
					'header'=> 'Bed No',
				),
				array('name'=>'room_no',
					'header'=> 'Room No',
				),
				array('name'=>'floor',
					'header'=> 'Floor',
				),
				array('name'=>'room_type',
					'header'=> 'Category ID',
				),
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'<div class="hidden-sm hidden-xs btn-group">{edit}{cancel}</div>',
					'htmlOptions'=>array('class'=>'nowrap'),
					'buttons' => array(
						'edit' => array(
							'label'=>'Update',
							'url'=>'Yii::app()->createUrl("/bedMaster/Update/",array("id"=>$data["id"]))',
							'icon' => 'ace-icon fa fa-edit',
							'options' => array(
								'class'=>'btn btn-xs btn-info',
							),
						),
						'cancel' => array(
							'label'=>'Delete',
							'url'=>'Yii::app()->createUrl("/bedMaster/Delete/",array("id"=>$data["id"]))',
							'options' => array(
								'class'=>'btn btn-xs btn-danger',
							),
							'visible'=>'Yii::app()->user->checkAccess("contact.delete")',
						),
					)
				),
			),
		)); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>