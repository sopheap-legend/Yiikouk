<?php

if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class IPDTreatmentCart extends CApplicationComponent
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

    public function setIPDBill($cart_data=null)
    {
        $this->setSession(Yii::app()->session);
        //$items = $this->getParticularItem();
        $this->session['IPDBill'] = $cart_data;
    }

    public function addParticularItem($item_id=null,$category='',$qty=1,$comment='',$patient_id=null,$admit_id=null)
    {
        $this->setSession(Yii::app()->session);
        
        $items=$this->getParticularItem();
        $this->setSession(Yii::app()->session);
        $models = VwItemTreatment::model()->find('item_id=:item_id and category=:category',array(':item_id'=>$item_id,':category'=>$category));

        if (!$models) {
            return false;
        }

        $item_data = array($models->id =>
            array(
                'id' => $models->item_id,
                'name' => $models->particular_item,
                'price' => $models->price,
                'qty'=>  (int)$qty,
                'comment' => $comment,
                'category' => $models->category,
                'patient_id'=>$patient_id,
                'admit_id'=>$admit_id
            )
        );

        if (!isset($items[$models->id])) {
            $items += $item_data;
        }

        $this->setIPDBill($items);
        return true;
    }

    public function getParticularItem()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['IPDBill'])) {
            $this->setIPDBill(array());
        }
        return $this->session['IPDBill'];
    }

    public function deleteParticularItem($item_id)
    {
        $this->setSession(Yii::app()->session);
        $items = $this->getParticularItem();
        unset($items[$item_id]);
        $this->setIPDBill($items);
    }

    public function emptyIPDBill()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['IPDBill']);
    }
}