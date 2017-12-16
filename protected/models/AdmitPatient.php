<?php

/**
 * This is the model class for table "ipd_tbl_AdmitPatient".
 *
 * The followings are the available columns in table 'ipd_tbl_AdmitPatient':
 * @property integer $id
 * @property integer $patient_id
 * @property integer $insurance_id
 * @property integer $bed_id
 * @property integer $dept_id
 * @property integer $doctor_id
 * @property string $status
 * @property string $provosional_diagnosis
 * @property string $comment
 * @property string $date_admit
 */
class AdmitPatient extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_AdmitPatient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patient_id, doctor_id, date_admit', 'required'),
			array('patient_id, insurance_id, bed_id, dept_id, doctor_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>20),
			array('provosional_diagnosis', 'length', 'max'=>100),
			array('comment', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, insurance_id, bed_id, dept_id, doctor_id, status, provosional_diagnosis, comment, date_admit', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'IOP No.',
			'patient_id' => 'Patient',
			'insurance_id' => 'Insurance',
			'bed_id' => 'Bed',
			'dept_id' => 'Department',
			'doctor_id' => 'Doctor',
			'status' => 'Status',
			'provosional_diagnosis' => 'Provosional Diagnosis',
			'comment' => 'Comment',
			'date_admit' => 'Date Admit',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('patient_id',$this->patient_id);
		$criteria->compare('insurance_id',$this->insurance_id);
		$criteria->compare('bed_id',$this->bed_id);
		$criteria->compare('dept_id',$this->dept_id);
		$criteria->compare('doctor_id',$this->doctor_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('provosional_diagnosis',$this->provosional_diagnosis,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('date_admit',$this->date_admit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getDoctor()
	{
		$sql="SELECT t2.id,CONCAT(IFNULL(first_name,''),' ',IFNULL(last_name,'')) doctor_name
			FROM employee t1
			INNER JOIN rbac_user t2 ON t1.id=t2.employee_id
			AND t2.group_id=2";

		$cmd = Yii::app()->db->createCommand($sql);
		return $cmd->queryall();
	}

	public function getIpdPatientInfo($admit_id=null,$patient_id=null)
	{
		$sql="SELECT t1.id,t1.patient_id,date_admit,doctor_id,
			(SELECT display_id FROM v_search_patient t3 WHERE t1.patient_id=t3.patient_id) display_id,
			(SELECT fullname FROM v_search_patient t3 WHERE t1.patient_id=t3.patient_id) fullname,bed_no,
			(SELECT room_no FROM ipd_tbl_Room t4 WHERE t2.room_id=t4.id) room_no,
			(SELECT department_name FROM ipd_tbl_Department t5 WHERE t1.dept_id=t5.id) Department,
			(SELECT doctor_name FROM vw_user_info t6 WHERE t1.doctor_id=t6.userid) Doctor
			FROM ipd_tbl_AdmitPatient t1
			INNER JOIN ipd_tbl_Bed t2 ON t1.bed_id=t2.id
			where t1.id=:admit_id
			and patient_id=:patient_id";

		$cmd = Yii::app()->db->createCommand($sql);
		$cmd->bindParam(':admit_id', $admit_id, PDO::PARAM_INT);
		$cmd->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
		return $cmd->queryRow();
	}

	public function getInPatient()
	{
		if (isset($_GET['Appointment'])) {
			//-----***Check condition of query***----//
			$search = $_GET['AdmitPatient']['patient_name'];
			$cond = " and (lower(patient_name) like '%" . $search . "%' or lower(display_id) like  '%" . $search . "%')";
		} else {
			$cond = "";

		}

		$userid = Yii::app()->user->getId();
		//echo $userid;
		$sql = "SELECT @rownum:=@rownum+1 id,admit_id,patient_id,doctor_id,patient_name,
                    display_id,date_admit,'Pending' status
                    from(select admit_id,patient_id,user_id doctor_id,patient_name,display_id,date_admit,status
                        FROM vw_in_patient_state 
                        WHERE user_id=$userid
                        and status='1'
                        $cond
                        ORDER BY date_admit
                    )cl,(SELECT @rownum:=0) r";
		//echo $sql;
		//die();
		//$rawData = Yii::app()->db->createCommand($sql);
		//$rawData->bindParam(':userid', $userid, PDO::PARAM_INT);
		return new CSqlDataProvider($sql, array(
			'sort' => array(
				'attributes' => array(
					'id', 'display_id', 'patient_name'
				)
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdmitPatient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
