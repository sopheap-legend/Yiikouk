<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'id' => 'room_result',
    'dataProvider' => $roomEnquiry,
    'htmlOptions' => array('class' => 'table-responsive panel'),
    'template' => "{items}",
    'columns' => array(
        array(
            'name' => 'id',
            'header' => 'ID',
            'headerHtmlOptions' => array('style' => 'display:none'),
            'htmlOptions' => array('style' => 'display:none'),
        ),
        array(
            'name' => 'bed_no',
            'header' => 'Bed No',
        ),
        array(
            'name' => 'room_no',
            'header' => 'Room No',
        ),
        array(
            'name' => 'floor',
            'header' => 'Floor',
        ),
        array(
            'name' => 'room_type',
            'header' => 'Room Category',
        ),
        array(
            'name' => 'total_bed',
            'header' => 'Total Bed in Room',
        ),
        array(
            'name' => 'status',
            'header' => 'Room Status',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'<div class="hidden-sm hidden-xs btn-group">{book}</div>',
            'htmlOptions'=>array('class'=>'nowrap'),
            'buttons' => array(
                /*'detail' => array(
                    'label' => 'Detail',
                    //'url'=>'Yii::app()->createUrl("/roomMaster/Update/",array("id"=>$data["id"]))',
                    //'icon' => 'ace-icon fa fa-edit',
                    'options' => array(
                        'class'=>'btn btn-xs btn-info',
                    ),
                ),*/
                'book' => array(
                    //'label' => 'Book',
                    'url'=>'Yii::app()->createUrl("/roomMaster/RoomBooking/",array("id"=>$data["id"]))',
                    'icon' => 'ace-icon fa fa-book',
                    'options' => array(
                        'class'=>'btn btn-xs btn-danger room_booking',
                        //'id'=>'room_booking'
                    ),
                ),
            ),
        ),
    ),
)); ?>
<?php $this->renderPartial('partial/_js',array()); ?>
