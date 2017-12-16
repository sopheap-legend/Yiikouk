<style>
    .btn-group {
        display: flex !important;
    }
</style>
<div class="row" id="contact">
    <div class="col-xs-12 widget-container-col ui-sortable">
        <?php
        /* @var $this ContactController */
        /* @var $model Contact */
        $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app','List of Patient'),
            'headerIcon' => 'ace-icon fa fa-users',
            'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
        ));
        ?>
        <?php
        /* @var $this TreatmentController */
        /* @var $model Treatment */
        $this->breadcrumbs=array(
            Yii::t('menu','Patient List')=>array('admin'),
            Yii::t('app','Manage'),
        );

        /*Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
            });
            $('.search-form form').submit(function(){
                $('#treatment-grid').yiiGridView('update', {
                    data: $(this).serialize()
                });
                return false;
            });
        ");*/
        ?>
        <?php //echo TbHtml::linkButton(Yii::t('app','Search'),array('class'=>'search-button btn','size'=>TbHtml::BUTTON_SIZE_SMALL,'icon'=>'ace-icon fa fa-search',)); ?>
        <div class="search-form" style="display:none">
            <?php /*$this->renderPartial('_search',array(
                'model'=>$model,
            ));*/ ?>
        </div><!-- search-form -->
        <?php if(Yii::app()->user->hasFlash('success')):?>
            <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
        <?php endif; ?>
        <?php $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'treatment-grid',
            'dataProvider'=>$model->getInPatient(),
            'htmlOptions'=>array('class'=>'table-responsive panel'),
            'columns'=>array(
                array('name'=>'id',
                    'header'=> 'ID',
                ),
                array(
                    'name' => 'admit_id',
                    'headerHtmlOptions' => array('style' => 'display:none'),
                    'htmlOptions' => array('style' => 'display:none'),
                ),
                array(
                    'name' => 'patient_id',
                    'headerHtmlOptions' => array('style' => 'display:none'),
                    'htmlOptions' => array('style' => 'display:none'),
                ),
                array(
                    'name' => 'doctor_id',
                    'headerHtmlOptions' => array('style' => 'display:none'),
                    'htmlOptions' => array('style' => 'display:none'),
                ),
                array('name'=>'patient_name',
                    'header'=> 'Patient Name',
                ),

                array('name'=>'display_id',
                    'header'=> 'Patient ID',
                ),
                array('name'=>'status',
                    'header'=> 'Status',
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'<div class="hidden-sm hidden-xs btn-group">{admit}</div>',
                    'htmlOptions'=>array('class'=>'nowrap'),
                    'buttons' => array(
                        'admit' => array(
                            'label'=>'View',
                            //http://yikouk.app/index.php/admitPatient/IpdTreatment?treat_mode=general_info&AdmitID=1&PatientID=8
                            'url'=>'Yii::app()->createUrl("admitPatient/IpdTreatment/",array("treat_mode"=>"general_info","admit_id"=>$data["admit_id"],"patient_id"=>$data["patient_id"]))',
                            'options' => array(
                                'class'=>'btn btn-xs btn-danger',
                            ),
                            //'visible'=>'Yii::app()->user->checkAccess("contact.delete")',
                        ),
                    )
                ),
            ),
        )); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>