<?php $this->widget('EExcelView',array(
        'id'=>'sale-item-summary-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->saleItemSummary(),
        //'filter'=>$filtersForm,
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Sales Item Summary') . Yii::t('app','From') . ':  ' . $from_date . '  ' . Yii::t('app','To') . ':  ' . $to_date . '</p>', 
	'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
        'columns'=>array(
		array('name'=>'item_name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["item_name"]',
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'date_report',
                      'header'=>Yii::t('app','Date'),
                      'value' =>'$data["date_report"]',
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','QTY'),
                      'value' =>'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
		        array('name'=>'sub_total',
                      'header'=>Yii::t('app','Sale Amount'),
                      'value' =>'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'profit',
                    'header'=>Yii::t('app','Profit'),
                    'value' =>'number_format($data["profit"],Common::getDecimalPlace(), ".", ",")',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                    'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
	),
)); ?>