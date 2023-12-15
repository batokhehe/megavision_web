<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class EmployeeModel extends Model
{
    protected $table = 'employees';
    protected $allowedFields = [
        'id',
        'name',
    ];
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    public function all()
    {
        $result = $this
            ->orderBy('id', 'asc')
            ->findAll();

        if (!$result)
            throw new Exception('Data not found');

        $temp = [];
        foreach ($result as $key => $value) {
            array_push($temp, $value['name']);
        }

        return $temp;
    }
}
