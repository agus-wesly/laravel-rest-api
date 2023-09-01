<?php

namespace App\Services\V1;

use App\Services\QueryClass;
use Illuminate\Http\Request;

class InvoiceQuery extends QueryClass
{
    protected $safeQueries = [
        "id" => ["eq", "gt", "lt"],
        "customerId" => ["eq", "gt", "lt"],
        "amount" => ["eq", "gt", "lt"],
        "status" => ["eq"],
    ];

    protected $transform_column = [
        'customerId' => 'customer_id',
    ];

    protected $transform_operator = [
        "eq" => "=",
        "gt" => ">",
        "lt" => "<",

    ];
}
