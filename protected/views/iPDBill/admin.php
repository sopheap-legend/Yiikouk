<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
	<?php
		$this->breadcrumbs=array(
			Yii::t('menu','Bill')=>array('iPDBill/admin'),
			Yii::t('menu','Bill List'),
		);
	?>

	<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
		'title' => Yii::t('app','List of Bill'),
		'headerIcon' => 'ace-icon fa fa-credit-card',
		'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
		'headerButtons' => array(
			TbHtml::buttonGroup(
				array(
					array('label' => Yii::t('app','Particular Bill'),
						'url' =>Yii::app()->createUrl('iPDBill/create',array()),
						'icon'=>'ace-icon fa fa-cc-visa white',
						'color' => TbHtml::BUTTON_COLOR_PRIMARY,
						'size' => TbHtml::BUTTON_SIZE_SMALL,
						'class'=>'particular-bill',
					),
					array('label'=>' | ',
						'color' => TbHtml::BUTTON_COLOR_PRIMARY,
						'size' => TbHtml::BUTTON_SIZE_SMALL,
					),
					array('label'=>Yii::t('app','One Click Bill'),
						//'url' => $this->createUrl('contact/PatientHistory', array("id" => $_GET['patient_id'])),
						'icon'=>'ace-icon fa fa-list white',
						//'class' => 'update-dialog-open-link',
						//'data-update-dialog-title' => Yii::t('app', 'Patient History'),
						'color' => TbHtml::BUTTON_COLOR_SUCCESS,
						'size' => TbHtml::BUTTON_SIZE_SMALL,
					)
				)
			),
		),
	));?>




	<?php /*$this->widget('yiiwheels.widgets.grid.WhGridView',array(
		'id'=>'category-grid',
		//'fixedHeader' => true,
		'headerOffset' => 40,
		'responsiveTable' => true,
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		'columns'=>array(
			'id',
			'name',
			'created_date',
			'modified_date',
			array('class'=>'bootstrap.widgets.TbButtonColumn',
				//'template'=>'{update}{delete}{payment}',
				'buttons' => array(
					'update' => array(
						'click' => 'updateDialogOpen',
						'label'=>'Update Category',
						'options' => array(
							'data-update-dialog-title' => Yii::t( 'app', 'form.category._form.header_update' ),
							'data-refresh-grid-id'=>'category-grid',
						),
					),
				),
			),
		),
	));*/ ?>

	<?php $this->endWidget(); ?>

</div>
