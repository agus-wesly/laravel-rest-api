<?php

namespace App\Services\V1;

use App\Services\QueryClass;

class CustomerQuery extends QueryClass
{
    protected $safeQueries = [
        'id' => ['eq', 'lt', 'gt'],
        'postalCode' => ['eq', 'gt', 'lt'],
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['lk'],
        'state' => ['lk', 'eq'],
    ];

    protected $transform_column = [
        'postalCode' => 'postal_code',
    ];

    protected $transform_operator = [
        "eq" => "=",
        "gt" => ">",
        "lt" => "<",
        "lk" => "LIKE",
    ];
}
