<style>
    .btn-group {
        display: flex !important;
    }
</style>
<div class="row" id="contact">
    <div class="col-xs-12 widget-container-col ui-sortable">
        <?php
        echo TbHtml::button(Yii::t('app','Add New'),
            array(
                'data-toggle' => 'modal',
                'data-target' => '#show-modal',
                'icon'=>'glyphicon-plus white',
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
            )
        );
        ?>
        <?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
            'id'=>'vital-grid',
            'dataProvider'=>$model_vital->getComplaint(),
            'htmlOptions'=>array('class'=>'table-responsive panel'),
            'template' => "{items}",
            'columns'=>array(
                array(
                    'name' => 'id',
                    'header' => 'ID',
                    'headerHtmlOptions' => array('style' => 'display:none'),
                    'htmlOptions' => array('style' => 'display:none'),
                ),
                array(
                    'name' => 'admit_id',
                    'header' => 'Admit ID',
                    'headerHtmlOptions' => array('style' => 'display:none'),
                    'htmlOptions' => array('style' => 'display:none'),
                ),
                array(
                    'name' => 'patient_id',
                    'headerHtmlOptions' => array('style' => 'display:none'),
                    'htmlOptions' => array('style' => 'display:none'),
                ),
                array('name'=>'complaint',
                    'header'=> 'Complaint',
                    //'result'=>''
                ),
                array('name'=>'remarks',
                    'header'=> 'Remarks',
                ),
                array('name'=>'evt_date',
                    'header'=> 'Date',
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template'=>'<div class="hidden-sm hidden-xs btn-group">{update}{delete}</div>',
                    'htmlOptions'=>array('class'=>'nowrap'),
                    'buttons' => array(
                        'update' => array(
                            'label'=>'Update',
                            'url'=>'Yii::app()->createUrl("admitPatient/update/",array("id"=>$data["id"],"admit_id"=>$data["admit_id"],"patient_id"=>$data["patient_id"],"obj"=>"Complaint","popup_form"=>"vital-form","treat_mod"=>"diagnosis","getPartial"=>"_complaint","getPopupPartial"=>"_complaint_popup"))',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'class'=>'btn btn-xs btn-info vital-update',
                                'id'=>'vital-update'
                                //'data-toggle' => 'modal',
                                //'data-target' => '#show-vital-modal',
                            ),
                        ),
                        'delete' => array(
                            'label'=>'Delete',
                            'url'=>'Yii::app()->createUrl("admitPatient/delete/",array("id"=>$data["id"],"obj"=>"Complaint"))',
                            'options' => array(
                                'class'=>'btn btn-xs btn-danger',
                            ),
                            //'visible'=>'Yii::app()->user->checkAccess("contact.delete")',
                        ),
                    )
                ),
            ),
        )); ?>
    </div>
</div>
<div id="div_popup">
    <?php
    echo $this->renderpartial("popup/_modal_popup", array(
        'model' => $model,
        'model_vital'=>$model_vital,
        'obj'=>'Complaint',
        'getPopupPartial'=>'_complaint_popup',
        'getPartial'=>'_complaint',
        'admit_id' => @$model_patient_info['id'],
        'patient_id'=>@$model_patient_info['patient_id'],
        'header_popup'=>'Complaint',
        'method'=>'CreateTreatmentCatg',
    ),true, false);
    ?>
</div>
<div class="waiting"><!-- Place at bottom of page --></div>

<script>
    $('div#vital-grid').on('click','a#vital-update', function (e) {
        e.preventDefault();
        var url=$(this).attr("href");
        $.ajax({
            url:url,
            dataType:'json',
            type:'post',
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success:function(data) {
                if (data.status == 'success') {
                    //window.location.href = '$red_url';
                    $('#div_popup').html(data.div_vital_popup);
                    $('#show-modal').modal('show').load($(this).attr('value'));
                }
            }
        })
    });

    //$($(this).closest('.modal')).modal('hide');
</script>
