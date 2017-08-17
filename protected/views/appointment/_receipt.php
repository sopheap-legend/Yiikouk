<!--<style>
#sale_return_policy {
    width: 80%;
    margin: 0 auto;
    text-align: center;
}   

/*Receipt styles start*/
#receipt_wrapper {
    font-family: Arial;
    width: 92% !important;
    font-size: 11px !important;
    margin: 0 auto !important;
    padding: 0 !important;
}

    
#receipt_items td {
  //position: relative;
  padding: 3px;
}      
</style>-->
<style>
#sale_return_policy {
    width: 80%;
    margin: 0 auto;
    text-align: center;
}   

/*Receipt styles start*/
#receipt_wrapper {
    font-family: Arial;
    width: 98% !important;
    font-size: 12px !important;
    margin: 0 auto !important;
    padding: 0 !important;
}

#receipt_items td {
  //position: relative;
  padding: 3px;
}

@media print {
    body {
        position: relative;
    }

    strong {
        color: blue !important;
        font-family: Khmer OS Battambang;
        -webkit-print-color-adjust: exact;
    }

    #footer {
        position: fixed;
        bottom: 0;
        width:100%;
    }
}
</style>

<?php
if (isset($error_message))
{
    echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $error_message);
    exit();
}
?>
<div class="container" id="receipt_wrapper">
    <div class="row">
        <div class="col-xs-3">
            <!-- <div class="panel panel-default"> -->
                <!-- <div class="panel-body"> -->
                <p>
                    <?php //if (Yii::app()->settings->get('receipt', 'printcompanyLogo')=='1') { ?>
                        <?php echo TbHtml::image(Yii::app()->baseUrl . '/images/shop_logo.png','Company\'s logo',array('width'=>'120')); ?> <br>
                        <!-- <h5> Tube Plastic </h5> -->
                    <?php //} ?>
                </p>
                <!-- </div> -->
            <!-- </div> -->
        </div>
        <div class="col-xs-7 text-middle">
            <p align="middle">
                <strong style="font-family: Khmer OS Muol;font-size:x-large;color:blue;"><?php echo TbHtml::encode($clinic_name);?></strong><br>
                <strong style="font-size:large;color:blue;"><?php echo "KE SINOUN HOSPITAL"; ?></strong><br>
                <strong style="font-size:medium;color:blue;"><?php echo TbHtml::encode($clinic_address); ?></strong><br>
                <strong style="font-size:medium;color:blue;"><?php echo TbHtml::encode($clinic_mobile); ?></strong><br>
                <?php //echo TbHtml::image(Yii::app()->baseUrl . '/images/shop_name.png','Company\'s logo',array('width'=>'360')); ?>
            </p>
        </div>
        <div class="col-xs-7 col-xs-offset-1 text-right">
            <!-- <div class="panel panel-default"> -->
                <p>
                    <?php //if (Yii::app()->settings->get('receipt', 'printcompanyName')=='1') { ?>    
                        <strong>
                        <?php //echo TbHtml::encode($clinic_name); ?>
                        </strong>  <br>
                    <?php //} ?>
                        <?php //echo TbHtml::encode($clinic_mobile); ?>
                    <?php //if (Yii::app()->settings->get('receipt', 'printcompanyPhone')=='1') { ?>    
                        <?php //echo TbHtml::encode(Yii::app()->settings->get('site', 'companyPhone')); ?>
                    <?php //} ?>  
                        <?php //echo TbHtml::encode($clinic_address); ?>
                    <?php //if (Yii::app()->settings->get('receipt', 'printcompanyAddress')=='1') { ?>    
                        <?php //echo TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress')); ?>
                    <?php //} ?>
                     <?php //if (Yii::app()->settings->get('receipt', 'printcompanyAddress1')=='1') { ?>    
                        <?php //echo TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress1')); ?>
                    <?php //} ?>    
                    <?php if (Yii::app()->settings->get('receipt', 'printtransactionTime')=='1') { ?> 
                        <?php echo TbHtml::encode($transaction_time); ?>
                    <?php } ?>
                </p>
            <!-- </div> -->
        </div>
    </div>
    <!-- / end client details section -->
    
    <div class="row">

        <div class="col-xs-6">
            <!-- <div class="panel panel-default"> -->
                    <p>
                        <?php //echo Yii::t('app','Doctor') . " : ". TbHtml::encode(ucwords($employee)); ?> <br>
                        <?php //echo Yii::t('app','Patient') . " : ". TbHtml::encode(ucwords($cust_fullname)); ?> <br>
                    </p>
            <!-- </div> -->
        </div>
        
        <div class="col-xs-6 col-xs-offset-0 text-right">

            <!-- <div class="panel panel-default"> -->
                    <p>
                        <?php //echo TbHtml::encode(Yii::t('app','Invoice ID') . " : "  . $sale_id); ?>
                        <?php echo Yii::t('app','Event Date')?>: <?php echo date('Y-m-d'); ?> <br>
                    </p>
            <!-- </div> -->
        </div>
        <div class="col-xs-12" align="middle">
            <p style="font-size:x-large;"><strong><?php echo Yii::t('app','Invoice Label')?>​​​​​​​​​​​​​​​​​​​</strong></p>
        </div>
        <div class="col-xs-12">
            <th><?php echo Yii::t('app','Patient name')?>: <?php echo TbHtml::encode(ucwords($cust_fullname)); ?> </th>
            <th><?php echo Yii::t('app','Sex')?>: <?php echo TbHtml::encode(@$Patient_info->sex);?></th>
            <th><?php echo Yii::t('app','Age')?>: <?php echo TbHtml::encode(@$Patient_info->age);?></th>
            <th><?php echo Yii::t('app','National label')?>:  <?php echo TbHtml::encode(@$Patient_info->nationality); ?></th>
        </div>
        <div class="col-xs-12">
            <th><?php echo Yii::t('app','Address')?>:</th>
            <th><?php echo TbHtml::encode(@$Patient_info->address_line_1);?></th>
            <th></th>
            <th></th>
        </div>
        <div class="col-xs-12">
            <th><?php echo Yii::t('app','Diagnosis')?>: </th>
            <th><?php echo TbHtml::encode(@$visit_info->sympton);?></th>
        </div>
        <div class="col-xs-12">
            <th><?php echo Yii::t('app','Visit')?></th>
            <th><?php echo TbHtml::encode($clinic_name);?></th>
            <th><?php echo Yii::t('app','Service')?></th>
        </div>
        <div class="col-xs-12">
            <th>Have checked the health and treatment at KE SINOUN HOSPITAL and received the services  as following:</th>
        </div>
        <div class="col-xs-12">
        <table class="table" id="receipt_items">
            <thead>
                <tr>
                    <th><?php echo Yii::t('app','#')?></th>
                    <th><?php echo Yii::t('app','Discription')?></th>
                    <!--<th class="center"><?php //echo Yii::t('app','Price'); ?></th>-->
                    <th class="center"> <?php echo Yii::t('app','Quantity')?></th>
                    <th class="center"> <?php echo Yii::t('app','Unit Price')?></th>
                    <th class="center"> <?php echo Yii::t('app','Total Price')?></th>
                    <th class="center"> <?php echo Yii::t('app','Other')?></th>
                </tr>
            </thead>
            <tbody>
                <?php //print_r($cust_info); die(); ?>
                <?php $i=0; ?>
                <?php foreach($cust_info as $id=>$item): ?>
                    <?php
                        $i=$i+1;
                        $discount_arr=Common::Discount($item['discount']);
                        $discount_amt=$discount_arr[0];
                        $discount_symbol=$discount_arr[1];
                        if ($discount_symbol=='$') {
                            $total_item=($item['price']*$item['quantity']*$item['exchange_rate'])-$discount_amt;
                        } else {
                            //$total_item=($item['price']*$item['quantity']*$item['exchange_rate'])-(($item['price']*$item['quantity']*$item['exchange_rate']*$discount_amt)/100);
                            $total_item=($item['price']*$item['quantity'])-(($item['price']*$item['quantity']*$discount_amt)/100);
                        }
                    ?>
                    <tr>
                        <td><?php echo TbHtml::encode($item['id']); ?></td>
                        <td><?php echo TbHtml::encode($item['name']); ?></td>
                        <!--<td class="center"><?php //echo TbHtml::encode(number_format($item['price'],Yii::app()->shoppingCart->getDecimalPlace())); ?></td>-->
                        <td class="center"><?php echo TbHtml::encode(round($item['quantity']),2); ?></td>
                        <td class="center">$<?php echo TbHtml::encode(number_format($item['price'],2, '.', ',')); ?></td>
                        <td class="center">$<?php echo TbHtml::encode(number_format($total_item,2, '.', ',')); ?>
                        <td class="center"><?php //echo TbHtml::encode($item['duration']); ?></td>
                        <!--<td class="center"><?php //echo TbHtml::encode($item['consuming_time']); ?></td>
                        <td class="center"><?php //echo TbHtml::encode($item['instruction']); ?></td>
                        <td class="center"><?php //echo TbHtml::encode($item['comment']); ?></td>-->

                        <!--<td class="center"><?php //echo TbHtml::encode($item['comment']); ?></td>-->

                    </tr>
                <?php endforeach; ?> <!--/endforeach--> 
                    <tr class="gift_receipt_element">
                        <td colspan="5" style='text-align:right;border-top:2px solid #000000;'><?php //echo Yii::t('app','Sub Total'); ?></td>
                        <td colspan="5" style='text-align:right;border-top:2px solid #000000;'> <?php //echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($sub_total,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></td>
                    </tr>
                    <!--<tr class="gift_receipt_element">
                        <td colspan="<?php echo $colspan; ?>" style='text-align:right;'><?php //echo $total_discount . '% ' . Yii::t('app', 'Discount'); ?></td>
                        <td colspan="2" style='text-align:right;'>
                            <?php //echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                        </td>
                    </tr>-->

                <tr class="gift_receipt_element">
                    <td colspan="5" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','iDiscount')); ?></td>
                    <td colspan="5" style='text-align:right;'>
                            <span style="font-size:12px;font-weight:bold">៛
                            <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount,0, '.', ','); ?>
                            </span>
                    </td>
                </tr>
                    
                    <tr class="gift_receipt_element">
                        <td colspan="5" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','PaidUS')); ?></td>
                        <td colspan="5" style='text-align:right;'>
                            <span style="font-size:12px;font-weight:bold">$
                            <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total_us,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                            </span>
                        </td>
                    </tr>
                    <tr class="gift_receipt_element">
                        <td colspan="5" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','PaidKH')); ?></td>
                        <td colspan="5" style='text-align:right;'>
                            <span style="font-size:12px;font-weight:bold">៛
                            <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total_kh,0, '.', ','); ?>
                            </span>
                        </td>
                    </tr>
                    <tr class="gift_receipt_element">
                        <td colspan="5" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','ActualPaid')); ?></td>
                        <td colspan="5" style='text-align:right;'>
                                <span style="font-size:12px;font-weight:bold">៛
                                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($actual_amount-$discount_amount,0, '.', ','); ?>
                                </span>
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <td colspan="3" style='text-align:right'><?php //echo //Yii::t('app','Total in KHR'); ?></td>
                        <td colspan="1" style='text-align:right'><?php //echo //Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($total_khr_round,0, '.', ','); ?></td>
                    </tr>
                    -->
                    
                    <?php //foreach($payments as $payment_id=>$payment): ?> 
                    <!--
                    <tr>
                        <td colspan="3" style='text-align:right'><?php //echo Yii::t('app','Paid Amount'); ?></td>
                        <td colspan="1" style='text-align:right'> <?php //echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($payment['payment_amount'],Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></td>
                    </tr>
                    -->
                    <?php //endforeach;?>
                    
                    <tr>
                        <td colspan="<?php echo $colspan; ?>" style='text-align:right'><?php //echo Yii::t('app','Change Due'); ?></td>
                        <td colspan="7" style='text-align:right'> 
                            <?php //echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($amount_change,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                            <?php //echo Yii::t('app','OR'); ?>
                            <?php //echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_khr_round,0, '.' , ','); ?>
                        </td>
                    </tr>
                     
                    <!--
                    <tr>
                        <td colspan="3" style='text-align:right'><?php //echo Yii::t('app','Change Due in KHR'); ?></td>
                        <td colspan="1" style='text-align:right'><?php //echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_khr_round,0, '.' , ','); ?></td>
                    </tr>
                    -->
            </tbody>
        </table>
        </div>
        <div id="sale_return_policy"> <?php echo TbHtml::encode(Yii::t('app',Yii::app()->settings->get('site', 'returnPolicy'))); ?> </div>
        
    </div>
    <p><p>
    <div id="footer">
        <div class="row">
            <div class="col-xs-3">
                <table style="width:100%">
                    <tr>
                        <td style='text-align:right;border-top:1px solid #000000;'></td>
                    </tr>
                    <tr><td>Accountance <?php //echo TbHtml::encode(ucwords($employee)); ?></td></tr>
                    <tr><td>Date:<?php echo date('d-M-Y') ?></td></tr>
                </table>
            </div>
            <div class="col-xs-3"></div>
            <!--<div class="col-xs-3">Account Process </div>-->
            <div class="col-xs-3"></div>
            <div class="col-xs-3 align-right">
                <table style="width:100%">
                    <tr>
                        <td style='text-align:right;border-top:1px solid #000000;'></td>
                    </tr>
                    <tr style='text-align:left'><td>Patient: <?php echo TbHtml::encode(ucwords($cust_fullname)); ?></td></tr>
                    <tr style='text-align:left'><td>Date:<?php echo date('d-M-Y') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
     
</div>
<!--<script>
$(window).bind("load", function() {
    setTimeout(window.location.href='Prescription',5000); 
    window.print();
    return true;
});    
</script>-->