<?php echo $form->dropDownListControlGroup($model_popup,'medication_id',
    CHtml::listData(item::model()->findall(),'id','name'),
    array(
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
    )
)
?>
<?php echo $form->textFieldControlGroup($model_popup,'instruction',array('span'=>5,'placeholder'=>'Instruction')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'advice',array('span'=>5,'placeholder'=>'Advice')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'days',array('span'=>5,'placeholder'=>'Number Days')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'qty',array('span'=>5,'placeholder'=>'Quantity')); ?>


