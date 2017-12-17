<?php

/**
 * This is the model class for table "ipd_tbl_Room".
 *
 * The followings are the available columns in table 'ipd_tbl_Room':
 * @property integer $id
 * @property integer $catg_room_id
 * @property integer $floor
 * @property integer $room_no
 * @property integer $total_bed
 * @property string $price
 */
class IpdTblRoom extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_Room';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catg_room_id, price', 'required'),
			array('catg_room_id, floor, room_no, total_bed', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, catg_room_id, floor, room_no, total_bed, price', 'safe', 'on'=>'search'),
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
			'catg_room_id' => 'Catg Room',
			'floor' => 'Floor',
			'room_no' => 'Room No',
			'total_bed' => 'Total Bed',
			'price' => 'Price',
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
		$criteria->compare('catg_room_id',$this->catg_room_id);
		$criteria->compare('floor',$this->floor);
		$criteria->compare('room_no',$this->room_no);
		$criteria->compare('total_bed',$this->total_bed);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function roomMaster()
	{
		$sql="SELECT t1.id,t2.id room_id,t2.room_no,t2.total_bed,t2.floor,t1.room_type,t2.price
			FROM ipd_tbl_CategoryRoom t1
			INNER JOIN ipd_tbl_Room t2 ON t1.id=t2.catg_room_id";

		return new CSqlDataProvider($sql, array(
			'sort' => array(
				'attributes' => array(
					'id',
				)
			),
		));
	}

	public function roomEnquiry()
	{
		$room_status=@$_POST['room_status'];
		if(!empty($_POST['category_room_id']) && !empty($_POST['room_status']))
		{
			$cond="where catg_room_id=".$_POST['category_room_id'].' and status='."'$room_status'";
		}elseif(!empty($_POST['category_room_id'])){
			$cond="where catg_room_id=".$_POST['category_room_id'];
		}elseif (!empty($_POST['room_status'])){
			$cond="where status="."'$room_status'";
		}else{
			$cond='';
		}

		$sql="SELECT id,bed_no,room_no,floor,room_type,total_bed,status
			FROM(
				SELECT t1.id,t1.bed_no,t2.room_no,t2.floor,t3.room_type,t2.total_bed,t2.catg_room_id,
				CASE
					WHEN t4.bed_id = t1.id THEN 'Occupied'
					ELSE 'UnOccupied'
				END STATUS
				FROM ipd_tbl_Bed t1
				INNER JOIN ipd_tbl_Room t2 ON t1.room_id=t2.id
				INNER JOIN ipd_tbl_CategoryRoom t3 ON t2.catg_room_id=t3.id
				LEFT JOIN ipd_tbl_AdmitPatient t4 ON t1.id=t4.bed_id AND t4.status='1'				
			)AS l1
			$cond
			GROUP BY id,bed_no,room_no,floor,room_type,total_bed,status";

		return new CSqlDataProvider($sql, array(
			'sort' => array(
				'attributes' => array(
					'id',
				)
			),
		));
	}

	public function DisplayAvailableRoom()
	{
		$room_status=@$_POST['room_status'];
		if(!empty($_POST['category_room_id']) && !empty($_POST['room_status']))
		{
			$cond="where catg_room_id=".$_POST['category_room_id'].' and status='."'$room_status'";
		}elseif(!empty($_POST['category_room_id'])){
			$cond="where catg_room_id=".$_POST['category_room_id'];
		}elseif (!empty($_POST['room_status'])){
			$cond="where status="."'$room_status'";
		}else{
			$cond='';
		}

		$sql="SELECT id,bed_no,room_no,floor,room_type,total_bed,status
			FROM(
				SELECT t1.id,t1.bed_no,t2.room_no,t2.floor,t3.room_type,t2.total_bed,t2.catg_room_id,
				CASE
					WHEN t4.bed_id = t1.id THEN 'Occupied'
					ELSE 'UnOccupied'
				END STATUS
				FROM ipd_tbl_Bed t1
				INNER JOIN ipd_tbl_Room t2 ON t1.room_id=t2.id
				INNER JOIN ipd_tbl_CategoryRoom t3 ON t2.catg_room_id=t3.id
				LEFT JOIN ipd_tbl_AdmitPatient t4 ON t1.id=t4.bed_id AND t4.status='1'				
			)AS l1
			$cond
			GROUP BY id,bed_no,room_no,floor,room_type,total_bed,status";

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
	 * @return IpdTblRoom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
