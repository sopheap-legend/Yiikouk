<?php

/**
 * This is the model class for table "ipd_tbl_IntakeRecord".
 *
 * The followings are the available columns in table 'ipd_tbl_IntakeRecord':
 * @property integer $id
 * @property integer $admit_id
 * @property string $particular
 * @property double $iv_fluid
 * @property double $oral
 * @property integer $no_stool
 * @property integer $no_urin
 * @property integer $prepare_by
 * @property string $evt_date
 */
class IntakeRecord extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_IntakeRecord';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id,particular, iv_fluid, oral, no_stool, no_urin, prepare_by, evt_date', 'required'),
			array('admit_id, no_stool, no_urin, prepare_by', 'numerical', 'integerOnly'=>true),
			array('iv_fluid, oral', 'numerical'),
			array('particular', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, particular, iv_fluid, oral, no_stool, no_urin, prepare_by, evt_date', 'safe', 'on'=>'search'),
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
			'particular' => 'Particular',
			'iv_fluid' => 'Iv Fluid',
			'oral' => 'Oral',
			'no_stool' => 'No Stool',
			'no_urin' => 'No Urin',
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
		$criteria->compare('particular',$this->particular,true);
		$criteria->compare('iv_fluid',$this->iv_fluid);
		$criteria->compare('oral',$this->oral);
		$criteria->compare('no_stool',$this->no_stool);
		$criteria->compare('no_urin',$this->no_urin);
		$criteria->compare('prepare_by',$this->prepare_by);
		$criteria->compare('evt_date',$this->evt_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getIntakeRecord()
	{
		$admit_id = $_GET['admit_id'];
		$patient_id = $_GET['patient_id'];

		$sql="SELECT t1.id,admit_id,t2.patient_id,particular,iv_fluid,oral,no_stool,no_urin,
			(SELECT doctor_name FROM vw_user_info t4 WHERE t1.prepare_by=t4.userid) prepare_by,evt_date
					FROM ipd_tbl_IntakeRecord t1
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
	 * @return IntakeRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
