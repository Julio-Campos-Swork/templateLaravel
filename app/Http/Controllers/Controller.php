<?php

namespace App\Http\Controllers;
use App\Http\Helpers\ResponseHelpers;
use App\Http\Helpers\ErrorLogHelper;
abstract class Controller
{
    //
public function __construct(){

    $this->responseHelper = new ResponseHelpers();
    $this->errorlog = new ErrorLogHelper();
}

}
