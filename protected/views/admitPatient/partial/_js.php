<?php
$url = Yii::app()->createUrl('roomMaster/RoomChecking/');
Yii::app()->clientScript->registerScript('update_room', "
    $('#category_room_id').on('change',function(e) {
        category_room_id=$('#category_room_id').val();
        status=$('#room_status').val();
        $.ajax({
            url:'$url', 
            dataType : 'json',    
            type : 'post',
            data : {category_room_id:category_room_id,room_status:status},
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                if(data.status=='success')
                {
                    $('#display_room').html(data.div_category_room); 
                }    
            }
        });
    });
");


Yii::app()->clientScript->registerScript('update_room_status', "
    $('#room_status').on('change',function(e) {
        category_room_id=$('#category_room_id').val();
        status=$('#room_status').val();
        $.ajax({
            url:'$url', 
            dataType : 'json',    
            type : 'post',
            data : {category_room_id:category_room_id,room_status:status},
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                if(data.status=='success')
                {
                    $('#display_room').html(data.div_category_room); 
                }    
            }
        });
    });
");
?>

<script>
    $('div#display_room').on('click','a',function(e){
        e.preventDefault();
        //alert($(this).attr('href'));
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            dataType : 'json',
            type : 'post',
            success: function(result){
                if(result.status=='success')
                {
                    $('#IpdTblRoom_room_no').val(result.room_no);
                    $('#IpdTblBed_bed_no').val(result.bed_no);
                    $('#IpdTblBed_id').val(result.bed_id);
                    $('#show-flash-message').html('<?php $this->widget("bootstrap.widgets.TbAlert", array(
                        "block"=>true, // display a larger alert block?
                        "fade"=>true, // use transitions?
                        "closeText"=>"&times;", // close link text - if set to false, no close link is displayed
                        "alerts"=>array( // configurations per alert type
                            "success"=>array("block"=>true, "fade"=>true, "closeText"=>"&times;"),
                            //"error"=>array("block"=>true, "fade"=>true, "closeText"=>"&times;"),
                        ),
                    )); ?>');
                }
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