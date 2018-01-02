<?php

/**
 * This is the model class for table "ipd_tbl_ParticularItem".
 *
 * The followings are the available columns in table 'ipd_tbl_ParticularItem':
 * @property integer $id
 * @property integer $particular_catg_id
 * @property string $particular_item
 * @property double $price
 * @property string $status
 * @property string $remarks
 */
class ParticularItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_ParticularItem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('particular_catg_id, particular_item, price', 'required'),
			array('particular_catg_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('particular_item, remarks', 'length', 'max'=>50),
			array('status', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, particular_catg_id, particular_item, price, status, remarks', 'safe', 'on'=>'search'),
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
			'particular_catg_id' => 'Particular Catg',
			'particular_item' => 'Particular Item',
			'price' => 'Price',
			'status' => 'Status',
			'remarks' => 'Remarks',
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
		$criteria->compare('particular_catg_id',$this->particular_catg_id);
		$criteria->compare('particular_item',$this->particular_item,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('remarks',$this->remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ParticularItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
