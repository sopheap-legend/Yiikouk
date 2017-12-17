<style>
    .btn-group {
        display: flex !important;
    }
</style>
<div class="btn-group">
    <div class="col-xs-12 ui-sortable">
        <?php
        /* @var $this TreatmentController */
        /* @var $model Treatment */
        $this->breadcrumbs=array(
            Yii::t('menu','Enquiry Room')=>array('RoomEnquiry'),
            Yii::t('app','Manage'),
        );
        ?>
        <div class="row">
            <div class="search-form" style="">
                <?php $this->renderPartial('partial/_advance_search',array(
                    'model'=>$model,
                    'category_room'=>$category_room
                )); ?>
            </div><!-- search-form -->
        </div>
        <br />
        <div class="row">
        <?php if(Yii::app()->user->hasFlash('success')):?>
            <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
        <?php endif; ?>
        <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'id' => 'room-enquiry',
            'dataProvider' => IpdTblRoom::model()->roomEnquiry(),
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
                    'header' => 'Total Bed',
                ),
                array(
                    'name' => 'status',
                    'header' => 'Status',
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'<div class="hidden-sm hidden-xs btn-group">{detail}</div>',
                    'htmlOptions'=>array('class'=>'nowrap'),
                    'buttons' => array(
                        'detail' => array(
                            'label' => 'Detail',
                            //'url'=>'Yii::app()->createUrl("/roomMaster/Update/",array("id"=>$data["id"]))',
                            //'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'class'=>'btn btn-xs btn-info',
                            ),
                        ),
                    ),
                ),
            ),
        )); ?>
        </div>
    </div>