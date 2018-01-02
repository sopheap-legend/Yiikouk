<?php

/**
 * This is the model class for table "ipd_tbl_PatientHistory".
 *
 * The followings are the available columns in table 'ipd_tbl_PatientHistory':
 * @property integer $id
 * @property integer $admit_id
 * @property string $allergies
 * @property string $warning
 * @property string $social_history
 * @property string $family_history
 * @property string $personal_history
 * @property string $past_medical_history
 */
class PatientHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_PatientHistory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id, allergies, warning, social_history, family_history, personal_history, past_medical_history', 'required'),
			array('admit_id', 'numerical', 'integerOnly'=>true),
			array('allergies, warning, social_history, family_history, personal_history, past_medical_history', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, allergies, warning, social_history, family_history, personal_history, past_medical_history', 'safe', 'on'=>'search'),
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
			'allergies' => 'Allergies',
			'warning' => 'Warning',
			'social_history' => 'Social History',
			'family_history' => 'Family History',
			'personal_history' => 'Personal History',
			'past_medical_history' => 'Past Medical History',
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
		$criteria->compare('allergies',$this->allergies,true);
		$criteria->compare('warning',$this->warning,true);
		$criteria->compare('social_history',$this->social_history,true);
		$criteria->compare('family_history',$this->family_history,true);
		$criteria->compare('personal_history',$this->personal_history,true);
		$criteria->compare('past_medical_history',$this->past_medical_history,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPatientHistory()
	{
		$admit_id = $_GET['admit_id'];
		$patient_id = $_GET['patient_id'];

		$sql="SELECT t1.id,admit_id,t2.patient_id,allergies,warning,social_history,family_history,
			personal_history,past_medical_history
					FROM ipd_tbl_PatientHistory t1
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
	 * @return PatientHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
