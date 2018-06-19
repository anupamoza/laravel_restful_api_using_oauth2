<?php

namespace App\Http\Repository;

use App\Http\Repository\Repository;
use App\User;
use Auth;

class ClientCredentialsGrantRepository extends Repository 
{
	public function __construct(User $userModel)
    {
        $this->userModel = $userModel;        
    }
	
}