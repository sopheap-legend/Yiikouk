<style type="text/css">
    label{
        font-size: 12px;
    }

    label strong{
        font-size: 15px;
        color: blue;
    }

    /*.fixedheader {
        position: fixed;
        background: none repeat scroll red;
        width: calc(100% - 40px);
    }*/

</style>

<?php $this->breadcrumbs = array(
    'Laboratory' => array('labocheck'),
    'Lab Analized Sheet',
);
?>
<div class="form">
    <div class="row">
        <div class="col-sm-12">
            <div class="widget-box">
                <div class="widget-header widget-header-flat widget-header-small">
                    <i class="ace-icon fa fa-stethoscope"></i>
                    <h4 class="widget-title">Patient Name : <?php echo ucwords($patient_name); ?></h4>
                </div>
                <div class="profile-user-info profile-user-info-striped">
                    <ul class="list-unstyled spaced">
                        <?php foreach ($treatment_selected_items as $id => $item): ?>
                            <li>
                                <h2> <i class="ace-icon fa fa-check icon-animated-bell bigger-110 orange"></i><?php echo $item['treatment']; ?></h2>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'action'=>Yii::app()->createUrl('appointment/CompletedLab/visit_id/'.$visit_id),
        'id'=>'bloodtest-form',
        'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions'=> array('enctype'=>'multipart/form-data','class' =>'form-transp-input',)
    )); ?>
        <?php
        $result=array();
        $hemograme=array();
        foreach ($lab_selected  as $key=>$value)
        {
            $result[$value['blood_id']]=$value;
            if(!in_array($value['t_group_id'], $hemograme))
            {
                $hemograme[]=$value['t_group_id'];
                //array_push($hemograme,$value['t_group_id']);
            }
        }
        ?>
        <?php $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => 'Lab Analyzed Sheet',
            'headerIcon' => 'ace-icon fa fa-medkit',
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
            //'content' => $this->renderPartial('_form', array('model'=>$model,'model_search'=>$model_search,'leave_detail_wrapper'=>$leave_detail_wrapper,'employee_id'=>$employee_id), true),
        )); ?>
        <div class="container">
            <div class="col-sm-10" id="lab-analyzed">
                <?php foreach ($hemograme as $k=>$hemograme_val){  ?>
                    <?php foreach (TreatmentGroup::model()->findAll("id=$hemograme_val") as $k=>$tgroup_val){ ?>
                        <label class="control-label" for="<?php echo $tgroup_val->group_name; ?>">
                            <strong><u><?php echo $tgroup_val->group_name; ?></u></strong>
                        </label>
                        <?php foreach ($lab_selected as $lab_selected_val){ ?>
                            <?php if($lab_selected_val['t_group_id']==$hemograme_val){ ?>
                                <?php
                                    $treatment_item=trim($lab_selected_val['treatment_item']);
                                    $lab_item_id=$result[$lab_selected_val['blood_id']]['id'];
                                ?>
                                <?php if($lab_selected_val['blood_id']==4){ ?>
                                    <div>
                                        <?php echo TbHtml::label($lab_selected_val['treatment_item'], 'text'); ?>:
                                        <?php echo TbHtml::textField("itemtest[$treatment_item][$lab_item_id]", LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item,$lab_item_id), array('class'=>"form-control",'placeholder'=>$treatment_item)); ?>
                                        <?php echo TbHtml::label('Rh', 'text'); ?>
                                        <?php echo TbHtml::textField("itemtest[$treatment_item".' Rh'."][$lab_item_id]",LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' Rh',$lab_item_id) , array('class'=>"form-control",'placeholder'=>$treatment_item.' Rh')); ?>
                                    </div>
                                <?php }elseif($lab_selected_val['blood_id']==16 || $lab_selected_val['blood_id']==17){ ?>
                                    <div>
                                        <?php echo TbHtml::label($lab_selected_val['treatment_item'], 'text'); ?>:
                                        <div class="input-group">
                                            <?php echo TbHtml::textField("itemtest[$treatment_item".' mm'."][$lab_item_id]", LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' mm',$lab_item_id), array('class'=>"form-control",'placeholder'=>$treatment_item.' mm')); ?>
                                            <span class="input-group-addon">
                                                <?php echo TbHtml::label('mm', 'text'); ?>
                                            </span>
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <?php echo TbHtml::textField("itemtest[$treatment_item".' sec'."][$lab_item_id]", LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' sec',$lab_item_id), array('class'=>"form-control",'placeholder'=>$treatment_item.' sec')); ?>
                                            <span class="input-group-addon">
                                                <?php echo TbHtml::label($lab_selected_val['caption'], 'text'); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php }elseif($lab_selected_val['blood_id']==19){ ?>
                                    <div>
                                        <?php echo TbHtml::label($lab_selected_val['treatment_item'], 'text'); ?>:
                                        <div class="row">
                                            <div class="col-sm-11 col-sm-offset-1">
                                                <?php echo TbHtml::label('IgG', 'text'); ?>:
                                                <?php echo TbHtml::textField("itemtest[$treatment_item".' IgG'."][$lab_item_id]",LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' IgG',$lab_item_id) , array('class'=>"form-control",'placeholder'=>'IgG')); ?>
                                            </div>
                                            <div class="col-sm-11 col-sm-offset-1">
                                                <?php echo TbHtml::label('IgM', 'text'); ?>:
                                                <?php echo TbHtml::textField("itemtest[$treatment_item".' IgM'."][$lab_item_id]",LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' IgM',$lab_item_id) , array('class'=>"form-control",'placeholder'=>'IgM')); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }elseif($lab_selected_val['blood_id']==29){ ?>
                                    <div>
                                        <?php echo TbHtml::label($lab_selected_val['treatment_item'], 'text'); ?>:
                                        <div class="row">
                                            <div class="col-sm-11 col-sm-offset-1">
                                                <?php echo TbHtml::label('To', 'text'); ?>:
                                                <?php echo TbHtml::textField("itemtest[$treatment_item".' To'."][$lab_item_id]",LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' To',$lab_item_id) , array('class'=>"form-control",'placeholder'=>'To')); ?>
                                            </div>
                                            <div class="col-sm-11 col-sm-offset-1">
                                                <?php echo TbHtml::label('TH', 'text'); ?>:
                                                <?php echo TbHtml::textField("itemtest[$treatment_item".' TH'."][$lab_item_id]",LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' TH',$lab_item_id) , array('class'=>"form-control",'placeholder'=>'TH')); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }elseif($lab_selected_val['blood_id']==44){ ?>
                                    <div>
                                        <?php echo TbHtml::label($lab_selected_val['treatment_item'], 'text'); ?>:
                                        <div class="row">
                                            <div class="col-sm-11 col-sm-offset-1">
                                                <?php echo TbHtml::label('SGOT(ASAT)', 'text'); ?>:
                                                <div class="input-group">
                                                    <?php echo TbHtml::textField("itemtest[$treatment_item".' SGOT(ASAT)'."][$lab_item_id]",LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' SGOT(ASAT)',$lab_item_id) , array('class'=>"form-control",'placeholder'=>'SGOT(ASAT)')); ?>
                                                    <span class="input-group-addon">
                                                        <?php echo TbHtml::label('UI/L(8-33)', 'text'); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-11 col-sm-offset-1">
                                                <?php echo TbHtml::label('SGPT(ALAT)', 'text'); ?>:
                                                <div class="input-group">
                                                    <?php echo TbHtml::textField("itemtest[$treatment_item".' SGPT(ALAT)'."][$lab_item_id]",LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item.' SGPT(ALAT)',$lab_item_id) , array('class'=>"form-control",'placeholder'=>'SGPT(ALAT)')); ?>
                                                    <span class="input-group-addon">
                                                        <?php echo TbHtml::label('UI/L(3-35)', 'text'); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <?php if(isset($lab_selected_val['caption'])){ ?>
                                        <div>
                                            <?php echo TbHtml::label($lab_selected_val['treatment_item'], 'text'); ?>:
                                            <div class="input-group">
                                                <?php echo TbHtml::textField("itemtest[$treatment_item][$lab_item_id]", LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item,$lab_item_id), array('class'=>"form-control",'placeholder'=>$treatment_item)); ?>
                                                <span class="input-group-addon">
                                                        <?php echo TbHtml::label($lab_selected_val['caption'], 'text'); ?>
                                                    </span>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div>
                                            <?php echo TbHtml::label($lab_selected_val['treatment_item'], 'text'); ?>:
                                            <?php echo TbHtml::textField("itemtest[$treatment_item][$lab_item_id]", LabAnalyzedResult::model()->getClientResult(@$visit_id,$treatment_item,$lab_item_id), array('class'=>"form-control",'placeholder'=>$treatment_item)); ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php
            if(empty($lab_selected))
            {
                echo "<tr><td>No Lab Item was selected!</td></tr>";
            }//else{
        ?>
            <?php //$chk_lab = TransactionLog::model()->find("visit_id=:visit_id",array('visit_id'=>$_GET['visit_id'])); ?>
            <?php //if(empty($chk_lab)){?>
                <div class="col-sm-12">
                    <div class="form-actions" id="form-actions">
                        <?php echo TbHtml::submitButton(Yii::t('app', 'Save'), array(
                            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                            'size' => TbHtml::BUTTON_SIZE_SMALL,
                            'id' => 'save-labo-form',
                            'name' => 'Save_labo',
                            //'disabled'=>$disabled
                            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
                        )); ?>
                    </div>
                </div>
            <?php //} ?>
        <?php //} ?>
        <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>
</div>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $('#save-labo-form').on('click',function(e) {
            var isValid = true;
            $('input[type="text"]').each(function() {
                var dis=$(this).attr('disabled');
                if (dis!='disabled')
                {
                    if ($.trim($(this).val()) == '') {
                        isValid = false;
                        $(this).css({
                            "border": "1px solid red",
                            "background": "#FFCECE"
                        });

                        //Validate input field
                        //http://bit.ly/1FIzQaX
                    }
                    else {
                        $(this).css({
                            "border": "",
                            "background": ""
                        });
                    }
                }
            });
            if (isValid == false)
            {
                e.preventDefault();
            }
        });
    });
</script>

<div class="waiting"><!-- Place at bottom of page --></div>