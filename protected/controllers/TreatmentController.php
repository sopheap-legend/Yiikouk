<?php

class TreatmentController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','IllnessList','GetIllnessList','Diagenose'),
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
		$model=new Treatment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Treatment'])) {
			$model->attributes=$_POST['Treatment'];
			if ($model->save()) {
				$this->redirect(array('admin','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Treatment'])) {
			$model->attributes=$_POST['Treatment'];
			if ($model->save()) {
				$this->redirect(array('admin','id'=>$model->id));
			}
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
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Treatment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Treatment('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Treatment'])) {
			$model->attributes=$_GET['Treatment'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionIllnessList($visit_id,$doctor_id)
	{
		$cs = Yii::app()->clientScript;
		$cs->scriptMap = array(
			'jquery.js' => false,
			'bootstrap.js' => false,
			'jquery.ba-bbq.min.js' => false,
			'jquery.yiigridview.js' => false,
			'bootstrap.min.js' => false,
			'jquery.min.js' => false,
			'bootstrap.notify.js' => false,
			'bootstrap.bootbox.min.js' => false,
		);

		Yii::app()->clientScript->scriptMap['*.js'] = false;
		$data['illnesstype']= new IllnessType();
		$data['visit_id'] = $visit_id;
		$data['doctor_id'] = $doctor_id;

		echo CJSON::encode(array(
			'status' => 'render',
			'div' => $this->renderPartial('_illness_list_combo', $data, true, true),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Treatment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Treatment::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Treatment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='treatment-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetIllnessList() {
		if (isset($_GET['term'])) {
			$term = trim($_GET['term']);
			$ret['results'] = IllnessType::getIllnessList($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
			echo CJSON::encode($ret);
			Yii::app()->end();

		}
	}

	public function actionDiagenose()
	{
		if(isset($_POST['IllnessType']))
		{
			if(!empty($_POST['IllnessType']['id']))
			{
				$model = new Treatment;
				$medicine = new Item;
				$illness_id=$_POST['IllnessType']['id'];
				$data['medicine_selected_items'] = Yii::app()->treatmentCart->getMedicine();

				$app_status = Appointment::model()->find('visit_id=:visit_id and status="Consultation"', array(':visit_id'=>$_POST['visit_id']));
				if(!empty($app_status))
				{
					//echo "In consultant mode";
					$transaction=$model->dbConnection->beginTransaction();
					try{
						Treatment::model()->save_diagnose($_POST['visit_id'],$illness_id,$_POST['doctor_id']);
						$transaction->commit();

						Yii::app()->user->setFlash('success', '<strong>Successful Saved! </strong>');
					}catch (Exception $e){
						$transaction->rollback();
						Yii::app()->user->setFlash('success', '<strong>Process was rollback! </strong>Please contact administrator.');
						//echo $e->getMessage();
					}

					Yii::app()->treatmentCart->emptyMedicine(); //clear session before add new

					$tbl_medicine = Item::model()->get_tbl_medicine($_POST['visit_id']);
					//print_r(Yii::app()->treatmentCart->getMedicine());
					foreach ($tbl_medicine as $value) {
						Yii::app()->treatmentCart->addMedicine($value['id'],$value['unit_price'],$value['quantity'],
							$value['dosage'],$value['duration_id'],$value['frequency'],
							$value['instruction_id'],$value['comment'],
							$value['consuming_time_id']);
					}

					/*$data['visit_id']=$_POST['visit_id'];
					$data['medicine']=$medicine;

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
						'div_medicine_form' => $this->renderPartial('//appointment/_select_medicine', $data, true, true),
					));

					Yii::app()->end();*/
				}else{
					Yii::app()->user->setFlash('success', '<strong>Oop!</strong> You are not in the consultation mode.');
				}
			}
		}
		//print_r($_POST);
	}
}