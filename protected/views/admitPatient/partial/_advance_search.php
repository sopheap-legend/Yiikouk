<style type="text/css">
    select {
        width:360px;
        height:38px;
    }
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'employee-form',
    'enableAjaxValidation'=>false,
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::dropDownList('category_room_id','', CHtml::listData(IpdTblCategoryRoom::model()->findall(),'id','room_type'),array('span'=>10,'prompt'=>'Select Room Category')); ?>
    </div>
    <div class="col-sm-5">
        <?php echo CHtml::dropDownList('room_status','', array('Occupied'=>'Occupied','UnOccupied'=>'UnOccupied'),array('span'=>10,'prompt'=>'Select Status')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
