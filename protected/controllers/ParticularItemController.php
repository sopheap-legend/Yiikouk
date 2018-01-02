<?php

class ParticularItemController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionDynamicitem()
	{
		if(isset($_POST['BedSideProcedure']))
		{
			$particular_category_id = $_POST['BedSideProcedure']['particular_category_id'];
			//$particular_category = ParticularCategory::model()->findByPk($particular_category_id);
		}

		//print_r($_POST);
		//die();

		$data=ParticularItem::model()->findAll('particular_catg_id=:particular_category_id',
			array(':particular_category_id'=>(int) $particular_category_id,)
		);

		$data=CHtml::listData($data,'id','particular_item');

		$static = array(
			''     => Yii::t('fim','Select particular Item'),
		);

		$data = $static+$data; //Update a subscription for select box

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}