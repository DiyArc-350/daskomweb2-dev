<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\PraktikanLoginRequest;

class LoginPraktikanController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [ //ini gantii yahh
            // data that u wanna pass
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(PraktikanLoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
    
            $request->session()->regenerate();
            $user = Auth::guard('praktikan')->user(); // Get the authenticated user object$role = Role::firstOrCreate(
            $role = Role::firstOrCreate(['name' => 'PRAKTIKAN', 'guard_name' => 'praktikan']);
            $permissions = $role->permissions;
            $allPermissions = $role->permissions->pluck('name'); // Extract permissions
    
            $token = $user->createToken($role->name, [...$allPermissions])->plainTextToken; // Generate a new token

            $cookie = cookie('auth', $token, 60, null, null, true, true, false, 'Lax');

            return redirect()->intended(RouteServiceProvider::PRAKTIKAN)
                ->header('X-XSRF-TOKEN', csrf_token())
                ->header('Authorization', $token)
                ->cookie($cookie);
            
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::guard('praktikan')->user();

        $user->tokens()->delete();

        Auth::guard('praktikan')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('landing'));
    }
    
}
