<?php if(!empty($drd_floor)){$f_dropdown=CHtml::listData($drd_floor,'floor','floor');}else{$f_dropdown=array();}?>
<?php echo $form->dropDownListControlGroup($model_popup,'category_id',
    CHtml::listData(IpdTblCategoryRoom::model()->findall(),'id','room_type'),
    array(
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
        'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('BedMaster/Dynamicfloor'),
            'update'=>'#IPRoomTransfer_floor',
        )
    )
)
?>

<?php if(!empty($drd_floor)){$f_dropdown=CHtml::listData($drd_floor,'floor','floor');}else{$f_dropdown=array();}?>
<?php echo $form->dropDownListControlGroup($model_popup,'floor',$f_dropdown,
    array(
        'empty'=>'Select Floor',
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
        'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('BedMaster/Dynamicroom'),
            'update'=>'#IPRoomTransfer_room_id'
        )
    )
)
?>

<?php if(!empty($drd_room_no)){$r_dropdown=CHtml::listData($drd_room_no,'id','room_no');}else{$r_dropdown=array();}?>
<?php echo $form->dropDownListControlGroup($model_popup,'room_id',$r_dropdown,
    array(
        'empty'=>'Select Room',
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
        'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('BedMaster/Dynamicbed'),
            'update'=>'#IPRoomTransfer_bed_id'
        )
    )
)
?>

<?php if(!empty($drd_bed_no)){$b_dropdown=CHtml::listData($drd_bed_no,'id','bed_no');}else{$b_dropdown=array();}?>
<?php echo $form->dropDownListControlGroup($model_popup,'bed_id',$r_dropdown,
    array(
        'empty'=>'Select Bed',
        'span'=>5,'maxlength'=>30,
        'data-required'=>'true',
        /*'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('BedMaster/Dynamicfloor'),
            'update'=>'#Floor_id'
        )*/
    )
)
?>

<?php echo $form->textAreaControlGroup($model_popup,'reason',array('span'=>5)); ?>

<script>
    $('#IPRoomTransfer_category_id').on('change', function() {
        $('#IPRoomTransfer_room_id').empty().append($('<option>', {
            value: 0,
            text: 'Select Room'
        }, '</option>'));

        $('#IPRoomTransfer_bed_id').empty().append($('<option>', {
            value: 0,
            text: 'Select Bed'
        }, '</option>'));
    })
</script>
