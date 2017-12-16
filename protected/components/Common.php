<?php
Class Common extends CApplicationComponent
{
    public static function Discount($discount) {
        if (substr($discount, 0, 1) == '$') {
            $discount_amount = substr($discount, 1);
            $discount_type = '$';
        } else {
            $discount_amount = $discount;
            $discount_type = '%';
        }
        
        return array($discount_amount, $discount_type);
    }

    public function CheckRoomAvailable($room_id='',$floor='',$catg_room_id='')
    {
        $sql="SELECT total_bed-nBed Available
            FROM(
            SELECT t2.id room_id,t2.floor,t3.id catg_room_id,t2.total_bed,COUNT(t4.bed_id) nBed
                FROM ipd_tbl_Bed t1
                INNER JOIN ipd_tbl_Room t2 ON t1.room_id=t2.id
                INNER JOIN ipd_tbl_CategoryRoom t3 ON t2.catg_room_id=t3.id
                LEFT JOIN ipd_tbl_AdmitPatient t4 ON t1.id=t4.bed_id AND t4.status='1'
                GROUP BY t2.id,t2.floor,t3.id,t2.total_bed
            )AS l1
            WHERE room_id=:room_id
            AND floor=:floor
            AND catg_room_id=:catg_room_id";

        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $cmd->bindParam(':floor', $floor, PDO::PARAM_STR);
        $cmd->bindParam(':catg_room_id', $catg_room_id, PDO::PARAM_INT);

        return $cmd->queryScalar();
    }

    public function CheckBedAvailbale($bed_id=null)
    {
        $sql="select count(*) Available from ipd_tbl_AdmitPatient WHERE bed_id=:bed_id and status='1'";

        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':bed_id', $bed_id, PDO::PARAM_INT);

        return $cmd->queryScalar();
    }
}