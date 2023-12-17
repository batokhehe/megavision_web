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
        $limit = 0;
        $page  = 0;
        $query = '';

        if ($this->request->getGet('limit') || $this->request->getGet('page')) {
            $limit = $this->request->getGet('limit');
            $page  = $limit * $this->request->getGet('page');
        }
        if ($this->request->getGet('query')) {
            $query = $this->request->getGet('query');
        }

        if ($this->request->getGet('length') || $this->request->getGet('start')) {
            $limit = $this->request->getGet('length');
            $page  = $this->request->getGet('start');
        }
        if ($this->request->getGet('search')) {
            $query = $this->request->getGet('search')['value'];
        }

        $model = new DashboardModel();
        $data    = $model->getAll($this->request, $limit, $page, $query);
        $counter = $model->getAllCounter();

        $response = [
            'status'          => 200,
            'error'           => null,
            'message'        => 'Recent Order Data ' . count($data) . ' Found',
            'data'            => $data,
            'recordsTotal'    => $counter,
            'recordsFiltered' => $counter,
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
