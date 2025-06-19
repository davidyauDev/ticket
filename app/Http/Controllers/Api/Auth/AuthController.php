<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'code' => 'AUTH_INVALID_CREDENTIALS',
                    'message' => 'Credenciales incorrectas',
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                    ],
                    'token' => $token,
                ],
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'code' => 'VALIDATION_ERROR',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error("Error en login", ['error' => $e]);

            return response()->json([
                'status' => 'error',
                'code' => 'INTERNAL_ERROR',
                'message' => 'Ocurrió un error inesperado. Intenta nuevamente más tarde.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Sesión cerrada correctamente'
            ], 200);
        } catch (\Throwable $e) {
            Log::error("Error en logout", ['error' => $e]);

            return response()->json([
                'status' => 'error',
                'code' => 'INTERNAL_ERROR',
                'message' => 'No se pudo cerrar la sesión. Intenta nuevamente.',
            ], 500);
        }
    }
}
