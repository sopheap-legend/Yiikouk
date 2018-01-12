<?php
$url = Yii::app()->createUrl('IPDBill/AddBillItem?patient_id='.$data['patient_id'].'&admit_id='.$data['admit_id']);
//$url='#';
Yii::app()->clientScript->registerScript('update_particular_item', "
    $('#Treatment_id').on('change',function(e) {
        item_id=$('#Treatment_id').val();
        category=$('#IPDBill_category').val();
        //alert(item_id);
        $.ajax({
            url:'$url', 
            dataType : 'json',    
            type : 'post',
            data : {item_id:item_id,category:category},
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                if(data.status=='success')
                {
                    $('#display_particular_item').html(data.div_particular_item_form);
                    $('#Treatment_id').select2('val', '');
                }    
            }
        });
    });
");
?>

<?php
Yii::app()->clientScript->registerScript('deleteMedicine', "
        $('div#display_particular_item').on('click','a.delete-item',function(e) {
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
                    $('#display_particular_item').html(data.div_particular_item_form);
                }
            }
        });
    });
");
?>
