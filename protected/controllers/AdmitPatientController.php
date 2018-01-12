<?php

class AdmitPatientController extends Controller
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
				'actions'=>array('index','view','create','admin',
								'IpdTreatment','CreateTreatmentCatg',
								'Delete','InPatient'),
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
	public function actionCreate($patient_id=null)
	{
		$model=new AdmitPatient;
		$model_room = new IpdTblRoom;
		$model_bed = new IpdTblBed;

		$category_room = new  IpdTblCategoryRoom;
		$roomEnquiry=IpdTblRoom::model()->DisplayAvailableRoom();
		$patient = VSearchPatient::model()->find('patient_id=:patient_id',array('patient_id'=>$patient_id));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdmitPatient']))
		{
			$model->attributes=$_POST['AdmitPatient'];
			$model->bed_id=$_POST['IpdTblBed']['id'];
			$model->patient_id=$_POST['patient_id'];
			$model->status=1;
			$model->date_admit=date('Y-m-d h:i:s');
			//$model_room->attributes=$_POST['AdmitPatient'];
			if($model->save())
				$this->redirect(array('contact/admin','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'model_room'=>$model_room,
			'model_bed'=>$model_bed,
			'category_room'=>$category_room,
			'roomEnquiry'=>$roomEnquiry,
			'patient'=>$patient
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	public function actionUpdate($id,$admit_id=null,$patient_id=null,$obj=null,$popup_form='',$treat_mod='',$getPartial='',$getPopupPartial='')
	{
		//$obj='Vital';
		$my_obj = new $obj;

		$this->performAjaxValidation($my_obj,$popup_form);

		$model=$this->loadModel($my_obj,$id);
		$model_admit = AdmitPatient::model()->findByPk($model->admit_id);

		$model_patient_info = AdmitPatient::model()->getIpdPatientInfo(1,8); //will replace id by system

		if(isset($_POST['vital_submit']))
		{
			if(isset($_POST[$obj]))
			{
				if(isset($_POST[$obj]))
				{
					$model->attributes=$_POST[$obj];
					$my_obj->admit_id=@$admit_id;
					if($model->save())
						$this->redirect(array('admitPatient/IpdTreatment',
								'treat_mode'=>$treat_mod,
								'admit_id'=>$model->admit_id,
								'patient_id'=>$model_admit->patient_id,
								'obj'=>$obj,
								'getPartial'=>$getPartial
							)
						);
				}
			}
		}/*else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again');
		}*/

		if($obj=='IPRoomTransfer')
		{
			$data = $this->reload_update($model->admit_id);
			$model->category_id=$data['model_category_room']->id;
			//$model->floor=$data['floor_per_category']->floor;
			$model->room_id=4;
			//foreach ($data['floor_per_category'] as $val)
				//$model->floor=1;
				//$model->room_id=2;
			//echo $val['floor'];
			//print_r($data);
			//echo $data['model_room']->id;
			//die();
		}

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

			Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
			Yii::app()->clientScript->scriptMap['box.css'] = false;

			$outputJs = Yii::app()->request->isAjaxRequest; //http://bit.ly/2okV6D1 to load ajax validate request to form

			echo CJSON::encode(array(
				'status' => 'success',
				'div_vital_popup' => $this->renderpartial("popup/_modal_popup", array(
					'model'=>$model_admit,
					'model_vital' => $model,
					'obj'=> $obj,
					'getPopupPartial'=>$getPopupPartial,
					'getPartial'=>$getPartial,
					'admit_id' => @$model_patient_info['id'],
					'patient_id'=>@$model_patient_info['patient_id'],
					'header_popup'=>$this->getHeaderPopupInfo($obj),
					'method'=>'Update'
				),true, $outputJs),
			));
		}
	}

	public function actionInPatient()
	{
		$model = new AdmitPatient('getInPatient');
		$this->render('in_patient',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$obj=null)
	{
		$my_obj = new $obj;
		$this->loadModel($my_obj,$id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AdmitPatient');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$path = Yii::app()->basePath . '/../ximages/Patient-Male.ico';

		$model=new AdmitPatient('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdmitPatient']))
			$model->attributes=$_GET['AdmitPatient'];

		$this->render('admin',array(
			'model'=>$model,
			//'path'=>$path,
		));
	}

	public function actionIpdTreatment($treat_mode = 'general_info',$admit_id=null,$patient_id=null,$obj='',$getPartial='')
	{
		//$userid = Yii::app()->user->getId();

		Yii::app()->receivingCart->setMode($treat_mode);
		$model = new AdmitPatient;

		$model_patient_info = AdmitPatient::model()->getIpdPatientInfo($admit_id,$patient_id);

		if(!empty($obj))
		{
			$my_obj = new $obj;

			$data=array(
				'model' => $model,
				'model_patient_info' => $model_patient_info,
				'model_vital'=>@$my_obj
			);

			$this->render('ipd_treatment',array(
					'data'=>$data,
					'treat_mode'=>$treat_mode,
					'getPartial'=>'partial/'.$getPartial,
					'header_info'=>$this->getHeaderPopupInfo($obj)
				)
			);
		}else{
			$my_obj = new Vital;
			$data=array(
				'model' => $model,
				'model_patient_info' => $model_patient_info,
				'model_vital'=>@$my_obj,
			);

			$this->render('ipd_treatment',array(
					'data'=>$data,
					'treat_mode'=>$treat_mode,
					'getPartial'=>'partial/_general_information',
					'header_info'=>'General Patient Information'
				)
			);
		}
		/*if (Yii::app()->receivingCart->getMode()=='vital' )
		{
			$this->render('ipd_treatment',array(
					'data'=>$data,
					'treat_mode'=>$treat_mode,
					'getPartial'=>'partial/'.$getPartial,
					'header_info'=>$this->getHeaderPopupInfo($obj)
				)
			);
		}else{
			$this->render('ipd_treatment',array(
					'data'=>$data,
					'treat_mode'=>$treat_mode,
					'getPartial'=>'partial/_general_information',
					'header_info'=>'General Patient Information'
				)
			);
		}*/
	}

	protected function getHeaderPopupInfo($obj)
	{
		if($obj=='Vital')
		{
			$headerInfo='Vital Sign';
		}elseif ($obj=='Diagnosis'){
			$headerInfo='Diagnosis';
		}elseif ($obj=='IPDPrescription'){
			$headerInfo='IPD Prescription';
		}elseif ($obj=='Complaint'){
			$headerInfo='Complaint';
		}elseif ($obj=='ProgressNote'){
			$headerInfo='Progress Note';
		}elseif ($obj=='IntakeRecord'){
			$headerInfo='Intake Record';
		}elseif ($obj=='OutputRecord'){
			$headerInfo='Output Record';
		}elseif ($obj=='NurseProgessNote'){
			$headerInfo='Nurse Progess Note';
		}elseif ($obj=='BedSideProcedure'){
			$headerInfo='Bed Side Procedure';
		}elseif ($obj=='IPRoomTransfer'){
			$headerInfo='IP Room Transfer';
		}elseif ($obj=='OperationTheater'){
			$headerInfo='Operation Theater';
		}elseif ($obj=='PatientHistory'){
			$headerInfo='Patient History';
		}else{
			$headerInfo='General Information';
		}

		return $headerInfo;
	}

	public function actionCreateTreatmentCatg($admit_id=null,$patient_id=null,$obj='',$popup_form='',$treat_mod='',$getPartial='',$getPopupPartial='')
	{
		$my_obj = new $obj;

		$this->performAjaxValidation($my_obj,$popup_form);

		$userid = Yii::app()->user->getId();

		$transaction=$my_obj->dbConnection->beginTransaction();

		try{
			if(isset($_POST['vital_submit']))
			{
				if(isset($_POST[$obj]))
				{
					$my_obj->attributes=$_POST[$obj];
					$my_obj->admit_id=@$admit_id;


					if( $my_obj->hasAttribute('prepare_by') )
					{
						$my_obj->prepare_by=$userid;
					}

					if( $my_obj->hasAttribute('evt_date') )
					{
						$my_obj->evt_date=date('Y-m-d h:i:s');
					}

					if($obj=='IPRoomTransfer')
					{
						$criteria=new CDbCriteria;
						$criteria->select='max(evt_date) AS evt_date';
						$criteria->condition='admit_id=:admit_id';
						$criteria->params=array(':admit_id'=>$admit_id);
						$row = $my_obj->model()->find($criteria);

						$last_evt = $row['evt_date'];

						$last_row = $my_obj->model()->find('admit_id=:admit_id and evt_date=:evt_date',array(':admit_id'=>$admit_id,':evt_date'=>$last_evt));;

						//Update last day of patient stay in the room
						$evt_update = $obj::model()->findByPk($last_row->id);
						$evt_update->last_evt = date('Y-m-d h:i:s');
						$evt_update->save();

						//Update current bed to admit table
						$admit_update = AdmitPatient::model()->findByPk($admit_id);
						$admit_update->bed_id = $_POST[$obj]['bed_id'];
						$admit_update->save();
					}
					if($my_obj->save());
					$transaction->commit();
					$this->redirect(array('admitPatient/IpdTreatment',
											'treat_mode'=>$treat_mod,
											'admit_id'=>$admit_id,
											'patient_id'=>$patient_id,
											'obj'=>$obj,
											'getPartial'=>$getPartial
										)
									);
				}
			}
		}catch (Exception $e){
			$transaction->rollback();
			Yii::app()->user->setFlash('error', '<strong>Process was rollback! </strong>Please contact administrator.');
			//echo $e->getMessage();
		}
	}

	public function reload_update($admit_id=null)
	{
		$data['model_admit'] = AdmitPatient::model()->findByPk($admit_id);
		$data['model_bed'] = IpdTblBed::model()->findByPk($data['model_admit']->bed_id);
		$data['model_room'] = IpdTblRoom::model()->findByPk($data['model_bed']->room_id);
		$data['model_category_room'] = IpdTblCategoryRoom::model()->findByPk($data['model_room']->catg_room_id);

		$data['room_per_floor'] = IpdTblRoom::model()->findall('catg_room_id=:catg_room_id and floor=:floor',
			array(
				':catg_room_id'=>(int) $data['model_room']->catg_room_id,
				':floor' => $data['model_room']->floor
			)
		);

		$data['floor_per_category']=IpdTblBed::model()->getFloorByCatg((int) $data['model_room']->catg_room_id);

		return $data;
	}

	public function reload_create($admit_id=null)
	{
		$data['model_admit'] = new AdmitPatient;
		$data['model_bed'] = new IpdTblBed;
		$data['model_room'] = new IpdTblRoom;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AdmitPatient the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($obj,$id)
	{
		$model=$obj::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AdmitPatient $model the model to be validated
	 */
	protected function performAjaxValidation($model,$form_id='')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$form_id)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
