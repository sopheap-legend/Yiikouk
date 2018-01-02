<?php

class BedMasterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','admin','Dynamicroom','Dynamicfloor','Dynamicbed'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new IpdTblBed;
		$category_room = new IpdTblCategoryRoom;
		$room_master = new IpdTblRoom;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['IpdTblBed']))
		{
			$model->attributes=$_POST['IpdTblBed'];
			$model->room_id= $_POST['IpdTblRoom']['id'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'category_room'=>$category_room,
			'room_master'=>$room_master
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$get_room=IpdTblRoom::model()->findByPk($id);
		$category_room=IpdTblCategoryRoom::model()->findByPk($get_room->catg_room_id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$drd_room_no = IpdTblRoom::model()->findall('catg_room_id=:catg_room_id and floor=:floor',
							array(
									':catg_room_id'=>(int) $get_room->catg_room_id,
								':floor' => $get_room->floor
							)
						);

		$drd_floor=IpdTblBed::model()->getFloorByCatg((int) $get_room->catg_room_id);

		if(isset($_POST['IpdTblBed']))
		{
			$model->attributes=$_POST['IpdTblBed'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'category_room'=>$category_room,
			'room_master'=>$get_room,
			'drd_room_no'=>$drd_room_no,
			'drd_floor'=>$drd_floor,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('IpdTblBed');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new IpdTblBed('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IpdTblBed']))
			$model->attributes=$_GET['IpdTblBed'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionDynamicfloor($get_room=null)
	{
		/*$data=IpdTblRoom::model()->findAll('catg_room_id=:catg_room_id',
			array(':catg_room_id'=>(int) $_POST['IpdTblCategoryRoom']['id'])
			);*/
		if(!empty($get_room))
		{
			$data=$get_room;
		}else{
			if(isset($_POST['IpdTblCategoryRoom']))
			{
				$data=IpdTblBed::model()->getFloorByCatg((int) $_POST['IpdTblCategoryRoom']['id']);
			}elseif(isset($_POST['IPRoomTransfer'])){
				$data=IpdTblBed::model()->getFloorByCatg((int) $_POST['IPRoomTransfer']['category_id']);
			}
		}

		$data=CHtml::listData($data,'floor','floor');

		$static = array(
			'0'     => Yii::t('fim','Select Floor'),
		);

		$data = $static+$data; //Update a subscription for select box

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
		}
	}

	public function actionDynamicroom()
	{
		//print_r($_POST);
		if(isset($_POST['IpdTblCategoryRoom']))
		{
			$CategoryRoom = $_POST['IpdTblCategoryRoom']['id'];
			$room = $_POST['IpdTblRoom']['floor'];
		}elseif(isset($_POST['IPRoomTransfer'])){
			$CategoryRoom = $_POST['IPRoomTransfer']['category_id'];
			$room = $_POST['IPRoomTransfer']['floor'];
		}else{
			$CategoryRoom="";
			$room="";
		}

		$data=IpdTblRoom::model()->findAll('catg_room_id=:catg_room_id and floor=:floor',
			array(':catg_room_id'=>(int) $CategoryRoom,':floor' => $room)
			);

		$data=CHtml::listData($data,'id','room_no');

		$static = array(
			'0'     => Yii::t('fim','Select Room'),
		);

		$data = $static+$data; //Update a subscription for select box

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
		}
	}

	public function actionDynamicbed()
	{
		//print_r($_POST);
		if(isset($_POST['IPRoomTransfer']))
		{
			$room_id=$_POST['IPRoomTransfer']['room_id'];
		}

		$data=IpdTblBed::model()->findAll('room_id=:room_id',
			array(':room_id'=>(int) $room_id,)
		);

		$data=CHtml::listData($data,'id','bed_no');

		$static = array(
			'0'     => Yii::t('fim','Select Bed'),
		);

		$data = $static+$data; //Update a subscription for select box

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return IpdTblBed the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=IpdTblBed::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param IpdTblBed $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ipd-tbl-bed-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
