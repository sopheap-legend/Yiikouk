<?php

/**
 * This is the model class for table "ipd_tbl_IPDPrescription".
 *
 * The followings are the available columns in table 'ipd_tbl_IPDPrescription':
 * @property integer $id
 * @property integer $admit_id
 * @property integer $medication_id
 * @property string $instruction
 * @property string $advice
 * @property integer $days
 * @property integer $qty
 * @property integer $prepare_by
 * @property string $evt_date
 */
class IPDPrescription extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_IPDPrescription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id, medication_id, days, qty, prepare_by, evt_date', 'required'),
			array('admit_id, medication_id, days, qty, prepare_by', 'numerical', 'integerOnly'=>true),
			array('instruction, advice', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, medication_id, instruction, advice, days, qty, prepare_by, evt_date', 'safe', 'on'=>'search'),
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
			'medication_id' => 'Medication',
			'instruction' => 'Instruction',
			'advice' => 'Advice',
			'days' => 'Days',
			'qty' => 'Qty',
			'prepare_by' => 'Prepare By',
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
		$criteria->compare('medication_id',$this->medication_id);
		$criteria->compare('instruction',$this->instruction,true);
		$criteria->compare('advice',$this->advice,true);
		$criteria->compare('days',$this->days);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('prepare_by',$this->prepare_by);
		$criteria->compare('evt_date',$this->evt_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPrescription()
	{
		$admit_id = $_GET['admit_id'];
		$patient_id = $_GET['patient_id'];

		$sql="SELECT t1.id,admit_id,t2.patient_id,
			(SELECT NAME FROM item t3 WHERE t1.medication_id=t3.id) medicine,instruction,advice,days,qty,
			(SELECT doctor_name FROM vw_user_info t4 WHERE t1.prepare_by=t4.userid) prepare_by,evt_date
					FROM ipd_tbl_IPDPrescription t1
					INNER JOIN ipd_tbl_AdmitPatient t2 ON t1.admit_id=t2.id
					AND t2.patient_id=$patient_id
					AND t2.status='1'
					WHERE t1.admit_id=$admit_id";

		return new CSqlDataProvider($sql, array(
			'sort' => array(
				'attributes' => array(
					'id',
				)
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IPDPrescription the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
