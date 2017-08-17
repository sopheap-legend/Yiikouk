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
        position: relative;
        padding: 3px;
    }

    @media print {

        /*.item-test{
            font-family: Arial;
            width: 200mm;
            alignment: center;
        }*/

        /*#tbl-result{
            border: double;
            padding: 3px;
        }*/

        strong{
            color: blue !important;
            font-family: Khmer OS Battambang;
        }

        #receipt_items td {
            position: relative;d
            padding: 3px;
        }

        #footer {
            position: fixed;
            bottom: 0;
            width:100%;
        }
    }

    label{
        font-size: 14px;
    }

    label strong{
        font-size: 16px;
        color: blue !important;
    }
</style>

<div class="form-group" id="receipt_wrapper">
    <div class="containter">
        <div class="row">
            <div class="col-md-12 col-xs-offset-2 text-middle" style="display: inline-flex">
                <div>
                    <?php echo TbHtml::image(Yii::app()->baseUrl . '/images/shop_logo.png','Company\'s logo',array('width'=>'100')); ?>
                </div>
                <div style="text-align: center">
                    <strong style="font-family: Khmer OS Muol;font-size: x-large;color:blue;"><?php echo TbHtml::encode($clinic_name);?></strong><br>
                    <strong style="font-size:large;color:blue;"><?php echo "KE SINOUN HOSPITAL"; ?></strong><br>
                    <strong style="font-size:medium;color:blue;"><?php echo TbHtml::encode($clinic_address); ?></strong><br>
                    <strong style="font-size:medium;color:blue;"><?php echo TbHtml::encode($clinic_mobile); ?></strong>
                </div>
                    <?php //echo TbHtml::image(Yii::app()->baseUrl . '/images/shop_name.png','Company\'s logo',array('width'=>'360')); ?> <br>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <p>
                    <?php echo TbHtml::encode(Yii::t('app','Patient name') . " : "  .$client->fullname); ?> <br>
                    <?php echo TbHtml::encode(Yii::t('app','Sex').': '.$client->sex.' '.Yii::t('app','Age').': '.$client->age.' '); ?> <br>
                    <?php echo TbHtml::encode(Yii::t('app','Diagnosis') . " : "  .$visit_info->sympton); ?> <br>
                    <?php echo TbHtml::encode(Yii::t('app','Address') . " : "  .$client->address_line_1); ?> <br>
                    <?php echo TbHtml::encode( Yii::t('app','Event Date') . " : "  . $visit_date); ?>
                </p>
            </div>
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
    <!--<div class="gift_receipt_element item-test">
        <table id="receipt_items" style="width:100%">
            <tr>
                <td align="center"><h3><strong>LABORATORY RESULT</strong></h3></td>
            </tr>
            <tr>
                <td style='text-align:right;border-top:1px solid #000000;'></td>
            </tr>
        </table>
    </div>-->
    <div class="item-test">
        <div class="col-xs-12" align="middle">
            <div style="font-size:large;"><strong>ប័ណ្ណវិភាគវេជ្ជសាស្រ្ត</strong></div>
            <div style="font-size:large;">LAB ANALIZED SHEET</div>
        </div>
    </div>
    <div class="item-test gift_receipt_element">
        <?php
        $groupGridColumns = ReportColumn::getLabResultColumn();
        $groupGridColumns[] = array(
            'name' => 'group_name',
            'value' => '$data["group_name"]',
            'headerHtmlOptions' => array('style' => 'display:none'),
            'htmlOptions' => array('style' => 'display:none')
        );

        $this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
            'type' => 'bordered',
            'id' => 'tbl-result',
            'dataProvider' => LabAnalized::model()->printLabResult($visit_id),
            'template' => "{items}",
            'extraRowColumns' => array('group_name'),
            'extraRowHtmlOptions' => array('style' => 'padding:12px;border:10px','class' => 'active',),
            'columns' => $groupGridColumns,
            'mergeColumns' => array('treatment_item'),
        )); ?>
    </div>
    <p/><p/>
    <div id="footer">
        <div class="row">
            <div class="col-xs-3">
                <table id="receipt_items" style="width:100%">
                    <tr>
                        <td style='text-align:right;border-top:1px solid #000000;'></td>
                    </tr>
                    <tr><td><?php echo TbHtml::encode(Yii::t('app','Doctor')); ?>: វជ្ជ. <?php echo $doctor->doctor_name; ?></td></tr>
                    <tr><td>Date:<?php echo date('d-M-Y') ?></td></tr>
                </table>
            </div>
            <div class="col-xs-3"></div>
            <!--<div class="col-sm-3">Account Process </div>-->
            <div class="col-xs-3"></div>
            <div class="col-xs-3 align-right">
                <table id="receipt_items" style="width:100%">
                    <tr>
                        <td style='text-align:right;border-top:1px solid #000000;'></td>
                    </tr>
                    <tr style='text-align:left'><td><?php echo TbHtml::encode(Yii::t('app','Technical')); ?>: <?php echo $lab_tech->doctor_name; ?></td></tr>
                    <tr style='text-align:left'><td>Date:<?php echo date('d-M-Y') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $url = Yii::app()->createUrl('Appointment/labocheck/'); ?>
<script>
    $(window).bind("load", function() {
        setTimeout(window.location.href='<?php echo $url; ?>',5000);
        window.print();
        return true;
    });
</script>