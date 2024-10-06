<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function user(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            return response()->json($user, 200);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $message = "User not found: {{ $error }}";
            return response()->json([
                'status' => false,
                'message' => $message
            ], 400);
        }

    }

    // Rota para exibir um usuario especifico
    public function show($id): JsonResponse
    {
        try {
            $user = User::findorFail($id);
            return response()->json([
                'status' => true,
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 400);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $email = $request->email;
        $password = $request->password;

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorreta'
            ], 404);
        }

        Auth::user();
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            // Invalida o token da sessão atual
            Auth::guard('web')->logout();
            // Invalida o cookie de sessão
            $request->session()->invalidate();
            // Regenera o token CSRF
            $request->session()->regenerateToken();
            return response()->json(['status' => true, 'message' => 'Logout realizado com sucesso.']);
        }

        return response()->json(['status' => false, 'message' => 'User not found']);

    }

    public function store(UserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            User::create($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User created',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'User not created'
            ], 400);
        }
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {

        DB::beginTransaction();

        try {
            $data = $request->all();
            if ($request->has('password')) {
                $data['password'] = bcrypt($data['password']);
            }
            $user->update($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User updated',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'User not updated'
            ], 400);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'User deleted',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 400);
        }
    }
}
