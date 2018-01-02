<style type="text/css">
    .bootstrap-timepicker-widget.dropdown-menu {
        z-index: 1050!important;
    }
</style>
<!-- http://bit.ly/2BKulh9 to solve timepicker show behind modal-->
<div class="row">
    <label class="col-sm-3 control-label required" for="OperationTheater_date_operation">Date Operation <span class="required">*</span></label>
    <div class="col-md-5">
        <div class="input-append">
            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                'model'=>$model_popup,
                'attribute' => 'date_operation',
                'pluginOptions' => array(
                    'format' => 'yyyy-mm-dd'
                )
            ));
            ?>
            <span class="add-on"><icon class="icon-calendar"></icon></span>
            <label style="color:red"><?php echo $form->error($model_popup,'date_operation'); ?></label>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-3 control-label required" for="OperationTheater_from_time">From Tme <span class="required">*</span></label>
    <div class="col-md-5">
        <?php $this->widget(
            'yiiwheels.widgets.timepicker.WhTimePicker',
            array(
                'model'=>$model_popup,
                'attribute' => 'from_time',
                'pluginOptions'=>array(
                    'showMeridian'=>false
                ),
            )
        );?>
        <label style="color:red"><?php echo $form->error($model_popup,'from_time'); ?></label>
    </div>
</div>
<div class="row">
    <label class="col-sm-3 control-label required" for="OperationTheater_to_time">To Tme <span class="required">*</span></label>
    <div class="col-md-5">
        <?php $this->widget(
            'yiiwheels.widgets.timepicker.WhTimePicker',
            array(
                'model'=>$model_popup,
                'attribute' => 'to_time',
                'pluginOptions'=>array(
                    'showMeridian'=>false
                ),
            )
        );?>
        <label style="color:red"><?php echo $form->error($model_popup,'to_time'); ?></label>
    </div>
</div>
<?php echo $form->dropDownListControlGroup($model_popup,'diagnosis_id',
    CHtml::listData(ConfDiagnosis::model()->findall(),'id','diagnosis'),
    array(
        'empty'=>'Select Diagnosis',
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
    )
)
?>
<?php echo $form->textFieldControlGroup($model_popup,'operation_name',array('span'=>5,'placeholder'=>'Operation Name')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'name_surgeon',array('span'=>5,'placeholder'=>'Name Surgeon')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'name_anesthesia',array('span'=>5,'placeholder'=>'Name Anesthesia')); ?>
<?php echo $form->dropDownListControlGroup($model_popup,'assistant1',  CHtml::listData(AdmitPatient::model()->getAssistant(),'id','assistant_name'),
    array('span'=>5,'maxlength'=>30,'data-required'=>'true','empty'=>'Select Assistant1')) ?>
<?php echo $form->dropDownListControlGroup($model_popup,'assistant2',  CHtml::listData(AdmitPatient::model()->getAssistant(),'id','assistant_name'),
    array('span'=>5,'maxlength'=>30,'data-required'=>'true','empty'=>'Select Assistant2')) ?>
<?php echo $form->dropDownListControlGroup($model_popup,'assistant3',  CHtml::listData(AdmitPatient::model()->getAssistant(),'id','assistant_name'),
    array('span'=>5,'maxlength'=>30,'data-required'=>'true','empty'=>'Select Assistant3')) ?>
<?php echo $form->dropDownListControlGroup($model_popup,'assistant4',  CHtml::listData(AdmitPatient::model()->getAssistant(),'id','assistant_name'),
    array('span'=>5,'maxlength'=>30,'data-required'=>'true','empty'=>'Select Assistant4')) ?>
<?php echo $form->textAreaControlGroup($model_popup,'operation_procedure',array('span'=>5,'placeholder'=>'Operation Procedure')); ?>
<?php echo $form->textAreaControlGroup($model_popup,'note',array('span'=>5,'placeholder'=>'Note')); ?>
