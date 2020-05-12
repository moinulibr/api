<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongsToUser extends Exception
{
	public function render(){
		return ['error' => 'Product is not belongs to user'];
	}
    
}
