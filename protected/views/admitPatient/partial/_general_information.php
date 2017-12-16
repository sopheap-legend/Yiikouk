<?php //print_r($model_patient_info); ?>
<div class="row">
    <div class="col-sm-12">
        <?php
            $this->widget(
                'yiiwheels.widgets.detail.WhDetailView',
                array(
                    'data' => array(
                        'ID' => @$model_patient_info['patient_id'],
                        'date_admit' => @$model_patient_info['date_admit'],
                        'Doctor' => @$model_patient_info['Doctor'],
                        'Department' => @$model_patient_info['Department'],
                        'room_no' => @$model_patient_info['room_no'],
                        'bed_no' => @$model_patient_info['bed_no'],
                    ),
                    'attributes' => array(
                        array('name' => 'date_admit', 'label' => 'Date Admit'),
                        array('name' => 'Doctor', 'label' => 'Doctor In-charge'),
                        array('name' => 'Department', 'label' => 'Department'),
                        array('name' => 'room_no', 'label' => 'Room'),
                        array('name' => 'bed_no', 'label' => 'Bed No.'),
                    ),
                ));
        ?>
    </div>
</div>