<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ValidateId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$params)
    {
        $table_name = $params[0];
        $column = $params[1];
        $value = $request->route($params[2]);
        $data = [
            'table' => $value
        ];
        $rules = [
            'table' => ['exists:' . $table_name . ',' . $column . ',deleted_at,NULL']
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $response = [
                'error' => "Data Not Found"
            ];
            return redirect('/')->with($response);
        }

        return $next($request);
    }
}
