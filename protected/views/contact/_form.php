<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>

<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form TbActiveForm */
?>
<?php //echo Yii::app()->request->baseUrl; ?>
<div class="form">

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), 
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
        ),
)); ?>
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'employee-form',
                'enableAjaxValidation'=>false,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,                
                'htmlOptions'=> array('enctype'=>'multipart/form-data',)
        )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <div class="col-sm-6">
            <h4 class="header blue"><i class="ace-icon fa fa-info-circle blue"></i><?php echo Yii::t('app','Patient Basic Information') ?></h4>
                
    <?php //echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'first_name',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'middle_name',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'last_name',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'display_name',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <div class="form-group">

                <label class="col-sm-3 control-label" for="Employee_dob"><?php echo Yii::t('app','Date of Birth') ?></label>

                <div class="col-sm-9">

                    <?php echo CHtml::activeDropDownList($model, 'day', Employee::itemAlias('day'), array('prompt' => yii::t('app','Day'))); ?>

                    <?php echo CHtml::activeDropDownList($model, 'month', Employee::itemAlias('month'), array('prompt' => yii::t('app','Month'))); ?>

                    <?php echo CHtml::activeDropDownList($model, 'year', Employee::itemAlias('year'), array('prompt' => yii::t('app','Year'))); ?>

                    <span class="help-block"> <?php echo $form->error($model,'dob'); ?> </span>

                </div>

            </div>

            <?php echo $form->textFieldControlGroup($model,'age',array('class'=>'span7 age-input','maxlength'=>40,'Placeholder'=>'Enter Age')); ?>
            
            <!--<div class="form-group"><label class="col-sm-3 control-label" for="dob"><?php /*echo Yii::t('app','Date Of Birth'); */?></label>
                <div class="col-md-9">
                    <?php /*$this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                    'attribute' => 'dob',
                    'model' => $model,
                    'pluginOptions' => array(
                            'format' => 'yyyy-mm-dd',
                        )
                    ));
                    */?>
                </div>  
            </div>-->
            
            <?php echo $form->dropDownListControlGroup($model,'sex',array('Female'=>'Female','Male'=>'Male'), array('class'=>'span7')) ?>

            <?php echo $form->textFieldControlGroup($model,'phone_number',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'email',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'type',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->dropDownListControlGroup($model,'type',array('Home'=>'Home','Office'=>'Office'), array('class'=>'span7')) ?>     
                
            <?php echo $form->textFieldControlGroup($model,'address_line_1',array('class'=>'span7','maxlength'=>300,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'address_line_2',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'city',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'state',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'postal_code',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>

            <?php //echo $form->textFieldControlGroup($model,'country',array('class'=>'span7','maxlength'=>40,'data-required'=>'true')); ?>
                
            <?php //echo $form->dropDownListControlGroup($model,'country',array('Cambodia'=>'Cambodia','Thailland'=>'Thailland'), array('class'=>'span7')) ?>

            <?php echo $form->dropDownListControlGroup($model,'nationality',array('Cambodian'=>'Cambodian','Thailland'=>'Thailland','England'), array('class'=>'span7')) ?>
    </div>
    <div class="col-sm-6">
        <?php
            if(!empty($model->image_name))
            {
                $image='ximages/'.$model->image_path.'/'.$model->image_name;
                if(file_exists($image))
                {
                    $path=$image;
                }else{
                    $path='ximages/default.jpg';
                }
            }else{
                $path='ximages/default.jpg';
            }
        ?>
        <h4 class="header blue bolder smaller"><i class="ace-icon fa fa-picture-o blue"></i><?php echo Yii::t('app','Patient Image') ?></h4>
        <div class="row">
            <div class="col-sm-12" align="middle">
                <?php echo TbHtml::imagePolaroid(Yii::app()->request->baseUrl.'/'.$path, '',array('width'=>170,'height'=>170,'class'=>'tmea','id'=>'blah'))?>
            </div>
            <div class="col-sm-12">
                <?php //echo $form->textFieldControlGroup($model,'image_path',array('disabled'=>true,'class'=>'span7','maxlength'=>200,'data-required'=>'true')); ?>
                <?php //echo $form->textFieldControlGroup($model,'image_name',array('disabled'=>true,'class'=>'span7','maxlength'=>200,'data-required'=>'true')); ?>
            </div>
            <div class="col-sm-12" align="middle">
                <?php //echo CHtml::activeFileField($model, 'image',array('class'=>'btn-primary')); ?>
                <label class="btn btn-info btn-file"><i class="glyphicon glyphicon-camera"></i><input type="file" name="Contact[image]" id="Contact_image" style="display: none;"></label>
                <label class="btn btn-danger btn-file" id="Cancel_image"><i class="glyphicon glyphicon-remove"></i></label>
            </div>
        </div> 
        <?php
            //echo CHtml::activeFileField($model, 'image');
        ?>
        <br/>
        <div class="row">
            <div class="col-sm-12" align="middle">
                <?php
                /*$this->widget('yiiwheels.widgets.fineuploader.WhFineUploader', array(
                    'model'=> $model,
                    'name' => 'image',
                    //'label' =>'test' ,
                    'uploadAction'  => $this->createUrl('site/upload', array('fine' => 1)),
                    'pluginOptions' => array(
                        'validation'=>array(
                            'allowedExtensions' => array('jpeg', 'jpg')
                        ),
                    ),
                ));*/
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
    <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
           'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'name'=>'btn-submit'
           //'size'=>TbHtml::BUTTON_SIZE_SMALL,
       )); ?>
    </div>
    </div>            
    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    //solution for show image before upload
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetURL() {
        $('#blah').attr('src', "/ximages/default.jpg").append();
    }

    $("#Contact_image").change(function(){
        readURL(this);
    });

    $("#Cancel_image").click(function(){
        $("#Contact_image").val('');
        resetURL();
    });

    $(".age-input").keydown(function (e) {
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
</script>
