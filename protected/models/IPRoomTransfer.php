<?php

/**
 * This is the model class for table "ipd_tbl_IPRoomTransfer".
 *
 * The followings are the available columns in table 'ipd_tbl_IPRoomTransfer':
 * @property integer $id
 * @property integer $admit_id
 * @property integer $bed_id
 * @property string $reason
 * @property integer $prepare_by
 * @property string $evt_date
 */
class IPRoomTransfer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_IPRoomTransfer';
	}

	public $category_id;
	public $floor;
	public $room_id;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id, bed_id, prepare_by, evt_date', 'required'),
			array('admit_id, bed_id, prepare_by', 'numerical', 'integerOnly'=>true),
			array('reason', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, bed_id, reason, prepare_by, evt_date', 'safe', 'on'=>'search'),
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
			'bed_id' => 'Bed',
			'reason' => 'Reason',
			'prepare_by' => 'Prepare By',
			'evt_date' => 'Evt Date',
			'category_id'=>'Category ID',
			'room_id'=>'Room;'
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
		$criteria->compare('bed_id',$this->bed_id);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('prepare_by',$this->prepare_by);
		$criteria->compare('evt_date',$this->evt_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getIPRoomTransfer()
	{
		$admit_id = $_GET['admit_id'];
		$patient_id = $_GET['patient_id'];

		$sql="SELECT t1.id,admit_id,t2.patient_id,
			(select room_type from vw_bed_master t3 where t3.id=t1.bed_id) room_type,
			(select floor from vw_bed_master t3 where t3.id=t1.bed_id) floor,
			(select room_no from vw_bed_master t3 where t3.id=t1.bed_id) room_no,
			(select bed_no from vw_bed_master t3 where t3.id=t1.bed_id) bed_no,reason,
			(SELECT doctor_name FROM vw_user_info t4 WHERE t1.prepare_by=t4.userid) prepare_by,evt_date
					FROM ipd_tbl_IPRoomTransfer t1
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
	 * @return IPRoomTransfer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
