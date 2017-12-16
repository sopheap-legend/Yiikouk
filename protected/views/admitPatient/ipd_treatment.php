<?php //print_r($data['model']); die(); ?>
<div class="row" id="show-flash-message"></div>
<?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'employee-form',
    'enableAjaxValidation'=>false,
    'layout'=>TbHtml::FORM_LAYOUT_VERTICAL,
));*/ ?>
<div class="row">
    <div class="col-sm-3">
        <?php
        $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app','IPD Treatment Tab'),
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
                    <?php echo TbHtml::labelTb(@$data['model_patient_info']['display_id'], array('color' => TbHtml::LABEL_COLOR_DEFAULT)); ?>
                        <input type="hidden" name="patient_id" class="patient_id" value="<?php echo @$data['model_patient_info']['patient_id']; ?>">
                    </label>
                </div>
                <div>
                    <label><u>Patient Name</u></label>
                </div>
                <div>
                    <?php echo TbHtml::labelTb(@$data['model_patient_info']['fullname'], array('color' => TbHtml::LABEL_COLOR_SUCCESS)); ?>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <?php $this->renderPartial('partial/_treatment_index',array(
                    'treat_mode'=>$treat_mode,
                    'admit_id'=>@$data['model_patient_info']['id'],
                    'patient_id'=>@$data['model_patient_info']['patient_id'],
                )
            ); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="col-sm-9">
        <?php
        $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app',$header_info),
            'headerIcon' => 'ace-icon fa fa-bars',
            'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
        ));
        ?>
            <?php $this->renderPartial($getPartial,array(
                    'model' => $data['model'],
                    'model_vital' => $data['model_vital'],
                    'model_patient_info' => $data['model_patient_info'],
                )
            ); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php //$this->endWidget(); ?>
