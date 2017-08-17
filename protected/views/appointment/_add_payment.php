<?php echo $form->textFieldControlGroup($model,'total_amount',array('rows'=>1 , 'cols'=>10, 'class'=>'span2','readonly'=>'readonly')); ?>
<?php echo $form->textFieldControlGroup($model,'actual_amount',array('mask'=>'000,000,000,000,000')); ?>

<?php /*$this->widget(
    'yiiwheels.widgets.maskinput.WhMaskInput',
    array(
        'model'=>$model,
        'name' => 'actual_amount',
        'mask' => '000,000,000,000,000',
    )
);*/?>

