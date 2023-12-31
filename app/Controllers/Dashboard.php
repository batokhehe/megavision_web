<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use App\Models\EmployeeModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new DashboardModel();
        $data    = $model->getAll($this->request);

        $response = [
            'status'          => 200,
            'error'           => null,
            'message'           => 'Recent Order Data ' . count($data) . ' Found',
            'data'            => $data['list'],
            'recordsTotal'    => count($data['list']),
            'recordsFiltered' => $data['rows_count'],
        ];
        return $this->getResponse($response);
    }

    public function data()
    {
        $model = new DashboardModel();
        $input = $this->getRequestInput($this->request);
        $total_sales = $model->total_sales($input['date_start'], $input['date_end']);
        $total_sales_last_month = $model->total_sales_last_month($input['date_start']);
        $total_income = $model->total_income($input['date_start'], $input['date_end']);
        $total_income_last_month = $model->total_income_last_month($input['date_start'], $input['date_end']);
        $sales_performance = $model->sales_performance($input['date_start']);

        $total_sales_percentage = $total_sales - $total_sales_last_month;
        $total_income_percentage = $total_income - $total_income_last_month;

        $e_model = new EmployeeModel();
        $employee = $e_model->all();

        return $this
            ->getResponse(
                [
                    'message' => 'Data found',
                    'total_sales' => $total_sales,
                    'total_sales_last_month' => $total_sales_last_month,
                    'total_sales_percentage' => $total_sales_percentage,
                    'total_income' => $total_income,
                    'total_income_last_month' => $total_income_last_month,
                    'total_income_percentage' => $total_income_percentage,
                    'employee' => $employee,
                    'sales_performance' => $sales_performance,
                ]
            );
    }
}
