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
    public function data()
    {
        $model = new DashboardModel();
        $input = $this->getRequestInput($this->request);
        $total_sales = $model->total_sales($input['date_start'], $input['date_end']);
        $total_sales_last_month = $model->total_sales_last_month($input['date_start']);
        $total_income = $model->total_income($input['date_start'], $input['date_end']);
        $total_income_last_month = $model->total_income_last_month($input['date_start'], $input['date_end']);
        $sales_performance = $model->sales_performance($input['date_start']);

        $e_model = new EmployeeModel();
        $employee = $e_model->all();

        return $this
            ->getResponse(
                [
                    'message' => 'Data found',
                    'total_sales' => $total_sales,
                    'total_sales_last_month' => $total_sales_last_month,
                    'total_income' => $total_income,
                    'total_income_last_month' => $total_income_last_month,
                    'employee' => $employee,
                    'sales_performance' => $sales_performance,
                ]
            );
    }
}
