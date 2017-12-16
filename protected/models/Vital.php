<?php

/**
 * This is the model class for table "ipd_tbl_Vital".
 *
 * The followings are the available columns in table 'ipd_tbl_Vital':
 * @property integer $id
 * @property integer $admit_id
 * @property integer $pulse_rate
 * @property double $blood_pressure
 * @property integer $temperature
 * @property integer $respiration
 * @property double $height
 * @property double $weight
 * @property double $measurement
 */
class Vital extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $general_error;

	public function tableName()
	{
		return 'ipd_tbl_Vital';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id,pulse_rate, temperature, respiration', 'required'),
			//array('general_error', 'vital_validate'),
			array('admit_id, pulse_rate, temperature, respiration', 'numerical', 'integerOnly'=>true),
			array('blood_pressure, height, weight, measurement', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, pulse_rate, blood_pressure, temperature, respiration, height, weight, measurement', 'safe', 'on'=>'search'),
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
			'pulse_rate' => 'Pulse Rate',
			'blood_pressure' => 'Blood Pressure',
			'temperature' => 'Temperature',
			'respiration' => 'Respiration',
			'height' => 'Height',
			'weight' => 'Weight',
			'measurement' => 'Measurement',
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
		$criteria->compare('pulse_rate',$this->pulse_rate);
		$criteria->compare('blood_pressure',$this->blood_pressure);
		$criteria->compare('temperature',$this->temperature);
		$criteria->compare('respiration',$this->respiration);
		$criteria->compare('height',$this->height);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('measurement',$this->measurement);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*public function vital_validate($attribute, $params)
	{
		if (isset($_POST['vital_submit'])) {
			if ($this->pulse_rate == '' && $this->temperature=='' && $this->blood_pressure=='' && $this->respiration=='' &&  $this->height=='' && $this->weight=='')
			{
				$this->addError('general_error', 'The All input value need at least 1 input.');
			}
		}
	}*/

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vital the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
