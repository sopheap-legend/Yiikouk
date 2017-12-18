<?php echo $form->dropDownListControlGroup($model_popup,'complaint_id',
    CHtml::listData(ConfComplaint::model()->findall(),'id','complaint'),
    array(
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
    )
)
?>
<?php echo $form->textAreaControlGroup($model_popup,'remarks',array('span'=>5,'placeholder'=>'Remarks')); ?>