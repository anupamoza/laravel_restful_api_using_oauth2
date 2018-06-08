<?php

namespace App\Http\Repository;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Repository extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}