<?php //print_r($data['particular_item_selected']); ?>
<div class="row" id="show-flash-message"></div>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'employee-form',
	'enableAjaxValidation'=>false,
	'layout'=>TbHtml::FORM_LAYOUT_VERTICAL,
)); ?>
<div class="row">
	<div class="col-sm-3">
		<?php
		$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
			'title' => Yii::t('app','IPD Patient Info'),
			'headerIcon' => 'ace-icon fa fa-pencil-square-o',
			'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
		));
		?>
		<div class="row">
			<div class="col-sm-6">
				<?php echo TbHtml::imagePolaroid(Yii::app()->request->baseUrl.'/ximages/Patient-Male.ico', '',array('style'=>'border: none','width'=>120,'height'=>120,'class'=>'tmea','id'=>'blah'))?>
			</div>
			<div class="col-sm-6">
				<div>
					<label><u>Patient No</u></label>
				</div>
				<div>
					<?php echo TbHtml::labelTb(@$data['PatientInfo']->display_id, array('color' => TbHtml::LABEL_COLOR_DEFAULT)); ?>
				</div>
				<div>
					<label><u>Patient Name</u></label>
				</div>
				<div>
					<?php echo TbHtml::labelTb(@$data['PatientInfo']->fullname, array('color' => TbHtml::LABEL_COLOR_SUCCESS)); ?>
				</div>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-xs-12">
				<?php //echo $form->textFieldControlGroup($model,'id',array('span'=>5,'disabled'=>true)); ?>

				<?php /*echo $form->dropDownListControlGroup($model,'dept_id',  CHtml::listData(Department::model()->findall(),'id','department_name'),
					array('span'=>5,'maxlength'=>30,'data-required'=>'true'))*/ ?>

				<?php /*echo $form->dropDownListControlGroup($model,'doctor_id',  CHtml::listData(AdmitPatient::model()->getDoctor(),'id','doctor_name'),
					array('span'=>5,'maxlength'=>30,'data-required'=>'true'))*/ ?>

				<?php //echo $form->textFieldControlGroup($model_room,'room_no',array('span'=>5,'disabled'=>true,'placeholder'=>'Room Name/No')); ?>
				<?php //echo $form->textFieldControlGroup($model_bed,'id',array('span'=>5,'style'=>'display:none','label'=>false)); ?>
				<?php //echo $form->textFieldControlGroup($model_bed,'bed_no',array('span'=>5,'disabled'=>true,'placeholder'=>'Bed Name/No')); ?>
				<?php //echo $form->textAreaControlGroup($model,'provosional_diagnosis',array('span'=>5)); ?>
				<?php //echo $form->textAreaControlGroup($model,'comment',array('span'=>5)); ?>
			</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
	<div class="col-sm-9">
		<?php
		$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
			'title' => Yii::t('app','Generate Bill'),
			'headerIcon' => 'ace-icon fa fa-bars',
			'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
		));
		?>
		<div class="row">
			<div class="col-sm-12" id="search_room">
				<?php $this->renderPartial('partial/'.$data['patial'],array(
					'data'=>@$data,
				)); ?>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-sm-12" id="display_particular_item">
				<?php $this->renderPartial('partial/_bill_item',array(
					'data'=>$data,
					//'particular_item_selected'=>@$particular_item_selected,
				)); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-actions" id="form-actions">
					<?php echo TbHtml::submitButton(Yii::t('app', 'Submit'), array(
						'color' => TbHtml::BUTTON_COLOR_PRIMARY,
						'size' => TbHtml::BUTTON_SIZE_SMALL,
						'id' => 'btn-submit',
						'name' => 'btn-submit'
						//'size'=>TbHtml::BUTTON_SIZE_SMALL,
					)); ?>
				</div>
			</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('partial/_js',array('data'=>$data)); ?>