<?php

namespace App\Http\Helpers;

class ResponseHelpers
{
    // public function __construct()
    // {
    //     //
    //     $this->mesanjeOk = "Operacija uspješna";
    // }
    /**
    * success response method.
    * @param $data Data will be returned
    * @param $message Message will be returned
    * @return \Illuminate\Http\Response
    */
   public function successResponse($message, $data = [] )
   {
       $response = [
           'status' => true,
           'message' => $message,
           'data'    => $data,
       ];

       return response()->json($response, 200);
   }

   /**
    * return error response.
    *
    * @param $errorMessages Erros will be returned
    * @param $message Message will be returned
    * @return \Illuminate\Http\Response
    */
   public function errorResponse($errorMessage, $error)
   {
       $response = [
           'status' => false,
           'message' => $errorMessage,
           'error' => $error,
       ];

       if(!empty($errorMessages)){
           $response['data'] = $errorMessages;
       }

       return response()->json($response, 200);
   }
}
