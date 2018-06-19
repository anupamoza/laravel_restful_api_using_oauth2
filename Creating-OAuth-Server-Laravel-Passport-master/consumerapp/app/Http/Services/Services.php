<?php

namespace App\Http\Services;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Services extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}