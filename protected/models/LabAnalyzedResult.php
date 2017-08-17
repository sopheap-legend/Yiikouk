<?php

/**
 * This is the model class for table "lab_analyzed_result".
 *
 * The followings are the available columns in table 'lab_analyzed_result':
 * @property integer $id
 * @property integer $lab_detail_id
 * @property string $lab_item_desc
 * @property string $lab_value
 */
class LabAnalyzedResult extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lab_analyzed_result';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lab_detail_id', 'numerical', 'integerOnly'=>true),
			array('lab_item_desc, lab_value', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lab_detail_id, lab_item_desc, lab_value', 'safe', 'on'=>'search'),
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
			'lab_detail_id' => 'Lab Detail',
			'lab_item_desc' => 'Lab Item Desc',
			'lab_value' => 'Lab Value',
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
		$criteria->compare('lab_detail_id',$this->lab_detail_id);
		$criteria->compare('lab_item_desc',$this->lab_item_desc,true);
		$criteria->compare('lab_value',$this->lab_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getClientResult($visit_id,$treatment_item,$item_id){
		$sql="SELECT t3.lab_value 
			FROM lab_analized t1
			INNER JOIN lab_analyzed_detail t2 ON t1.id=t2.lab_analized_id
			INNER JOIN lab_analyzed_result t3 ON t2.id=t3.lab_detail_id
			WHERE t1.visit_id=:visit_id
			AND t2.id=:item_id
			AND t3.lab_item_desc=:treatment_item";

		$cmd=Yii::app()->db->createCommand($sql);
		$cmd->bindParam(':visit_id', $visit_id, PDO::PARAM_INT);
		$cmd->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$cmd->bindParam(':treatment_item', $treatment_item, PDO::PARAM_STR);

		$result=$cmd->queryRow();

		return $result['lab_value'];
	}

	public function setLabResult($visit_id,$lab_id,$lab_desc,$lab_value)
	{
		$cmd = Yii::app()->db->createCommand("select lab_result_sheet(:visit_id,:lab_id,:lab_desc,:lab_value) from dual");

		$cmd->bindParam(':visit_id' , $visit_id);
		$cmd->bindParam(':lab_id' ,$lab_id);
		$cmd->bindParam(':lab_desc',$lab_desc);
		$cmd->bindParam(':lab_value',$lab_value);
		$results=$cmd->queryAll();

		foreach($results as $result)
			foreach ($result as $k=>$value)

				return $value;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LabAnalyzedResult the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
