<?php

namespace App\UseCases\RepairTypeOption;

use App\Http\Requests\RepairTypeOption\RepairTypeOptionIndexRequest;
use App\Models\RepairTypeOption;

class RepairTypeOptionIndexAction
{
    public function __invoke(RepairTypeOptionIndexRequest $request)
    {
        $options = RepairTypeOption::orderBy('order')->orderBy('name')->get();
        
        return response()->json($options);
    }
}

