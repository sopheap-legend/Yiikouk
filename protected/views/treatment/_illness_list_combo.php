<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'doctor_consult',
    'enableAjaxValidation'=>false,
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'id'=>'add_treatment',
)); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-1 col-xs-offset-1">
            <label>Illness List</label>
        </div>
        <div class="col-sm-6">
        <?php
        $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
            'asDropDownList' => false,
            'model'=> $illnesstype,
            'attribute'=>'id',
            'pluginOptions' => array(
                'placeholder' => Yii::t('app','Select Illness Type'),
                'multiple'=>false,
                'width' => '350px',
                'allowClear'=>true,
                //'minimumInputLength'=>1,
                'ajax' => array(
                    'url' => Yii::app()->createUrl('/treatment/GetIllnessList/'),
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
                /*'initSelection' => "js:function (element, callback) {
                            var id=$(element).val();
                            if (id!=='') {
                                $.ajax('".$this->createUrl('/appointment/InitTreatment')."', {
                                    dataType: 'json',
                                    data: { id: id }
                                }).done(function(data) {callback(data);}); //http://www.eha.ee/labs/yiiplay/index.php/en/site/extension?view=select2
                            }
                    }",*/
                'createSearchChoice' => 'js:function(term, data) {
                        if ($(data).filter(function() {
                            return this.text.localeCompare(term) === 0;
                        }).length === 0) {
                            return {id:term, text: term, isNew: true};
                        }
                    }',
                'formatResult' => 'js:function(term) {
                        if (term.isNew) {
                            return "<span class=\"label label-important\">New</span> " + term.text;
                        }
                        else {
                            return term.text;
                        }
                    }',
            )));
        //echo "Hello World";

        ?>
        <?php
            echo TbHtml::linkButton(Yii::t('app', 'Add'), array(
                'color' => TbHtml::BUTTON_COLOR_SUCCESS,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'icon' => 'glyphicon-plus white',
                //'url' => Yii::app()->createUrl('Treatment/Diagenose/'),
                'class' => 'diagenose',
                //'title' => Yii::t('app', 'Suspend Sale'),
            ));
        ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $url = Yii::app()->createUrl('Treatment/Diagenose'); ?>
<script>
    $('.diagenose').on('click', function (e) {
        e.preventDefault();
        data = $('form').serialize();
        $($(this).closest('.modal')).modal('hide'); //close diaglog
        //illness_name=$('#Illness_selected').val();
        $.ajax({
            data: data+ "&visit_id=<?php echo $visit_id;?>&doctor_id=<?php echo $doctor_id; ?>",
            type: "POST",
            url: "<?php echo $url; ?>",
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success: function (data) {
                window.location.reload();
                /*if(data.status=='success')
                {
                    alert(data.status);
                    //$(this).parent().appendTo($("form:first"));
                    //$('#select_medicine_form').html(data.div_medicine_form);
                    //$('#Item_id').select2('val', '');
                    window.location.reload();
                }*/
            }
        });
    });
</script>