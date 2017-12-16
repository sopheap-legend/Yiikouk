<?php

/**
 * This is the model class for table "ipd_tbl_Bed".
 *
 * The followings are the available columns in table 'ipd_tbl_Bed':
 * @property integer $id
 * @property integer $room_id
 * @property integer $bed_no
 * @property string $status
 */
class IpdTblBed extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_Bed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_id, bed_no', 'required'),
			array('room_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, room_id, bed_no, status', 'safe', 'on'=>'search'),
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
			'room_id' => 'Room',
			'bed_no' => 'Bed No',
			'status' => 'Status',
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
		$criteria->compare('room_id',$this->room_id);
		$criteria->compare('bed_no',$this->bed_no);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function bedMaster()
	{
		$sql="SELECT t1.id,t1.bed_no,t2.room_no,t2.floor,t3.room_type FROM ipd_tbl_Bed t1
				INNER JOIN ipd_tbl_Room t2 ON t1.room_id=t2.id
				INNER JOIN ipd_tbl_CategoryRoom t3 ON t2.catg_room_id=t3.id";

		return new CSqlDataProvider($sql, array(
			'sort' => array(
				'attributes' => array(
					'id',
				)
			),
		));
	}

	public function getFloorByCatg($catg_room_id)
	{
		$sql="select distinct floor from ipd_tbl_Room where catg_room_id=:catg_room_id";

		$cmd = Yii::app()->db->createCommand($sql);
		$cmd->bindParam(':catg_room_id', $catg_room_id, PDO::PARAM_INT);

		return $cmd->queryall();
	}

	public function getRoomByCatg($catg_room_id,$floor)
	{
		$sql="select distinct id,room_no from ipd_tbl_Room where catg_room_id=:catg_room_id";

		$cmd = Yii::app()->db->createCommand($sql);
		$cmd->bindParam(':catg_room_id', $catg_room_id, PDO::PARAM_INT);

		return $cmd->queryall();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IpdTblBed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
