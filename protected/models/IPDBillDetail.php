<?php

/**
 * This is the model class for table "ipd_tbl_IPDBillDetail".
 *
 * The followings are the available columns in table 'ipd_tbl_IPDBillDetail':
 * @property integer $id
 * @property integer $bill_id
 * @property string $category_type
 * @property integer $item_id
 * @property string $amount
 * @property string $discount
 */
class IPDBillDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_IPDBillDetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bill_id, category_type, item_id', 'required'),
			array('bill_id, item_id', 'numerical', 'integerOnly'=>true),
			array('category_type', 'length', 'max'=>20),
			array('amount, discount', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bill_id, category_type, item_id, amount, discount', 'safe', 'on'=>'search'),
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
			'bill_id' => 'Bill',
			'category_type' => 'Category Type',
			'item_id' => 'Item',
			'amount' => 'Amount',
			'discount' => 'Discount',
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
		$criteria->compare('bill_id',$this->bill_id);
		$criteria->compare('category_type',$this->category_type,true);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('discount',$this->discount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IPDBillDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
