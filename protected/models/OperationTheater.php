<?php

/**
 * This is the model class for table "ipd_tbl_OperationTheater".
 *
 * The followings are the available columns in table 'ipd_tbl_OperationTheater':
 * @property integer $id
 * @property integer $admit_id
 * @property string $date_opration
 * @property string $from_time
 * @property string $to_time
 * @property string $operation_name
 * @property integer $diagnosis_id
 * @property string $name_surgeon
 * @property string $name_anesthesia
 * @property integer $assistant1
 * @property integer $assistant2
 * @property integer $assistant3
 * @property integer $assistant4
 * @property string $operation_procedure
 * @property string $note
 */
class OperationTheater extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_OperationTheater';
	}

	/*public $assistant1;
	public $assistant2;
	public $assistant3;
	public $assistant4;*/

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id, date_operation, from_time, to_time, operation_name, diagnosis_id, name_surgeon, name_anesthesia, operation_procedure', 'required'),
			array('admit_id, diagnosis_id, assistant1, assistant2, assistant3, assistant4', 'numerical', 'integerOnly'=>true),
			array('operation_name, name_surgeon, name_anesthesia', 'length', 'max'=>30),
			array('operation_procedure', 'length', 'max'=>100),
			array('note', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, date_operation, from_time, to_time, operation_name, diagnosis_id, name_surgeon, name_anesthesia, assistant1, assistant2, assistant3, assistant4, operation_procedure, note', 'safe', 'on'=>'search'),
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
			'date_operation' => 'Date Operation',
			'from_time' => 'From Time',
			'to_time' => 'To Time',
			'operation_name' => 'Operation Name',
			'diagnosis_id' => 'Diagnosis',
			'name_surgeon' => 'Name Surgeon',
			'name_anesthesia' => 'Name Anesthesia',
			'assistant1' => 'Assistant1',
			'assistant2' => 'Assistant2',
			'assistant3' => 'Assistant3',
			'assistant4' => 'Assistant4',
			'operation_procedure' => 'Operation Procedure',
			'note' => 'Note',
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
		$criteria->compare('date_opration',$this->date_opration,true);
		$criteria->compare('from_time',$this->from_time,true);
		$criteria->compare('to_time',$this->to_time,true);
		$criteria->compare('operation_name',$this->operation_name,true);
		$criteria->compare('diagnosis_id',$this->diagnosis_id);
		$criteria->compare('name_surgeon',$this->name_surgeon,true);
		$criteria->compare('name_anesthesia',$this->name_anesthesia,true);
		$criteria->compare('assistant1',$this->assistant1);
		$criteria->compare('assistant2',$this->assistant2);
		$criteria->compare('assistant3',$this->assistant3);
		$criteria->compare('assistant4',$this->assistant4);
		$criteria->compare('operation_procedure',$this->operation_procedure,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getOperationTheater()
	{
		$admit_id = $_GET['admit_id'];
		$patient_id = $_GET['patient_id'];

		$sql="SELECT t1.id,admit_id,t2.patient_id,date_operation,from_time,to_time,operation_name,
			(select diagnosis from ipd_tbl_conf_Diagnosis t3 where t3.id=t1.diagnosis_id) diagnosis,
			name_surgeon,name_anesthesia,assistant1,assistant2,assistant3,assistant4,operation_procedure,note
					FROM ipd_tbl_OperationTheater t1
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
	 * @return OperationTheater the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
