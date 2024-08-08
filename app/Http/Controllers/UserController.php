<?php

namespace App\Http\Controllers;

use App\Models\LoginRegister;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    //

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:30|unique:users',
            'password' => 'required|string|min:6',

        ];
        try {
            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) {
                return $this->responseHelper->errorResponse('El email ya esta registrado, intenté de nuevo', $validator->errors()->all());

            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'id_user_type' => $request->id_user_type,
                'password' => \Hash::make($request->password),
            ]);
            return $this->responseHelper->successResponse('Usuario creado con éxito.', $user);

        } catch (\Exception $e) {
            $this->errorlog->recordError($e->getMessage());
            return $this->responseHelper->errorResponse('Error en el servidor, contacta a soporte', $e->getMessage());

        }

    }


    public function login(Request $request)
    {
        $rules = [
            'identifier' => 'required|string',
            'password' => 'required|string'
        ];
        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return $this->responseHelper->errorResponse('Datos incompletos', $validator->errors()->all());
        }
        try {
            $credentials = [
                ['email' => $request->identifier, 'password' => $request->password],
                ['name' => $request->identifier, 'password' => $request->password]
            ];

            foreach ($credentials as $attempt) {
                if (Auth::attempt($attempt)) {
                    $user = Auth::user();
                    $token = $user->createToken('MyToken')->plainTextToken;
                    $this->setLoginRegister($request, $token, $user->id);
                    $data = ['user' => $user, 'token' => $token];

                    return $this->responseHelper->successResponse('Se inició sesión correctamente', $data);
                }
            }

            return $this->responseHelper->errorResponse('Credenciales inválidas, favor de intentarlo de nuevo.', 'Invalid data');


        } catch (\Exception $e) {
            $this->errorlog->recordError($e->getMessage());
         return $this->responseHelper->errorResponse('Error en el servidor, contacta a soporte', $e->getMessage());

        }

    }

    public function setLoginRegister($request, $token, $userID)
    {
        try {
            //code...
            $newLogin = new LoginRegister();
            $newLogin->id_user = $userID ;
            $newLogin->key = $token ;
            $newLogin->ip = $request->ip_value ;
            $newLogin->city = $request->city ;
            $newLogin->country = $request->country ;
            $newLogin->save();
        } catch (\Exception $e) {
            $this->errorlog->recordError($e->getMessage());
         return $this->responseHelper->errorResponse('Error en el servidor, contacta a soporte', $e->getMessage());

        }
    }

    public function logout(Request $request)
    {
        try {
            //code...
            $user = User::where('email', $request->email)->first();
            $user->tokens()->where('tokenable_id', $user->id)->delete();
            return $this->responseHelper->successResponse('Se cerró sesión correctamente');

        } catch (\Exception $e) {
            $this->errorlog->recordError($e->getMessage());
            return $this->responseHelper->errorResponse('Error en el servidor, contacta a soporte', $e->getMessage());

        }
    }

    public function getUserList()
    {
        try {
            //code...
            $users = User::all();
            $user_type = UserType::all();
            $data = [
                'users' => $users,
                'user_type'=> $user_type
            ];
            return $this->responseHelper->successResponse('Usuarios obtenidos', $data);

        } catch (\Exception $e) {
            $this->errorLog->recordError($e->getMessage());
            return $this->responseHelper->errorResponse('Error en el servidor, contacta a soporte', $e->getMessage());

        }
    }

    public function updateUserInfo(Request $request)
    {
        try {
            //code...
            $user = User::where('id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->id_user_type = $request->id_user_type;
            $user->status = $request->status;
            $user->save();
            return $this->responseHelper->successResponse('Usuario actualizado', $user);

        } catch (\Exception $e) {
            $this->errorLog->recordError($e->getMessage());
            return $this->responseHelper->errorResponse('Error en el servidor, contacta a soporte', $e->getMessage());

        }

    }
    public function updateUserPassword(Request $request)
    {
        $id_user = $request->id_user;
        $newPassword = $request->newPassword;
        try {
            $user = User::find($id_user);
            $user->password = \Hash::make($newPassword);
            $user->save();

            return $this->responseHelper->successResponse('Usuario actualizado', $user);


        } catch (\Exception $e) {
            $this->errorLog->recordError($e->getMessage());
            return $this->responseHelper->errorResponse('Error en el servidor, contacta a soporte', $e->getMessage());

        }
    }

}
