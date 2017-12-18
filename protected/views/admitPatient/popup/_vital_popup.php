<strong style="color:red"><?php //echo $form->error($vital,'general_error'); ?></strong>
<strong style="color:red"><?php //echo $form->errorSummary($model->general_error); ?></strong>
<?php //echo $form->textFieldControlGroup($vital,'general_error',array('span'=>5,'style' => 'display:none','label'=>false)); ?>
<?php //$model_popup->admit_id= @$admit_id?>
<?php //echo $form->textFieldControlGroup($vital,'admit_id',array('span'=>5,)); ?>
<?php //echo $form->textFieldControlGroup($model_popup,'admit_id',array('span'=>5,'style' => 'display:none','label'=>false)); ?>
<?php echo $form->textFieldControlGroup($model_popup,'pulse_rate',array('span'=>5,'append' => 'min','placeholder'=>'Pulse Rate')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'blood_pressure',array('span'=>5,'append' => 'mm of Hg','placeholder'=>'Blood Pressure')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'temperature',array('span'=>5,'append' => 'C','placeholder'=>'Temperature')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'respiration',array('span'=>5,'append' => 'min','placeholder'=>'Respiration')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'height',array('span'=>5,'append' => 'Cm','placeholder'=>'Height')); ?>
<?php echo $form->textFieldControlGroup($model_popup,'weight',array('span'=>5,'append' => 'Kg','placeholder'=>'Weight')); ?>
