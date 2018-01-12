<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
	<?php
		$this->breadcrumbs=array(
			Yii::t('menu','Bill')=>array('iPDBill/admin'),
			Yii::t('menu','Patient List'),
		);
	?>

	<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
		'title' => Yii::t('app','List of Patient'),
		'headerIcon' => 'ace-icon fa fa-credit-card',
		'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
		/*'headerButtons' => array(
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
		),*/
	));?>

	<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
		'id' => 'room_result',
		'dataProvider' => AdmitPatient::model()->getInPatient(),
		'htmlOptions' => array('class' => 'table-responsive panel'),
		'template' => "{items}",
		'columns' => array(
			array(
				'name' => 'id',
				'header' => 'ID',
				'headerHtmlOptions' => array('style' => 'display:none'),
				'htmlOptions' => array('style' => 'display:none'),
			),
			array(
				'name' => 'admit_id',
				'headerHtmlOptions' => array('style' => 'display:none'),
				'htmlOptions' => array('style' => 'display:none'),
			),
			array(
				'name' => 'patient_id',
				'headerHtmlOptions' => array('style' => 'display:none'),
				'htmlOptions' => array('style' => 'display:none'),
			),
			array(
				'name' => 'doctor_id',
				'headerHtmlOptions' => array('style' => 'display:none'),
				'htmlOptions' => array('style' => 'display:none'),
			),
			array('name'=>'patient_name',
				'header'=> 'Patient Name',
			),

			array('name'=>'display_id',
				'header'=> 'Patient ID',
			),
			array('name'=>'status',
				'header'=> 'Status',
			),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'<div class="hidden-sm hidden-xs btn-group">{Particular Bill}{One Bill}</div>',
				'htmlOptions'=>array('class'=>'nowrap'),
				'buttons' => array(
					'Particular Bill' => array(
						//'label' => 'Book',
						//'url'=>'Yii::app()->createUrl("/roomMaster/RoomBooking/",array("id"=>$data["id"]))',
						'url' =>'Yii::app()->createUrl("iPDBill/create",array("patient_id"=>$data["patient_id"],"admit_id"=>$data["admit_id"],"myPatial"=>"_select_particular_bill"))',
						//'icon' => 'ace-icon fa fa-book',
						'options' => array(
							'class'=>'btn btn-xs btn-primary',
							//'id'=>'room_booking'
						),
					),
					'One Bill' => array(
						//'label' => 'Book',
						//'url' =>'Yii::app()->createUrl("iPDBill/create",array("patient_id"=>$data["patient_id"],"admit_id"=>$data["admit_id"],"myPatial"=>"_select_particular_bill"))',
						//'icon' => 'ace-icon fa fa-book',
						'options' => array(
							'class'=>'btn btn-xs btn-success',
							//'id'=>'room_booking'
						),
					),
				),
			),
		),
	)); ?>

	<?php $this->endWidget(); ?>

</div>
