<?php

/**
 * This is the model class for table "ipd_tbl_IPDBill".
 *
 * The followings are the available columns in table 'ipd_tbl_IPDBill':
 * @property integer $id
 * @property integer $admit_id
 * @property string $invoice_number
 * @property string $bill_date
 * @property string $total_amount
 * @property string $discount
 * @property double $exchange_rate
 * @property integer $prepare_by
 * @property string $status
 */
class IPDBill extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ipd_tbl_IPDBill';
	}

	public $category;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admit_id, bill_date, prepare_by', 'required'),
			array('admit_id, prepare_by', 'numerical', 'integerOnly'=>true),
			array('exchange_rate', 'numerical'),
			array('invoice_number, status', 'length', 'max'=>10),
			array('total_amount, discount', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admit_id, invoice_number, bill_date, total_amount, discount, exchange_rate, prepare_by, status', 'safe', 'on'=>'search'),
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
			'invoice_number' => 'Invoice Number',
			'bill_date' => 'Bill Date',
			'total_amount' => 'Total Amount',
			'discount' => 'Discount',
			'exchange_rate' => 'Exchange Rate',
			'prepare_by' => 'Prepare By',
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
		$criteria->compare('admit_id',$this->admit_id);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('bill_date',$this->bill_date,true);
		$criteria->compare('total_amount',$this->total_amount,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('exchange_rate',$this->exchange_rate);
		$criteria->compare('prepare_by',$this->prepare_by);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*public function getItemTreatment()
	{
		$getType = $_GET['type'];
		$admit_id = $_GET['admit_id'];
		$patient_id = $_GET['patient_id'];

		$sql="SELECT id,category,admit_id,patient_id,item_id,particular_item,qty,prepare_by,evt_date
		FROM vw_item_treatment
		where  category=:type
		and admit_id=:admit_id
		and patient_id=:patient_id";

		$cmd = Yii::app()->db->createCommand($sql);
		$cmd->bindParam(':type', $getType, PDO::PARAM_STR);
		$cmd->bindParam(':admit_id', $admit_id, PDO::PARAM_INT);
		$cmd->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
		return $cmd->queryRow();
	}*/

	public static function getPatient($name = '')
	{
		// Recommended: Secure Way to Write SQL in Yii
		$sql = "SELECT patient_id id,fullname AS text 
                    FROM v_search_patient 
                    WHERE (fullname LIKE :name)";

		$name = '%' . $name . '%';
		return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));

	}

	public static function GetIPDTreatment($name = '')
	{
		$type=$_GET['myType'];
		$admit_id=$_GET['admit_id'];
		$patient_id=$_GET['myPatient'];
		// Recommended: Secure Way to Write SQL in Yii
		$sql = "SELECT item_id id,particular_item AS text 
                    FROM vw_item_treatment 
                    WHERE (particular_item LIKE :name)
                    and category=:type
                    and admit_id=:admit_id
                    and patient_id=:patient_id
                    and status='1'
                    and (admit_id,item_id,category) not in (SELECT admit_id,item_id,category_type FROM vw_ipd_bill_info)";

		$name = '%' . $name . '%';
		return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name,':type'=>$type,':admit_id'=>$admit_id,':patient_id'=>$patient_id));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IPDBill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
