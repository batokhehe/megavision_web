<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class DashboardModel extends Model
{
    protected $table = 'v_recent_order';
    protected $allowedFields = [
        'id',
        'employee_id',
        'employee_name',
        'employee_email',
        'employee_phone',
        'office_name',
        'order_date',
        'order_item',
        'order_amount',
        'client_id',
        'client_name',
        'client_email',
        'client_phone',
        'total_sales',
        'total_sales_last_month',
        'total_income',
        'total_income_last_month',
    ];

    protected $columns = [
        'client_name',
        'order_date',
        'order_amount',
        'client_phone',
        'employee_name',
        'office_name',
    ];

    public function total_sales($date_start, $date_end)
    {
        $builder = $this->db->table($this->table)
            ->where('order_date >=', $date_start)
            ->where('order_date <=', $date_end);

        $result   = $builder->countAllResults();

        if (!$result)
            return 0;

        return $result;
    }

    public function total_sales_last_month($date)
    {
        $builder = $this->db->table($this->table)
            ->where("month(order_date) = month('" . $date . "') - 1")
            ->where("year(order_date) = year('" . $date . "')");

        $result   = $builder->countAllResults();

        if (!$result)
            return 0;

        return  $result;
    }

    public function total_income($date_start, $date_end)
    {
        $builder = $this->db->table($this->table)->select('COALESCE(SUM(order_amount), 0) AS order_amount')
            ->where('order_date >=', $date_start)
            ->where('order_date <=', $date_end);

        $result   = $builder->get()->getRow();

        if (!$result)
            return 0;

        return $result->order_amount;
    }

    public function total_income_last_month($date)
    {
        $builder = $this->db->table($this->table)->select('COALESCE(SUM(order_amount), 0) AS order_amount')
            ->where("month(order_date) = month('" . $date . "') - 1")
            ->where("year(order_date) = year('" . $date . "')");

        $result   = $builder->get()->getRow();

        if (!$result)
            return 0;

        return $result->order_amount;
    }

    public function sales_performance($date_start)
    {
        $query = 'SELECT
                `megavision`.`employees`.`id` AS `id`,
                `megavision`.`employees`.`name` AS `name`';

        for ($i = 0; $i < 5; $i++) {
            $query = $query . ", COALESCE(
                (SELECT COUNT(`megavision`.`orders`.`id`)
                    FROM
                        `megavision`.`orders`
                    WHERE
                        `megavision`.`orders`.`employee_id` = `megavision`.`employees`.`id`
                        AND month(`orders`.`order_date`) = month('$date_start') - $i and year(`orders`.`order_date`) = year('$date_start')
                ), 0) AS `count_$i`";
        }

        $query = $query . ' FROM `megavision`.`employees` ORDER BY id ASC';

        $builder = $this->db->query($query);

        $result   = $builder->getResult();

        if (!$result)
            return 0;

        return $result;
    }

    public function getAll($request)
    {
        // return $this->db->table($this->table)->like('client_name', $query)
        //     ->orLike('order_date', $query)
        //     ->orLike('client_phone', $query)
        //     ->orLike('employee_name', $query)
        //     ->orLike('office_name', $query)
        //     ->orderBy('order_date', 'DESC')
        //     ->get($limit, $page)->getResult();

        /* PREPARE DATA */
        $sql = $this->db->table($this->table);
        $db_result = $sql->get();
        $db_query = $sql->getCompiledSelect();
        $db_columns = $this->columns;
        $db_rows_count = $db_result->getNumRows();

        $dt_column_count = 0;
        foreach ($this->columns as $key => $column) {
            $dt_column_count++;
        }

        $dt_search = $request->getGet('search')['value'];

        /* SEARCH */
        $where = '';
        if ($dt_search != '') {
            $iterator = 0;
            foreach ($this->columns as $key => $column) {
                $where .= 'LOWER(' . $this->table . '.' . $column . ') LIKE \'%' . $dt_search . '%\' ';
                if ($iterator < $dt_column_count-1) {
                    $where .= ' OR ';
                }
                $iterator++;
            }
        }



        if ($where != '') {
            if(strpos($db_query, 'WHERE') !== false){
                $db_query .= " AND " . $where;
            }else{
                $db_query .= " WHERE " . $where;
            }

            $db_rows_count = $this->db->query($db_query)->getNumRows();
        }

        /* SORTING */
        $dtColumns = [];
        if($request->getGet('order')){
            foreach ($request->getGet('columns') as $column){
                if($column['orderable'] !== "false"){
                    $dtColumns[] = $column['data'];
                }else{
                    $dtColumns[] = null;
                }
            }
            $db_query .= " ORDER BY {$dtColumns[$request->getGet('order')[0]['column']]} {$request->getGet('order')[0]['dir']}";
        }

        /* LIMIT */
        $start  = $request->getGet('start');
        $length = $request->getGet('length');
        $db_query .= " LIMIT {$length} OFFSET {$start}";

        $return['list'] = $this->db->query($db_query)->getResult();
        $return['columns'] = $db_columns;
        $return['columns_count'] = $dtColumns;
        $return['rows_count'] = $db_rows_count;
        $return['draw'] = $request->getGet('draw');
        $return['start'] = $request->getGet('start');

        return $return;
    }

    public function getAllCounter()
    {
        return $this->db->table($this->table)->countAllResults();
    }
}
