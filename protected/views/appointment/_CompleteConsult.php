<style>
    .modal-dialog {
        width: 850px;
    }
</style>
<?php $this->widget('ext.modaldlg.EModalDlg'); ?>
<div class="register_container">
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true, // display a larger alert block?
        'fade' => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts' => array( // configurations per alert type
            'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'),
            'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'),
        ),
    )); ?>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        //'id'=>'doctor_consult',
        //'action'=>Yii::app()->createUrl('appointment/DoctorConsult'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            //'afterValidate'=>'js:yiiFix.ajaxSubmit.afterValidate'
        ),
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'add_item_form',
    )); ?>

    <?php if (Yii::app()->user->hasFlash('error')): ?>
        <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
    <?php endif; ?>
    <div class="col-sm-6">

        <?php //echo $form->textAreaControlGroup($visit, 'sympton',array('rows' => 1, 'cols' => 10, 'class' => 'span2',)); ?>

        <div>
            <?php echo $form->labelEx($visit,'sympton'); ?>
            <?php echo $form->textArea($visit,'sympton',array('rows' => 1, 'cols' => 10, 'class' => 'span2 symton-validate',)); ?>
        </div>
        <div id='error' style="color: red"></div>
        <br/>
        <!-- Request to remove from Samnag -->
        <?php //echo $form->textAreaControlGroup($visit, 'assessment', array('rows' => 1, 'cols' => 10, 'class' => 'span2')); ?>
    </div>

    <div class="col-sm-6">
        <!--<h4 class="header blue bolder smaller"><i class="ace-icon fa fa-key blue"></i><?php //echo Yii::t('app','Treatment Result') ?></h4>--->

        <?php //echo $form->textAreaControlGroup($visit, 'observation', array('rows' => 1, 'cols' => 10, 'class' => 'span2')); ?>
        <div>
            <?php echo $form->labelEx($visit,'observation'); ?>
            <?php echo $form->textArea($visit,'observation',array('rows' => 1, 'cols' => 10, 'class' => 'span2',)); ?>
        </div>
        <br/>

        <!-- Visit -->
        <?php //echo $form->textAreaControlGroup($visit, 'plan', array('rows' => 1, 'cols' => 10, 'class' => 'span2')); ?>
    </div>
    
    <div class="col-sm-12">
        <?php $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'Para-clinic'),
            //'headerIcon' => 'ace-icon fa fa-h-square',
            'headerButtons' => array(
                $this->renderpartial('_select_treatment',
                    array('treatment' => $treatment, 'treatment_items' => $treatment_items), true)
            ),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
            //'content' => $this->renderPartial('_form_treatment'),
        )); ?>

            <div class="grid-view" id="select_treatment_form">
                <?php $this->renderPartial('_ajax_treatment',
                    array('treatment_selected_items' => $treatment_selected_items, 'treatment' => $treatment,'visit_id'=>$visit_id), false) ?>
            </div>
        <?php $this->endWidget(); ?>
    </div>
    
    <div class="col-sm-12" id="medicine_form">
        <?php $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => 'Prescribe',
            //'headerIcon' => 'ace-icon fa fa-medkit',
            'headerButtons' => array(
                $this->renderpartial('_Medicine', array('medicine' => $medicine), true)
            ),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
            //'content' => $this->renderPartial('_form', array('model'=>$model,'model_search'=>$model_search,'leave_detail_wrapper'=>$leave_detail_wrapper,'employee_id'=>$employee_id), true),
        )); ?>
        <div id="select_medicine_form">
            <?php $this->renderPartial('_select_medicine',
                array('medicine_selected_items' => $medicine_selected_items, 'medicine' => $medicine,'visit_id'=>$visit_id), false); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>

    <div class="col-sm-12" id="lab_form">
        <?php $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => 'Lab Result',
            'headerIcon' => 'ace-icon fa fa-medkit',
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
            //'content' => $this->renderPartial('_form', array('model'=>$model,'model_search'=>$model_search,'leave_detail_wrapper'=>$leave_detail_wrapper,'employee_id'=>$employee_id), true),
        )); ?>
            <div id="lab_result_form">
                <?php $this->renderPartial('_labo_patient_result',array('LabResult'=>$LabResult,'visit_id'=>$visit_id), false); ?>
            </div>
        <?php $this->endWidget(); ?>        
    </div>
    <div class="col-sm-12">
        <div class="form-actions" id="form-actions">
            <?php echo TbHtml::submitButton($visit->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'id' => 'btn-submit',
                'name' => 'btn-submit'
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>


<?php
$url = Yii::app()->createUrl('Appointment/Addmedicine/visit_id/'.$visit_id);
Yii::app()->clientScript->registerScript('update_medicine', "
    $('#Item_id').on('change',function(e) {
        medicine_id=$('#Item_id').val();
        $.ajax({
            url:'$url', 
            dataType : 'json',    
            type : 'post',
            data : {medicine_id:medicine_id},
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                if(data.status=='success')
                {
                    $('#select_medicine_form').html(data.div_medicine_form);
                    $('#Item_id').select2('val', '');
                }    
            }
        });
    });
");
?>

<?php
Yii::app()->clientScript->registerScript('deleteMedicine', "
        $('div#select_medicine_form').on('click','a.delete-item',function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url:url,
            dataType:'json',
            type:'post',    
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success:function(data) {
                if(data.status=='success')
                {
                    $('#select_medicine_form').html(data.div_medicine_form);
                }
            }
        });
    });
");
?>

<?php
Yii::app()->clientScript->registerScript('deleteTreatment', "
        $('div#select_treatment_form').on('click','a.delete-treatment',function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url:url,
            dataType:'json',
            type:'post',    
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success:function(data) {
                if(data.status=='success')
                {
                    //$('#select_medicine_form').html(data.div_medicine_form);
                    $('#select_treatment_form').html(data.div_treatment_form);
                }
            }
        });
    });
");
?>

<?php
$url = Yii::app()->createUrl('Appointment/Addtreatment/visit_id/'.$visit_id);
Yii::app()->clientScript->registerScript('update_treament', "
    $('#Treatment_id').on('change',function(e) {
        treatment_id=$('#Treatment_id').val();
        //alert(treatment_id);
        $.ajax({
            url:'$url', 
            dataType : 'json',    
            type : 'post',
            data : {treatment_id:treatment_id},
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                if(data.status=='success')
                {
                    $('#select_treatment_form').html(data.div_treatment_form);
                    $('#Treatment_id').select2('val', '');  //clear select2 value http://bit.ly/1Gttc7X
                }    
            }
        });
    });
");
?>

<?php
$red_url = Yii::app()->createUrl('Appointment/waitingqueue/');
Yii::app()->clientScript->registerScript('completedConsult', "
        $('div#form-actions').on('click','a.completed-consult',function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url:url,
            dataType:'json',
            type:'post',    
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success:function(data) {
                if(data.status=='success')
                {
                    //$('#select_medicine_form').html(data.div_medicine_form);
                    window.location.href = '$red_url';
                }
            }
        });
    });
");
?>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function () {
        $('#sidebar-menu').on('click', 'a', function (e) {
            e.preventDefault();
            a_href = $(this).attr("href");
            var ans = confirm("You have unsaved changes, are you sure that you want to leave? All of your changes will be lost.");
            if (ans === true) {
                $.ajax({
                    type: "POST",
                    url: "Emptytreatment",
                    beforeSend: function() { $('.waiting').show(); },
                    complete: function() { $('.waiting').hide(); },
                    success: function () {
                        window.location.href = a_href;
                    }
                });
            }
        });

        $('.breadcrumbs').on('click', 'a', function (e) {
            e.preventDefault();
            a_href = $(this).attr("href");
            var ans = confirm("Your Data will lose if you leave this page! Are you sure you want to leave?");
            if (ans === true) {
                $.ajax({
                    type: "POST",
                    url: "Emptytreatment",
                    beforeSend: function() { $('.waiting').show(); },
                    complete: function() { $('.waiting').hide(); },
                    success: function () {
                        window.location.href = a_href;
                    }
                });
            }
        });
        
        $('.re-visit').on('click', function (e) {
            e.preventDefault();
            a_href = $(this).attr("href");
            //alert(a_href);
            var ans = confirm("Are you sure you want to submit?");
            if (ans === true) {
                $.ajax({
                    type: "POST",
                    url: a_href,
                    beforeSend: function() { $('.waiting').show(); },
                    complete: function() { $('.waiting').hide(); },
                    success: function () {
                        //window.location.href = a_href;
                        location.reload(); 
                    }
                });
            }
        });
        
    });

    $('#show-payment-modal').on('keypress', function (e) {
        if (e.keyCode === 13) {
            //e.preventDefault();
            //alert('dfdfd');
            //jQuery('#Completed_consult').click();
            $('button[type=submit] #Completed_consult').click();
            return false;
            //return false; 
            //Auto-click button element on page load using jQuery
        }
    });
    
    $("#Appointment_actual_amount").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                         // let it happen, don't do anything
                         return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
        }
    });

    $("#btn-submit").on('click',function(e) {
        e.preventDefault();
        //a_href = $(this).attr("href");
        var url='/index.php/appointment/DoctorConsult?visit_id=<?php echo $_GET['visit_id']; ?>&patient_id=<?php echo $_GET['patient_id']; ?>&doctor_id=<?php echo $_GET['doctor_id']; ?>';
        var return_url='waitingqueue';
        //finished_url=
        $.confirm({
            title: 'Confirm!',
            content: 'Please choose your operation with below button!',
            columnClass: 'col-md-6 col-md-offset-3',
            buttons: {
                Save: {
                    //text: 'Save',
                    btnClass: 'btn-success',
                    action: function(){
                        data = $('form').serialize();
                        $.ajax({
                            data:data+ "&Save_consult=" + true+'&ajax='+$('form').attr('id'),
                            type: "POST",
                            dataType: 'json',
                            url: url,
                            success: function (data) {
                                //var json = $.parseJSON(data);
                                if(data.Visit_sympton!=null)
                                {
                                    $('#error').html(data.Visit_sympton);
                                    $('.symton-validate').css({
                                        "border": "1px solid red",
                                        "background": "#FFCECE"
                                    });
                                }else{
                                    window.location.href = return_url;
                                    //window.location.href=data.redirect;
                                }
                            },
                            error:function(er){
                                window.location.href = return_url;
                            }
                        });
                    }
                },
                Complete: {
                    //btnClass: 'btn-success',
                    id:'Completed_consult',
                    name:'Completed_consult',
                    action: function(){
                        data = $('form').serialize();
                        $.ajax({
                            data:data+ "&Completed_consult=" + true+'&ajax='+$('form').attr('id'),
                            type: "POST",
                            dataType: 'json',
                            url: url,
                            success: function (data) {
                                if(data.Visit_sympton!=null)
                                {
                                    $('#error').html(data.Visit_sympton);
                                    $('.symton-validate').css({
                                        "border": "1px solid red",
                                        "background": "#FFCECE"
                                    });
                                }else{
                                    window.location.href = return_url;
                                    //window.location.href=data.redirect;
                                }
                            },
                            error:function(er){
                                window.location.href = return_url;
                            }
                        });
                    }
                },
                Cancel: function () {
                },
            }
        });
    });

    $(document).ready(function () {
        window.setTimeout(function() {
            $(".alert").fadeTo(2000, 0).slideUp(2000, function(){
                $(this).remove();
            });
        }, 2000);
    });
    
</script>  