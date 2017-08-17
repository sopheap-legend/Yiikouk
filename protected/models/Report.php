<?php

/**
 * This is the model class for table "sale".
 *
 * The followings are the available columns in table 'sale':
 * @property integer $id
 * @property string $sale_time
 * @property integer $customer_id
 * @property integer $employee_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $status
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property SaleItem[] $saleItems
 */
class Report extends CFormModel
{
    public $search;
    public $amount;
    public $quantity;
    public $from_date;
    public $to_date;
    public $sale_id;
    public $receive_id;
    public $employee_id;
    public $search_id;

    public $name;
    public $supplier;
    public $unit_price;
    public $cost_price;
    public $reorder_level;
    
    private $item_active = '1';
    private $active_status = '1';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Sale the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('sale_time', 'required'),
            array('client_id, employee_id', 'numerical', 'integerOnly' => true),
            array('sub_total', 'numerical'),
            array('status', 'length', 'max' => 25),
            array('payment_type', 'length', 'max' => 255),
            array('sale_time', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('remark, sale_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sale_time, client_id, employee_id, sub_total, payment_type,status, remark', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'date' => Yii::t('app', 'date'),
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
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        );
    }

    public function topProduct()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,sum(si.quantity) qty,SUM(price*quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id 
                     AND sale_time>=str_to_date(:from_date,'%d-%m-%Y') 
                     AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                     AND IFNULL(s.status,'1')='1'
                GROUP BY item_name
                ORDER BY qty DESC LIMIT 5
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }


    public function stockCount($interval)
    {
 
        if ($interval=='all') {
            $sql="SELECT id,`name`,quantity 
                  FROM item
                  WHERE status=:status";
            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status'=>$this->item_active));
        } else {
            $sql ="SELECT id,`name`,quantity
                   FROM item
                   WHERE count_interval=:interval
                   AND status=:status";
            
            $sql="SELECT i.id,i.`name`,i.quantity,null actual_qty,
                    date_format(ic.modified_date,'%d-%m-%Y') modified_date,
                    date_format(ic.next_count_date,'%d-%m-%Y') next_count_date,
                    upper(concat_ws(' - ',last_name,first_name)) employee
                  FROM item i,item_count_schedule ic,employee e 
                  WHERE i.id=ic.item_id 
                  AND i.status=:status 
                  AND e.id=ic.employee_id
                  AND ic.count_interval=:interval
                  -- AND DATE(ic.next_count_date) = CURRENT_DATE()";
            
            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':interval'=>$interval,':status'=>$this->item_active));
        }
        
        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'quantity',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function dashtopProduct()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,SUM(si.quantity) qty,SUM(price*quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id 
                     AND sale_time between DATE_FORMAT(NOW() ,'%Y') AND NOW()
                     AND IFNULL(s.status,'1')='1'
                GROUP BY item_name
                ORDER BY qty DESC LIMIT 10
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function dashtopProductbyAmount()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,SUM(si.quantity) qty,SUM(price*quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id 
                     AND sale_time between DATE_FORMAT(NOW() ,'%Y') AND NOW()
                     AND IFNULL(s.status,'1')='1'
                GROUP BY item_name
                ORDER BY amount DESC LIMIT 10
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function dbQueue()
    {
        $sql = "SELECT COUNT(*) nCount
                FROM `appointment`
                WHERE DATE(appointment_date)=DATE(NOW())
                AND `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => 'Waiting'));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    public function dbTopVisitPatient()
    {
        $sql="SELECT  @ROW := @ROW + 1 AS rank,patient_name,nvisit
            FROM (
                SELECT CONCAT(c.first_name,' ',c.last_name) patient_name,COUNT(*) nvisit
                FROM appointment a , patient p , contact c
                WHERE a.patient_id = p.patient_id
                AND p.contact_id = c.id
                AND a.status=:status
                GROUP BY patient_name
                ORDER BY nvisit DESC LIMIT 10
                ) t1, (SELECT @ROW := 0) r ";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array('status'=>'Complete'));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
           /* 'sort' => array(
                'attributes' => array(
                    'customer_name',
                ),
            ),*/
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    /*
     * Completed Appointment Chart
     */
    public function dbDailyVisitChart()
    {

        $sql="SELECT DATE(appointment_date) appointment_date,COUNT(*) nvisit
                FROM `appointment`
                WHERE date(appointment_date) BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()
                AND `status`='Complete'
                GROUP BY DATE(appointment_date)
                ORDER BY 1";

        return Yii::app()->db->createCommand($sql)->queryAll(true);
    }

    public function db2DVisit()
    {
        $sql="SELECT COUNT(*) nvisit
                FROM `appointment`
                WHERE DATE(appointment_date)=DATE(NOW())
                AND `status` in ('Complete','Consultation','Waiting')";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true);

        foreach ($result as $record) {
            $result = $record['nvisit'];
        }

        return $result;
    }

    public function totalSale2Y()
    {
        $sql = "SELECT IFNULL(SUM(sub_total),0) sale_amount
                FROM sale
                WHERE YEAR(sale_time) = YEAR(CURDATE())
                AND `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => $this->item_active));

        foreach ($result as $record) {
            $result = $record['sale_amount'];
        }

        return $result;
    }

    public function dbcountPatient()
    {
        $sql = "SELECT count(*) nCount
                FROM `patient`
                WHERE `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status' => $this->active_status));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    public function dbcountPatientReg2D()
    {
        $sql = "SELECT count(*) nCount
                FROM `patient`
                WHERE `status`=:status
                AND DATE(created_at)=DATE(NOW())";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => $this->active_status));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    public function outofStock()
    {
        $sql = "SELECT count(*) nCount
                FROM `item`
                WHERE quantity=0
                AND `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => $this->active_status));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    public function negativeStock()
    {
        $sql = "SELECT count(*) nCount
                FROM `item`
                WHERE quantity<0
                AND `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => $this->active_status));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    public function itemExpiry($filter)
    {
        $sql = "SELECT name,total_qty,quantity,expire_date,n_month_expire
                FROM v_item_expire
                WHERE n_month_expire <= :month_to_expire
                ORDER BY n_month_expire";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':month_to_expire' => $filter));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'name',
            'sort' => array(
                'attributes' => array(
                    'name',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleItemSummary()
    {
        $sql="SELECT item_name,CONCAT_WS(' - ', from_date, to_date) date_report,
                round(sub_total,2) sub_total,round(quantity,0) quantity,NULL profit
                FROM(
                    SELECT medicine_name item_name,MIN(DATE_FORMAT(t2.visit_date,'%d-%m-%Y')) from_date, MAX(DATE_FORMAT(t2.visit_date,'%d-%m-%Y')) to_date,
                    SUM(quantity) quantity,SUM(quantity*unit_price*exchange_rate) sub_total
                    FROM v_medicine_payment t1
                    INNER JOIN visit t2 ON t1.visit_id=t2.visit_id
                    WHERE t2.visit_date>=STR_TO_DATE(:from_date,'%d-%m-%Y')  
                    AND t2.visit_date<DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY) 
                    GROUP BY medicine_name
                )AS l1";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'item_name',
            'sort' => array(
                'attributes' => array(
                    'date_report',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function inventory($filter)
    {

        if ($this->search_id !== '') {
            $sql ="SELECT t1.id,t1.name,t3.name category_name,t1.unit_quantity quantity,t1.cost_price,t1.unit_price,t1.reorder_level,GROUP_CONCAT(DISTINCT t2.company_name) supplier
                   FROM item t1 LEFT JOIN v_item_supplier t2
                        ON t2.item_id=t1.id LEFT JOIN category t3 on t3.id = t1.category_id
                   WHERE (t1.name like :search_id or t3.name like :search_id)
                   GROUP BY t1.id,t1.name,t1.quantity,t1.cost_price,t1.unit_price,t1.reorder_level,t3.name";

            $search_str = $this->search_id . '%';

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status' => Yii::app()->params['active_status'], ':search_id' => $search_str));
        } else {

            $condition = $this->inventoryFilter($filter);
            $sql ="SELECT t1.id,t1.name,t3.name category_name,t1.unit_quantity quantity,t1.cost_price,t1.unit_price,t1.reorder_level,GROUP_CONCAT(DISTINCT t2.company_name) supplier
                   FROM item t1 LEFT JOIN v_item_supplier t2
                        ON t2.item_id=t1.id LEFT JOIN category t3 on t3.id = t1.category_id
                   $condition
                   GROUP BY t1.id,t1.name,t1.quantity,t1.cost_price,t1.unit_price,t1.reorder_level,t3.name";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array());

        }
        //echo $sql;
        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'quantity','name','category_name'
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    protected function inventoryFilter($filter)
    {
        switch ($filter) {
            case 'all':
                $condition = '';
                break;
            case 'low':
                $condition = 'WHERE IFNULL(reorder_level,0)>unit_quantity';
                break;
            case 'outstock':
                $condition = 'WHERE round(unit_quantity,0)=0';
                break;
            case 'onstock':
                $condition = 'WHERE unit_quantity>0';
                break;
            case 'negative':
                $condition = 'WHERE unit_quantity<0';
                break;
        }

        return $condition;
    }

    public function saleInvoice()
    {
        if ($this->search_id !== '')
        {

        }else{
            $sql="SELECT l2.visit_id,vs.visit_date,
            (SELECT client_name FROM(SELECT patient_id,t2.first_name client_name FROM patient t1 INNER JOIN contact t2 ON t1.contact_id=t2.id)AS pt WHERE pt.patient_id=b.patient_id) client_name,
            (SELECT user_name FROM rbac_user usr WHERE usr.id=b.user_id) employee_name,
            round(total) total,b.status
            FROM (
                SELECT visit_id,SUM(amount) total
                FROM 
                (
                    SELECT medicine_id id,medicine_name item,visit_id,quantity,quantity*unit_price*exchange_rate amount,'medicine' flag 
                    FROM v_medicine_payment 
                    UNION ALL
                    SELECT id,treatment,visit_id,1 quantity,amount*exchange_rate,'treatment' flag
                    FROM v_bill_payment
                    UNION ALL
                    SELECT id,lab_item_name,visit_id,1 quantity,IFNULL(unit_price,0)*exchange_rate unit_price,'bloodtest' flag
                    FROM v_bloodtest_payment
                )AS l1
                GROUP BY visit_id
            )AS l2
            INNER JOIN visit vs ON l2.visit_id=vs.visit_id 
            INNER JOIN bill b ON b.visit_id=vs.visit_id and b.status=2
            WHERE visit_date>=str_to_date(:from_date,'%d-%m-%Y')
            AND visit_date<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'visit_id',
            'sort' => array(
                'attributes' => array(
                    'visit_id', 'visit_date',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

}
