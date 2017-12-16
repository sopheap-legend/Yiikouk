<strong style="color:red"><?php //echo $form->error($vital,'general_error'); ?></strong>
<strong style="color:red"><?php //echo $form->errorSummary($model->general_error); ?></strong>
<?php //echo $form->textFieldControlGroup($vital,'general_error',array('span'=>5,'style' => 'display:none','label'=>false)); ?>
<?php ///$model_popup->admit_id= @$admit_id?>
<?php //echo $form->textFieldControlGroup($vital,'admit_id',array('span'=>5,)); ?>
<?php //echo $form->textFieldControlGroup($model_popup,'admit_id',array('span'=>5,'style' => 'display:none','label'=>false)); ?>
<?php echo $form->dropDownListControlGroup($model_popup,'diagnosis_id',
    CHtml::listData(ConfDiagnosis::model()->findall(),'id','diagnosis'),
    array(
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
    )
)
?>

<?php echo $form->textAreaControlGroup($model_popup,'remarks',array('span'=>5,'placeholder'=>'Remarks')); ?>

