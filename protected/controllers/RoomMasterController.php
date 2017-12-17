<?php

class RoomMasterController extends Controller
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
				'actions'=>array('index','view','admin',
								'update','RoomEnquiry','RoomChecking',
								'RoomBooking','Delete'
								),
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
		$model=new IpdTblRoom;
		$category_room = new IpdTblCategoryRoom;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['IpdTblRoom']))
		{
			$model->attributes=$_POST['IpdTblRoom'];
			$model->catg_room_id = $_POST['IpdTblCategoryRoom']['id'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'category_room' => $category_room,
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
		$category_room=IpdTblCategoryRoom::model()->findByPk($model->catg_room_id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['IpdTblRoom']))
		{
			$model->attributes=$_POST['IpdTblRoom'];
			$model->catg_room_id=$_POST['IpdTblCategoryRoom']['id'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'category_room' => $category_room
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
		$dataProvider=new CActiveDataProvider('IpdTblRoom');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new IpdTblRoom('roomMaster');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IpdTblRoom']))
			$model->attributes=$_GET['IpdTblRoom'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionRoomEnquiry()
	{
		$model=new IpdTblRoom('roomMaster');
		$category_room = new  IpdTblCategoryRoom;
		/*$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IpdTblRoom']))
			$model->attributes=$_GET['IpdTblRoom'];*/

		$this->render('room_enquiry',array(
			'model'=>$model,
			'category_room'=>$category_room
		));
	}

	public function actionRoomChecking()
	{
		if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {

			$data['model_room'] = new IpdTblRoom;
			$data['category_room'] = new IpdTblCategoryRoom;
			$data['roomEnquiry']=IpdTblRoom::model()->DisplayAvailableRoom();

			if (Yii::app()->request->isAjaxRequest) {
				$cs = Yii::app()->clientScript;
				$cs->scriptMap = array(
					'jquery.js' => false,
					'bootstrap.js' => false,
					'jquery.min.js' => false,
					'bootstrap.min.js' => false,
					'bootstrap.notify.js' => false,
					'bootstrap.bootbox.min.js' => false,
				);
			}
			Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
			Yii::app()->clientScript->scriptMap['box.css'] = false;

			echo CJSON::encode(array(
				'status' => 'success',
				'div_category_room' => $this->renderPartial('//admitPatient/partial/_room_enquiry', $data, true, true),
			));

			Yii::app()->end();
		}else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	public function actionRoomBooking($id)
	{
		if ( Yii::app()->request->isAjaxRequest )
		{
			if(!empty($id))
			{
				$bed_id = $id;
				$bed_no = IpdTblBed::model()->findByPk($id);
				$room_no = IpdTblRoom::model()->findByPk($bed_no->room_id);

				$chk_bed=Yii::app()->Common->CheckBedAvailbale($bed_id);
				if((int)$chk_bed==0)
				{
					Yii::app()->user->setFlash('success', '<strong>Well done!</strong> successfully Booked the room.');

					echo CJSON::encode(array(
						'status'=>'success',
						'bed_id' => $bed_id,
						'bed_no' => $bed_no->bed_no,
						'room_no'=>$room_no->room_no
					));

				}else{
					Yii::app()->user->setFlash('success', '<strong>Ooop!</strong> The room you selected no bed available.');

					echo CJSON::encode(array(
						'status'=>'error',
					));
				}
			}
		}else{
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return IpdTblRoom the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=IpdTblRoom::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param IpdTblRoom $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ipd-tbl-room-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
