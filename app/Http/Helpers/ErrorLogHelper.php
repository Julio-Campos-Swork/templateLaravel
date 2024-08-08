<?php

namespace App\Http\Helpers;

use App\Models\ErrorLog;
class ErrorLogHelper
{
    public function recordError($error_message)
    {

            $newError = new ErrorLog;
            $newError->id_user = auth()->user()->id || 1;
            $newError->error_message = $error_message;
            $newError->save();

    }
}
