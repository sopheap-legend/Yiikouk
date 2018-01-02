<?php
$this->breadcrumbs=array(
	Yii::t('menu','Bill')=>array('iPDBill/create'),
	Yii::t('menu','Add Bill'),
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
	'title' => Yii::t('app','Add Particular bill'),
	'headerIcon' => 'ace-icon fa fa-credit-card',
	'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));?>
<div class="form">
	<div class="col-sm-12">
		<?php $bill_method='particular_bill'; if($bill_method=='particular_bill'){ ?>
		<div class="row">
			<div class="search-form" style="">
				<?php $this->renderPartial('partial/_select_particular_bill',array(
					'data'=>@$data,
				)); ?>
			</div><!-- search-form -->
		</div>
		<?php } ?>
		<div class="col-sm-12" id="display_bill_item">
			<?php $this->renderPartial('partial/_bill_item',array(
				'model'=>@$model,
			)); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>