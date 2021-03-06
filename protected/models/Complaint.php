<?php

/**
 * This is the model class for table "ipd_tbl_Complaint".
 *
 * The followings are the available columns in table 'ipd_tbl_Complaint':
 * @property integer $id
 * @property integer $admit_id
 * @property integer $complaint_id
 * @property string $remarks
 * @property string $evt_date
 */
class Complaint extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_Complaint';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id, complaint_id, evt_date', 'required'),
			array('admit_id, complaint_id', 'numerical', 'integerOnly'=>true),
			array('remarks', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, complaint_id, remarks, evt_date', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'admit_id' => 'Admit',
			'complaint_id' => 'Complaint',
			'remarks' => 'Remarks',
			'evt_date' => 'Evt Date',
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
		$criteria->compare('admit_id',$this->admit_id);
		$criteria->compare('complaint_id',$this->complaint_id);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('evt_date',$this->evt_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getComplaint()
	{
		$admit_id = $_GET['admit_id'];
		$patient_id = $_GET['patient_id'];

		$sql="SELECT t1.id,t1.admit_id,t2.patient_id,
			(SELECT complaint FROM ipd_tbl_conf_Complaint t3 WHERE t1.complaint_id=t3.id) complaint,remarks,evt_date
			FROM ipd_tbl_Complaint t1
			INNER JOIN ipd_tbl_AdmitPatient t2 ON t1.admit_id=t2.id
			AND t2.patient_id=$patient_id
			AND t2.status='1'
			WHERE t1.admit_id=$admit_id";

		return new CSqlDataProvider($sql, array(
			'sort' => array(
				'attributes' => array(
					'id', 'complaint',
				)
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Complaint the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
