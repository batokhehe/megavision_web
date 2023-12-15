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
        $builder = $this->db->table($this->table)->select('SUM(order_amount) AS order_amount')
            ->where('order_date >=', $date_start)
            ->where('order_date <=', $date_end);

        $result   = $builder->get()->getRow();

        if (!$result)
            return 0;

        return $result->order_amount;
    }

    public function total_income_last_month($date)
    {
        $builder = $this->db->table($this->table)->select('SUM(order_amount) AS order_amount')
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
}
