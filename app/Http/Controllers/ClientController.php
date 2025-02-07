<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
// Method for creating a new user - Метод для створення нового користувача
    public function store(Request $request)
    {
        // Data validation - Валідація даних
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:8',
        ]);

    // Check if validation fails - Перевірка, чи не пройшла валідація
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Getting validated data - Отримання валідованих даних
        $validated = $validator->validated();

        // Creating a new user - Створення нового користувача
        $client = Client::create([
            'client_name' => $validated['client_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hashing the password

        ]);


        // Returning the answer - Повертаємо відповідь
        return response()->json([
            'message' => 'User created successfully',
            'client' => $client,
        ], 201);
    }


}


