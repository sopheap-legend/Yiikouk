<?php //if(!empty($drd_floor)){$f_dropdown=CHtml::listData($drd_floor,'floor','floor');}else{$f_dropdown=array();}?>
<?php echo $form->dropDownListControlGroup($model_popup,'particular_category_id',
    CHtml::listData(ParticularCategory::model()->findall(),'id','particular_category'),
    array(
        'empty'=>'Select Category',
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
        'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('ParticularItem/Dynamicitem'),
            'update'=>'#BedSideProcedure_particular_item_id',
        )
    )
)
?>

<?php //if(!empty($drd_item)){$item_dropdown=CHtml::listData($drd_item,'id','particular_id');}else{$item_dropdown=array();}?>
<?php echo $form->dropDownListControlGroup($model_popup,'particular_item_id',array(),
    array(
        'empty'=>'Select particular Item',
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
        /*'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('BedMaster/Dynamicroom'),
            'update'=>'#IPRoomTransfer_room_id'
        )*/
    )
)
?>

<?php echo $form->textFieldControlGroup($model_popup,'qty',array('span'=>5,'placeholder'=>'Quantity')); ?>
<?php echo $form->textAreaControlGroup($model_popup,'note',array('span'=>5,'placeholder'=>'Note')); ?>
