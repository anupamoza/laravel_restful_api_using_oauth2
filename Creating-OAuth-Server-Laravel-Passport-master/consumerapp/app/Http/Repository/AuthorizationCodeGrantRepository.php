<?php

namespace App\Http\Repository;

use App\Http\Repository\Repository;
use App\User;
use Auth;

class AuthorizationCodeGrantRepository extends Repository 
{
	public function __construct(User $userModel)
    {
        $this->userModel = $userModel;        
    }
	
}