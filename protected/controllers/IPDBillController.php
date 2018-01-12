<?php

class IPDBillController extends Controller
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
				'actions'=>array('index','admin','GetPatient',
					'InitPatient','GetIPDTreatment','InitIPDTreatment',
					'AddBillItem','DeleteItem','SaveIPDBill'),
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
	public function actionCreate($patient_id=null,$admit_id=null,$myPatial='')
	{
		$data = $this->reload_create($patient_id,$admit_id);
		$data['patial']=$myPatial;
		$data['particular_item_selected'] = Yii::app()->iPDTreatmentCart->getParticularItem();
		if(isset($_POST['btn-submit']))
		{
			$this->actionSaveIPDBill($patient_id,$admit_id,$data);
			Yii::app()->iPDTreatmentCart->emptyIPDBill();
			$this->redirect(array('IPDBill/admin'));
		}

		$this->render('create',array(
			'data'=>$data,
		));
	}

	public function actionSaveIPDBill($patient_id=null,$admit_id=null,$data=null)
	{
		$particular_item_selected = Yii::app()->iPDTreatmentCart->getParticularItem();
		if(!empty($particular_item_selected))
		{
			$data['IPDBill']->admit_id = $admit_id;
			$data['IPDBill']->bill_date = date('Y-m-d');
			$data['IPDBill']->exchange_rate = Yii::app()->session['exchange_rate'];
			$data['IPDBill']->prepare_by= Yii::app()->user->getId();
			$data['IPDBill']->status=Yii::app()->params['save_ipdbill'];
			if($data['IPDBill']->save())
			{
				$billID = $data['IPDBill']->id;
				foreach ($particular_item_selected as $key => $value)
				{
					if($value['patient_id']==$patient_id && $value['admit_id']==$admit_id)
					{
						$iPDBillDetail = new IPDBillDetail;
						$iPDBillDetail->bill_id = $billID;
						$iPDBillDetail->category_type = $value['category'];
						$iPDBillDetail->item_id = $value['id'];
						$iPDBillDetail->amount = $value['price'] * $value['qty'];
						$iPDBillDetail->save();
					}
				}
			}
		}
	}

	public function actionGetPatient() {
		if (isset($_GET['term'])) {
			$term = trim($_GET['term']);
			//print_r($_GET);
			$ret['results'] = IPDBill::getPatient($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
			echo CJSON::encode($ret);
			Yii::app()->end();
		}
	}

	public function actionGetIPDTreatment()
	{
		if (isset($_GET['term'])) {
			$term = trim($_GET['term']);
			$ret['results'] = IPDBill::GetIPDTreatment($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
			echo CJSON::encode($ret);
			Yii::app()->end();
		}
	}

	public function actionInitPatient()
	{
		echo CJSON::encode(array('id'=>'','text'=>''));
	}

	public function actionInitIPDTreatment()
	{
		echo CJSON::encode(array('id'=>'','text'=>''));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['IPDBill']))
		{
			$model->attributes=$_POST['IPDBill'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('IPDBill');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new IPDBill('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IPDBill']))
			$model->attributes=$_GET['IPDBill'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionAddBillItem($patient_id=null,$admit_id=null)
	{
		$data = $this->reload_create($patient_id,$admit_id);
		$item_id = $_POST['item_id'];
		$category = $_POST['category'];

		if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest )
		{
			Yii::app()->iPDTreatmentCart->addParticularItem($item_id,$category,1,'',$patient_id,$admit_id);
			$data['particular_item_selected'] = Yii::app()->iPDTreatmentCart->getParticularItem();

			if (Yii::app()->request->isAjaxRequest)
			{
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
			//print_r($data['particular_item_selected']);
			echo CJSON::encode(array(
				'status' => 'success',
				'div_particular_item_form' => $this->renderPartial('partial/_bill_item', array('data'=>$data),true, true),
			));

			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	public function actionDeleteItem($particular_id,$admit_id=null,$patient_id=null)
	{
		$data = $this->reload_create($patient_id,$admit_id);

		if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest )
		{
			Yii::app()->iPDTreatmentCart->deleteParticularItem($particular_id);
			$data['particular_item_selected']= Yii::app()->iPDTreatmentCart->getParticularItem();

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
				'div_particular_item_form' => $this->renderPartial('partial/_bill_item', array('data'=>$data),true, true),
			));

			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	protected function reload_create($patient_id=null,$admit_id=null)
	{
		$data['IPDBill'] = new IPDBill;
		$data['IPDBillDetail'] = new IPDBillDetail;
		$data['patient_id']=$patient_id;
		$data['admit_id']=$admit_id;
		//$data['PatientInfo'] = new VSearchPatient;
		$data['PatientInfo'] = VSearchPatient::model()->find('patient_id=:patient_id',array(':patient_id'=>$patient_id));
		$data['VwItemTreatment'] = new VwItemTreatment;
		$data['Patient'] = new Patient;

		return $data;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return IPDBill the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=IPDBill::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param IPDBill $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ipdbill-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
