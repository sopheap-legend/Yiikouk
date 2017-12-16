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
			$model->date_admit=date('Y-m-d');
			//$model_room->attributes=$_POST['AdmitPatient'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
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
					'header_popup'=>$obj,
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
		}else{
			$headerInfo='General Information';
		}

		return $headerInfo;
	}

	public function actionCreateTreatmentCatg($admit_id=null,$patient_id=null,$obj='',$popup_form='',$treat_mod='',$getPartial='',$getPopupPartial='')
	{
		$my_obj = new $obj;

		$this->performAjaxValidation($my_obj,$popup_form);

		$transaction=$my_obj->dbConnection->beginTransaction();

		try{
			if(isset($_POST['vital_submit']))
			{
				if(isset($_POST[$obj]))
				{
					$my_obj->attributes=$_POST[$obj];
					$my_obj->admit_id=@$admit_id;

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
