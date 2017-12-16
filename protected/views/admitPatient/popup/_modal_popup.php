<div class="form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'vital-form',
        'action'=>@$method.'?id='.@$model_vital->id.'&admit_id='.@$admit_id.'&patient_id='.@$patient_id.'&obj='.@$obj.'&popup_form=vital-form&treat_mod='.strtolower($obj).'&getPartial='.$getPartial.'&getPopupPartial='.$getPopupPartial,
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbModal', array(
        'id' => 'show-modal',
        'header' => $header_popup,
        /*'htmlOptions' =>array(
            'style' => 'width: 1500px;'
        ),*/
        'content' => $this->renderpartial('popup/'.$getPopupPartial, array(
            'model' => $model,
            'model_popup'=>$model_vital,
            'admit_id' => @$admit_id,
            'patient_id'=>@$patient_id,
            'form'=>$form
        ),true, false),
        'footer' => implode(' ', array(
            TbHtml::submitButton(Yii::t('app','Save'),array(
                    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                    'size'=>TbHtml::BUTTON_SIZE_SMALL,
                    'id'=>'submit-vital',
                    'name' => 'vital_submit',
                )
            ),
            TbHtml::button('Close', array('data-dismiss' => 'modal','size'=>TbHtml::BUTTON_SIZE_SMALL)),
        )),
    ));
    ?>
    <?php $this->endWidget(); ?>
</div>
<script>
    $(document).ready(function() {
        $('#show-modal').on('hidden.bs.modal', function() {
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
        });
    });
</script>