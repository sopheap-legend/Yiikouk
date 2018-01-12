<?php $treatment = new Treatment; ?>
<style type="text/css">
    .select2-container .select2-choice, .select2-result-label {
        height: 34px;
    }

    .select2-container .select2-choice { background-color: #FFFFFF;!important;}

    .select2-container {
        position: relative;
        padding:0;
        margin:0;
        border:0;
    }
</style>

<div class="form-group">
    <div class="col-xd-12">
        <div class="col-sm-6">
            <?php //echo CHtml::dropDownList('fee_type','', array('Particular'=>'Particular','Medicine'=>'Medicine'),array('span'=>10,'prompt'=>'Select Type')); ?>
            <?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                'asDropDownList' => true,
                'model'=>$data['IPDBill'],
                'attribute'=>'category',
                'data'=>array(''=>'','Particular'=>'Particular','Medicine'=>'Medicine'),
                'pluginOptions' => array(
                    'placeholder' => Yii::t('app','Select Type'),
                    'width' => '100%',
                    'allowClear'=>true,
                )
            ));
            ?>
            <?php /*$this->widget('yiiwheels.widgets.formhelpers.WhSelectBox',
            array(
                    'model' => $treatment,
                    'name' => 'branch_id',
                    'id'=>'Item-type',
                    'data' => array('Particular' => 'Particular','Medicine'=>'Medicine'),
                    'htmlOptions' => array(
                        'default'=>'Select Type',
                    )
                )
            );*/
            ?>
        </div>
        <!--<div class="col-sm-4">
            <?php
            /*$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                'asDropDownList' => false,
                'model'=> $data['Patient'],
                'attribute'=>'patient_id',
                'pluginOptions' => array(
                    'placeholder' => Yii::t('app','Select Category'),
                    'multiple'=>false,
                    'width' => '250px',
                    'allowClear'=>true,
                    'ajax' => array(
                        'url' => Yii::app()->createUrl('/IPDBill/GetPatient/'),
                        'dataType' => 'json',
                        'cache'=>true,
                        'data' => 'js:function(term,page) {
                            return {
                                term: term, 
                                page_limit: 10,
                                quietMillis: 100, 
                                apikey: "e5mnmyr86jzb9dhae3ksgd73" 
                            };
                        }',
                        'results' => 'js:function(data,page){
                    return { results: data.results };
                 }',
                    ),
                    'initSelection' => "js:function (element, callback) {
                    var id=$(element).val();
                    if (patient_id!=='') {
                        $.ajax('".$this->createUrl('/IPDBill/InitPatient')."', {
                            dataType: 'json',
                            data: { patient_id: patient_id }
                        }).done(function(data) {callback(data);}); //http://www.eha.ee/labs/yiiplay/index.php/en/site/extension?view=select2
                    }
            }",
                    'formatResult' => 'js:function(term) {
                return term.text;
            }',
                )));*/
            ?>
        </div>-->
        <div class="col-sm-6">
            <?php

            $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                'asDropDownList' => false,
                'model'=> $treatment,
                'attribute'=>'id',
                'pluginOptions' => array(
                    'placeholder' => Yii::t('app','Select Particular Item'),
                    'multiple'=>false,
                    'width' => '100%',
                    'allowClear'=>true,
                    //'minimumInputLength'=>1,
                    'ajax' => array(
                        'url' => Yii::app()->createUrl('/iPDBill/GetIPDTreatment?myPatient='.$data['patient_id'].'&admit_id='.$data['admit_id']),
                        'dataType' => 'json',
                        'cache'=>true,
                        'data' => 'js:function(term,page) {
                            return {
                                term: term, 
                                myType:$("#IPDBill_category").val(),
                                page_limit: 10,
                                quietMillis: 100, 
                                apikey: "e5mnmyr86jzb9dhae3ksgd73" 
                            };
                        }',
                        'results' => 'js:function(data,page){
                    return { results: data.results };
                 }',
                    ),
                    'initSelection' => "js:function (element, callback) {
                    var id=$(element).val();
                    if (id!=='') {
                        $.ajax('".$this->createUrl('/appointment/InitIPDTreatment')."', {
                            dataType: 'json',
                            data: { id: id }
                        }).done(function(data) {callback(data);}); //http://www.eha.ee/labs/yiiplay/index.php/en/site/extension?view=select2
                    }
            }",
                    'formatResult' => 'js:function(term) {
                if (term.isNew) {
                    return "<span class=\"label label-important\">New</span> " + term.text;
                }
                else {
                    return term.text;
                }
            }',
                )));
            ?>
        </div>
    </div>
</div>
<script>
    /*$('#Treatment_id').on('change',function(e) {
        var type = $( "#Item-type" ).val();
    });*/
</script>