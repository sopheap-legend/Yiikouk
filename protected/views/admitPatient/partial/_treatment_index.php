<div class="row">
    <div class="col-sm-12" id="search_room">
        <?php
        $this->widget('bootstrap.widgets.TbNav', array(
                'type' => TbHtml::NAV_TYPE_LIST,
                'submenuHtmlOptions'=>array('class'=>'treatment-tab'),
                'encodeLabel' => false,
                'id'=>'sidebar-ipd-treatment',
                'items' => array(
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'General Information') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=general_info&admit_id='.$admit_id.'&patient_id='.$patient_id),
                        'active'=>$this->id .'/'. $this->action->id=='admitPatient/IpdTreatment?treat_mode=general_info',
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Vital') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=vital&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=Vital&getPartial=_vital'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),

                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Diagnosis') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=diagnosis&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=Diagnosis&getPartial=_diagnosis'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Medication') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=medication&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=IPDPrescription&getPartial=_ipd_prescription'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Complaint') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=complaint&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=Complaint&getPartial=_complaint'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Progress Note') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=complaint&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=ProgressNote&getPartial=_progress_note'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Intake Record') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=intake_record&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=IntakeRecord&getPartial=_intake_record'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Output Record') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=output_record&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=OutputRecord&getPartial=_output_record'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Nurse Progress Note') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=nurse_progess_note&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=NurseProgessNote&getPartial=_nurse_progess_note'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),

                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'IP Room Transfer') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=ip_room_transfer&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=IPRoomTransfer&getPartial=_ip_room_transfer'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Bed Side Procedure') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=sed_side_procedure&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=BedSideProcedure&getPartial=_bed_side_procedure'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Operation Theater') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=operation_theater&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=OperationTheater&getPartial=_operation_theater'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Patient History') . '</span>',
                        'icon'=>'',
                        'url'=>Yii::app()->urlManager->createUrl('admitPatient/IpdTreatment?treat_mode=patient_history&admit_id='.$admit_id.'&patient_id='.$patient_id.'&obj=PatientHistory&getPartial=_patient_history'),
                        'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=>'<span class="menu-text">' . Yii::t('menu', 'Discharge Summary') . '</span>', 'icon'=>'', 'url'=>"#", 'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                        //'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                )
            )
        );
        ?>
    </div>
</div>
