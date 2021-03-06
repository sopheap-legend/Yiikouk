<?php

if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class TreatmentCart extends CApplicationComponent
{
    private $session;

    //private $decimal_place;

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($value)
    {
        $this->session = $value;
    }
    
    public function getDecimalPlace()
    {
        return Yii::app()->settings->get('system', 'decimalPlace') == '' ? 2 : Yii::app()->settings->get('system', 'decimalPlace');
    }
    
    public function getCart()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['cart'])) {
            $this->setCart(array());
        }
        return $this->session['cart'];
    }

    public function setCart($cart_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['cart'] = $cart_data;
        //$session=Yii::app()->session;
        //$session['cart']=$cart_data;
    }
    
    public function addItem($item_id, $price = null)
    {
        $this->setSession(Yii::app()->session);
        //Get all items in the cart so far...
        $items = $this->getCart();
        
        //$model = Item::model()->findbyPk($item_id);
        $models = Treatment::model()->get_selected_treatment($item_id);
        
        if (!$models) {
            return false;
        }

        foreach ($models as $model) {
        
            $item_data = array((int)$item_id =>
                array(
                    'id' => $model["id"],
                    'treatment' => $model["treatment"],
                    'price' => $price!= null ? round($price, $this->getDecimalPlace()) : round($model["price"], $this->getDecimalPlace()),
                )
            );
        }

        if (!isset($items[$item_id])) {
            $items += $item_data;
        }

        $this->setCart($items);
        return true;
    }
    
    public function addMedicine($medicine_id,$price = null,$quantity = 1,$dosage = '',$duration =  1,$frequency =  null,$instruction_id = '',$comment = null,$consuming_time_id = '')
    {
        $this->setSession(Yii::app()->session);
        //Get all items in the cart so far...
        $items = $this->getMedicine();

        //$model = Item::model()->findbyPk($item_id);
        $models = Item::model()->get_selected_medicine($medicine_id);

        if (!$models) {
            return false;
        }

        foreach ($models as $k => $model) {
            $consuming_time_id=$consuming_time_id!=''?$consuming_time_id:$model["consuming_time_id"];
            if($dosage !=''){$dosage=$dosage;}else{if($model["dosage"]==''){$dosage=1;}else{$dosage=$model["dosage"];}}
            $consuming = ConsumingTime::model()->findByPk($consuming_time_id);
            $consuming_dur=@$consuming->multiple!='' ? $consuming->multiple:1;

            if($model['category_name']=='Tablet' || $model['category_name']=='Parcel' || $model['category_name']=='Ampul')
            {
                $quantity=$dosage*$duration*$consuming_dur;
            }else{
                $quantity=1;
            }

            $item_data = array((int)$medicine_id =>
                array(
                    'id' => $model["id"],
                    'name' => $model["name"],
                    'price' => $price!= null ? round($price, $this->getDecimalPlace()) : round($model["unit_price"], $this->getDecimalPlace()),
                    //'quantity' => $dosage*$duration*$consuming->multiple,
                    'quantity'=>  round($quantity),
                    'dosage' => $dosage,
                    'duration' => $duration,
                    'frequency' => $frequency,
                    'instruction_id' => $instruction_id!='' ? $instruction_id:$model["instruction_id"],
                    'comment' => $comment,
                    'consuming_time_id' => $consuming_time_id,
                    'cons_multiple' => $consuming_dur,
                    'measurement' => $model["measurement"],
                    'category_name' => $model["category_name"]
                )
            );
        }

        if (!isset($items[$medicine_id])) {
            $items += $item_data;
        }

        $this->setMedicine($items);
        return true;
    }
    
    public function setMedicine($medicine_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['medicine'] = $medicine_data;
    }

    public function getMedicine()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['medicine'])) {
            $this->setMedicine(array());
        }
        return $this->session['medicine'];
        //return array();
    }

        public function deleteItem($item_id)
    {
        $this->setSession(Yii::app()->session);
        $items = $this->getCart();
        unset($items[$item_id]);
        $this->setCart($items);
    }
    
    public function deleteMedicine($item_id)
    {
        $this->setSession(Yii::app()->session);
        $items = $this->getMedicine();
        unset($items[$item_id]);
        $this->setMedicine($items);
    }
    
    public function editMedicine($medicine_id, $quantity, $price,$dosage,$duration,$frequency,$instruction_id,$comment,$consuming_time_id)
    {
        $medicines = $this->getMedicine();
        if (isset($medicines[$medicine_id])) {
            if($medicines[$medicine_id]['category_name']=='Tablet' || $medicines[$medicine_id]['category_name']=='Parcel' || $medicines[$medicine_id]['category_name']=='Ampul')
            {
                if($consuming_time_id!=null)
                {
                    $consuming = ConsumingTime::model()->findByPk($consuming_time_id);
                    $multiple = $consuming->multiple;
                    $quan_cal=($medicines[$medicine_id]['dosage']) * ($medicines[$medicine_id]['duration']) * $multiple;
                }else
                {
                    $multiple=$medicines[$medicine_id]['cons_multiple'];
                    $quan_cal=$multiple * ($medicines[$medicine_id]['dosage']) * ($medicines[$medicine_id]['duration']);
                }

                if($dosage!=null){$quan_cal=$dosage*($medicines[$medicine_id]['duration']) * $multiple;}
                if($duration!=null){$quan_cal=$medicines[$medicine_id]['dosage']*$duration*$multiple;}
            }else{
                $quan_cal= $medicines[$medicine_id]['quantity'];
                $multiple=1;
            }

            $medicines[$medicine_id]['quantity'] = $quantity !=null ? $quantity : $quan_cal;
            $medicines[$medicine_id]['price'] = $price !=null ? round($price, $this->getDecimalPlace()) : $medicines[$medicine_id]['price'];
            $medicines[$medicine_id]['dosage'] = $dosage !=null ? round($dosage, $this->getDecimalPlace()) : $medicines[$medicine_id]['dosage'];
            $medicines[$medicine_id]['duration'] = $duration !=null ? round($duration, $this->getDecimalPlace()) : $medicines[$medicine_id]['duration'];
            $medicines[$medicine_id]['frequency'] = $frequency !=null ? round($frequency, $this->getDecimalPlace()) : $medicines[$medicine_id]['frequency'];
            $medicines[$medicine_id]['instruction_id'] = $instruction_id !=null ? round($instruction_id, $this->getDecimalPlace()) : $medicines[$medicine_id]['instruction_id'];
            $medicines[$medicine_id]['comment'] = $comment !=null ? $comment : $medicines[$medicine_id]['comment'];
            $medicines[$medicine_id]['consuming_time_id'] = $consuming_time_id !=null ? $consuming_time_id : $medicines[$medicine_id]['consuming_time_id'];
            $medicines[$medicine_id]['cons_multiple'] = $multiple;

            $this->setMedicine($medicines);
        }

        return false;
    }
    
    public function editTreatment($treatment_id, $price)
    {
        $treatments = $this->getCart();
        if (isset($treatments[$treatment_id])) {
            //$medicines[$medicine_id]['quantity'] = $quantity !=null ? $quantity : $medicines[$medicine_id]['quantity'];
            $treatments[$treatment_id]['price'] = $price !=null ? round($price, $this->getDecimalPlace()) : $treatments[$treatment_id]['price'];
            $this->setCart($treatments);
        }

        return false;
    }
    
    public function getPayments()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['payments'])) {
            $this->setPayments(array());
        }
        return $this->session['payments'];
    }

    public function setPayments($payments_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['payments'] = $payments_data;
    }
    
    public function addPayment($visit_id, $actual_amount=0,$kh_payment_amount=0,$us_payment_amount=0)
    {
        $this->setSession(Yii::app()->session);
        $payments = $this->getPayments();
        $payment = array($visit_id =>
            array(
                'visit_id' => $visit_id,
                'actual_amount'=>$actual_amount,
                'kh_payment_amount' => $kh_payment_amount,
                'us_payment_amount' => $us_payment_amount,                
            )
        );

        //payment_method already exists, add to payment_amount
        if (isset($payments[$visit_id])) {
            $payments[$visit_id]['kh_payment_amount'] += $kh_payment_amount;
            $payments[$visit_id]['us_payment_amount'] += $us_payment_amount;
            $payments[$visit_id]['actual_amount'] += $actual_amount;
        } else {
            //add to existing array
            $payments += $payment;
        }

        $this->setPayments($payments);
        $this->set_us_change($actual_amount,$kh_payment_amount,$us_payment_amount);
        $this->set_kh_change($actual_amount,$kh_payment_amount,$us_payment_amount);
        return true;
    }
    
    public function set_us_change($actual_amount,$kh_payment_amount=0,$us_payment_amount=0)
    {
        $this->setSession(Yii::app()->session);
        $exchange_rate = Yii::app()->session['exchange_rate'];
        $amount_change = round(($actual_amount/$exchange_rate),2)-($us_payment_amount+round(($kh_payment_amount/$exchange_rate),2));
        
        $this->session['amount_change'] = $amount_change;
    }
    
    public function set_kh_change($actual_amount,$kh_payment_amount=0,$us_payment_amount=0)
    {
        $this->setSession(Yii::app()->session);
        $exchange_rate = Yii::app()->session['exchange_rate'];
        $amount_change_khr_round = $actual_amount-(($us_payment_amount*$exchange_rate)+$kh_payment_amount);
        
        $this->session['amount_change_khr_round'] = $amount_change_khr_round;
    }
    
    public function get_us_change()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['amount_change'])) {
            $this->setPayments(array());
        }
        return $this->session['amount_change'];
    }
    
    public function get_kh_change()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['amount_change_khr_round'])) {
            $this->setPayments(array());
        }
        return $this->session['amount_change_khr_round'];
    }

    public function setKHDiscount($kh_discount=0)
    {
        $this->setSession(Yii::app()->session);
        $this->session['kh_discount'] = $kh_discount;
    }

    public function getKHDiscount()
    {
        return $this->session['kh_discount'];
    }

    public function setUSDiscount($us_discount)
    {
        $this->setSession(Yii::app()->session);
        $this->session['us_discount'] = $us_discount;
    }

    public function getUSDiscount()
    {
        return $this->session['us_discount'];
    }

    /*this function purpose to Calculate discount both into KHmer currency*/
    public function getAllDiscount($total_amount=0,$visit_id=0)
    {
        $exchange_rate = Yii::app()->session['exchange_rate'];
        $kh_discount=preg_replace('/[^0-9]/s', '',$this->getKHDiscount());
        $us_discount=preg_replace('/[^0-9]/s', '',$this->getUSDiscount());
        $discount_amount_tmp=($us_discount*$exchange_rate)+$kh_discount;

        if($discount_amount_tmp==0 || $discount_amount_tmp=='')
        {
            $discount_amount=Appointment::model()->getPaymentDiscount($visit_id);
            if(empty($discount_amount))$discount_amount=0;
        }else{
            $discount_amount=$discount_amount_tmp;
        }

        if($total_amount-$discount_amount>=0)
        {
            return $discount_amount;
        }else{
            return $total_amount;
        }
        //return ($us_discount*$exchange_rate)+$kh_discount;

        //return 100;
    }


    function getMode()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['recv_mode'])) {
            $this->setMode('receive');
        }
        return $this->session['recv_mode'];
    }

    function setMode($mode)
    {
        $this->setSession(Yii::app()->session);
        $this->session['recv_mode'] = $mode;
    }

    public function clearMode()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['recv_mode']);
    }

    public function deletePayment($visit_id)
    {
        $payments = $this->getPayments();
        unset($payments[$visit_id]);
        unset($this->session['amount_change']);
        unset($this->session['amount_change_khr_round']);
        unset($this->session['kh_discount']);
        unset($this->session['us_discount']);
        $this->setPayments($payments);
    }
    
    public function emptyPayment()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['payments']);
        unset($this->session['amount_change']);
        unset($this->session['amount_change_khr_round']);
        unset($this->session['kh_discount']);
        unset($this->session['us_discount']);
    }
    
    protected function emptyCart()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['cart']);
    }

    public function emptyMedicine()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['medicine']);
    }
    
    public function clearAll()
    {
        $this->emptyCart();
        $this->emptyMedicine();
        $this->emptyPayment();
        $this->clearMode();
    }




}

?>