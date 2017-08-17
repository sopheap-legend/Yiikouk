<?php /*$this->widget('yiiwheels.widgets.grid.WhGridView',array(
            'id'=>'lab-result',
            'type'=>'striped bordered',
            'dataProvider'=>$LabResult->showLabResult($visit_id),
            'htmlOptions'=>array('class'=>'table-responsive panel'),
            'template' => "{items}",
            'columns'=>array(                
                array('name'=>'id',
                        'headerHtmlOptions' => array('style' => 'display:none'),
                        'htmlOptions' => array('style' => 'display:none'),
                ),
                array('name'=>'visit_id',
                        'headerHtmlOptions' => array('style' => 'display:none'),
                        'htmlOptions' => array('style' => 'display:none'),
                ),
                array('name'=>'lab_item_name',
                       'header'=>'Lab Item Name', 
                ),
		//'appointment_date',
                array('name'=>'result',
                       'header'=>'Result', 
                ),
		array('name'=>'caption',
                        'header'=>'Caption', 
                ),
	),
));*/ ?>

<?php
$groupGridColumns = ReportColumn::getLabResultColumn();
$groupGridColumns[] = array(
    'name' => 'group_name',
    'value' => '$data["group_name"]',
    'headerHtmlOptions' => array('style' => 'display:none'),
    'htmlOptions' => array('style' => 'display:none')
);

$this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
    'type' => 'bordered',
    'id' => 'tbl-result',
    'dataProvider' => LabAnalized::model()->printLabResult($visit_id),
    'template' => "{items}",
    'extraRowColumns' => array('group_name'),
    'extraRowHtmlOptions' => array('style' => 'padding:12px;border:10px','class' => 'active',),
    'columns' => $groupGridColumns,
    'mergeColumns' => array('treatment_item'),
)); ?>
