<?php

class ReportController extends Controller
{
    public $layout = '//layouts/column1';
    
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'RevenueTab',
                                    'itemExpiry','SaleItemSummary','Inventory','SaleInvoice'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionRevenueTab()
    {
        $this->render('_revenue_tab', array());
    }

    public function actionItemExpiry($filter = '1')
    {
        //$this->canViewReport();

        $grid_id = 'rpt-item-expiry-grid';
        $title = 'Item Expiry';

        $data = $this->commonData($grid_id,$title,null,'_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getItemExpiryHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getItemExpiryColumns();

        $data['data_provider'] = $data['report']->ItemExpiry($filter);

        $this->renderView($data);
    }

    public function actionSaleItemSummary()
    {
        //$this->canViewReport();

        $grid_id = 'rpt-sale-item-summary-grid';
        $title = 'Sale Item Summary';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleItemSummaryColumns();
        $data['data_provider'] = $data['report']->saleItemSummary();

        $this->renderView($data);
    }

    public function actionInventory($filter = 'all')
    {
        //$this->canViewReport();

        $grid_id = 'rpt-inventory-grid';
        $title = 'Inventory';

        $data = $this->commonData($grid_id,$title,'show','_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getInventoryHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getInventoryColumns();

        $data['data_provider'] = $data['report']->Inventory($filter);

        $this->renderView($data);

    }

    protected function renderView($data, $view_name='index')
    {
        if (Yii::app()->request->isAjaxRequest && !isset($_GET['ajax']) ) {
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            Yii::app()->clientScript->scriptMap['*.js'] = false;

            /*
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('partial/_grid', $data, true, false),
            ));
            */
            $this->renderPartial('partial/_grid', $data);
        } else {
            $this->render($view_name, $data);
        }
    }

    public function actionSaleInvoice()
    {

        /*if (!Yii::app()->user->checkAccess('invoice.index') || !Yii::app()->user->checkAccess('invoice.print') || !Yii::app()->user->checkAccess('invoice.delete') || !Yii::app()->user->checkAccess('invoice.update')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }*/

        $grid_id = 'rpt-sale-invoice-grid';
        $title = 'Sale Invoice';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleInvoiceColumns();
        $data['data_provider'] = $data['report']->saleInvoice();

        $this->renderView($data);
    }

    protected function commonData($grid_id,$title,$advance_search=null,$header_view='_header',$grid_view='_grid')
    {
        $report = new Report;

        $data['report'] = $report;
        $data['from_date'] = isset($_GET['Report']['from_date']) ? $_GET['Report']['from_date'] : date('d-m-Y');
        $data['to_date'] = isset($_GET['Report']['to_date']) ? $_GET['Report']['to_date'] : date('d-m-Y');
        $data['search_id'] = isset($_GET['Report']['search_id']) ? $_GET['Report']['search_id'] : '';
        $data['advance_search'] = $advance_search;
        $data['header_tab'] = '';

        $data['grid_id'] = $grid_id;
        $data['title'] = Yii::t('app', $title) . ' ' . Yii::t('app',
                'From') . ' ' . $data['from_date'] . '  ' . Yii::t('app', 'To') . ' ' . $data['to_date'];
        $data['header_view'] = $header_view;
        $data['grid_view'] = $grid_view;

        $data['report']->from_date = $data['from_date'];
        $data['report']->to_date = $data['to_date'];
        $data['report']->search_id = $data['search_id'];

        return $data;
    }
}
?>