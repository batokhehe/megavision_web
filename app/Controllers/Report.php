<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\EmployeeModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Report extends BaseController
{
    public function index()
    {
        $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');

        helper('jwt');
        $encodedToken = getJWTFromRequest($authenticationHeader);
        $decodedToken = decodeJWTFromRequest($encodedToken);


        $model = new ReportModel();
        $data['list']    = $model->order_history($decodedToken->employee_id);
        $result = $model->sales_performance($decodedToken->employee_id);
        $data['amount']    = $result->order_amount;
        $data['count']    = $result->order_count;

        $response = [
            'status'          => 200,
            'error'           => null,
            'message'           => 'Recent Order Data ' . count($data) . ' Found',
            'data'            => $data
        ];
        return $this->getResponse($response);
    }
}
