<?php //print_r($data['particular_item_selected']); ?>
<table class="table table-hover table-condensed">
    <thead>
    <tr>
        <th>Particular Name</th>
        <th>Qty</th>
        <th>Amount</th>
        <th>Commend</th>
        <th>Total</th>
        <th></th>
    </tr>
    </thead>
    <tbody id="particular_contents">
    <?php if(!empty($data['particular_item_selected'])){
        ?>
    <?php foreach ($data['particular_item_selected'] as $id => $item): ?>
        <?php if($item['patient_id']==@$_GET['patient_id'] && $item['admit_id']==@$_GET['admit_id']){ ?>
        <?php $item_id=$item['id']; ?>
        <tr>
            <td style="display:none">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'method'=>'post',
                    //'action' => Yii::app()->createUrl('appointment/EditMedicine?medicine_id='.$item_id.'&visit_id='.$visit_id),
                    'htmlOptions'=>array('class'=>'line_item_form'),
                ));
                ?>
                <?php echo $form->textField($data['VwItemTreatment'], "id", array('value' => @$item['id'], 'class' => 'input-small input-grid', 'id' => "id_$item_id", 'placeholder' => 'Price', 'maxlength' => 10)); ?>
                <?php $this->endWidget(); ?>
            </td>
            <td>
                <?php echo @$item['name']; ?><br/>
            </td>
            <td>
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'method'=>'post',
                    //'action' => Yii::app()->createUrl('appointment/EditMedicine?medicine_id='.$item_id.'&visit_id='.$visit_id),
                    'htmlOptions'=>array('class'=>'line_item_form'),
                ));
                ?>
                <?php echo $form->textField($data['VwItemTreatment'], "qty", array('value' => @$item['qty'], 'class' => 'input-small numeric input-grid', 'id' => "quantity_$item_id", 'placeholder' => 'Quantity', 'data-id' => "$item_id", 'maxlength' => 50,)); ?>
                <?php $this->endWidget(); ?>
            </td>
            <td>
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'method'=>'post',
                    //'action' => Yii::app()->createUrl('appointment/EditMedicine?medicine_id='.$item_id.'&visit_id='.$visit_id),
                    'htmlOptions'=>array('class'=>'line_item_form'),
                ));
                ?>
                <?php echo $form->textField($data['VwItemTreatment'], "price", array('value' => @$item['price'], 'class' => 'input-small numeric input-grid', 'id' => "price_$item_id", 'placeholder' => 'Price', 'data-id' => "$item_id", 'maxlength' => 50, )); ?>
                <?php $this->endWidget(); ?>
            </td>
            <td>
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'method'=>'post',
                    //'action' => Yii::app()->createUrl('appointment/EditMedicine?medicine_id='.$item_id.'&visit_id='.$visit_id),
                    'htmlOptions'=>array('class'=>'line_item_form'),
                ));
                ?>
                <?php echo $form->textField($data['VwItemTreatment'], "comment", array('value' => @$item['comment'], 'class' => 'input-small numeric input-grid', 'id' => "price_$item_id", 'placeholder' => 'Comment', 'data-id' => "$item_id", 'maxlength' => 50, )); ?>
                <?php $this->endWidget(); ?>
            </td>
            <td>
                <?php echo $item['price']*$item['qty']; ?><br/>
            </td>
            <td><?php
                echo TbHtml::linkButton('', array(
                    'color'=>TbHtml::BUTTON_COLOR_WARNING,
                    'size' => TbHtml::BUTTON_SIZE_MINI,
                    'icon' => 'ace-icon fa fa-eraser',
                    'url' => array('DeleteItem', 'particular_id' => $id,'admit_id'=>$data['admit_id'],'patient_id'=>$data['patient_id']),
                    //'label'=>'delete',
                    'class' => 'delete-item',
                    'title' =>  'Remove',
                ));
                ?>
            </td>
        </tr>
        <?php } ?>
    <?php endforeach; ?>
    <?php } ?>
    </tbody>
</table>