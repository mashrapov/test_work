<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends ApiController
{
    public function register(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Ошибка валидации', $validator->errors());
        }

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $response['token'] = $user->createToken('Test')->accessToken;
        $response['name'] = $user->name;

        return $this->sendResponse($response, 'Пользователь создан успешно');
    }
}
