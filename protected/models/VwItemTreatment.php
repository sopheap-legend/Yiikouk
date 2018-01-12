<?php

/**
 * This is the model class for table "vw_item_treatment".
 *
 * The followings are the available columns in table 'vw_item_treatment':
 * @property string $id
 * @property string $status
 * @property integer $admit_id
 * @property double $price
 * @property integer $patient_id
 * @property integer $item_id
 * @property string $category
 * @property string $particular_item
 * @property integer $qty
 * @property string $note
 * @property string $prepare_by
 * @property string $evt_date
 */
class VwItemTreatment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_item_treatment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id, patient_id, item_id, qty', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('id', 'length', 'max'=>22),
			array('status', 'length', 'max'=>20),
			array('category', 'length', 'max'=>10),
			array('particular_item, note', 'length', 'max'=>50),
			array('prepare_by', 'length', 'max'=>101),
			array('evt_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, admit_id, price, patient_id, item_id, category, particular_item, qty, note, prepare_by, evt_date', 'safe', 'on'=>'search'),
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
			'status' => 'Status',
			'admit_id' => 'Admit',
			'price' => 'Price',
			'patient_id' => 'Patient',
			'item_id' => 'Item',
			'category' => 'Category',
			'particular_item' => 'Particular Item',
			'qty' => 'Qty',
			'note' => 'Note',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('admit_id',$this->admit_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('patient_id',$this->patient_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('particular_item',$this->particular_item,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('prepare_by',$this->prepare_by,true);
		$criteria->compare('evt_date',$this->evt_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwItemTreatment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
