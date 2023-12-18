<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ReportModel extends Model
{
    protected $table = 'v_recent_order';
    protected $allowedFields = [
        'id',
        'order_count',
        'order_amount',
    ];

    protected $columns = [
        'order_count',
        'order_amount',
    ];

    public function order_history($employee_id)
    {
        $builder = $this->db->table($this->table)
            ->where('employee_id', $employee_id)
            ->orderBy('order_date', 'DESC');

        $result   = $builder->limit(10)->get()->getResult();

        if (!$result)
            return [];

        return $result;
    }

    public function sales_performance($employee_id)
    {
        $builder = $this->db->table($this->table)->select('COUNT(employee_id) AS order_count, COALESCE(
            SUM(order_amount),
            0
        ) AS order_amount')
            ->where('YEARWEEK(order_date, 1) = YEARWEEK(CURDATE(), 1)')
            ->where('employee_id', $employee_id);

        $result   = $builder->get()->getRow();

        if (!$result)
            return 0;

        return  $result;
    }
}
