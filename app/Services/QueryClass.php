<?php

namespace App\Services;

use Illuminate\Http\Request;

class QueryClass
{
    protected $safeQueries = [];

    protected $transform_column = [];

    protected $transform_operator = [];

    public function getQuery(Request $request)
    {
        $queries = [];

        foreach ($this->safeQueries as $field => $operators) {
            $query = $request->query($field);

            if (!isset($query)) {
                continue;
            }


            $column = $this->transform_column[$field] ?? $field;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $queries[] = [$column, $this->transform_operator[$operator], $query[$operator]];
                }
            }
        }

        return $queries;
    }
}
