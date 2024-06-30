<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $rolesArray = explode('||', $role);

        $user = User::where('id', auth()->id())->first();

        foreach ($rolesArray as $roles) {
            if ($user->id == $roles) {
                return $next($request);
            }
        }
        foreach ($rolesArray as $roles) {
            if ($roles != 1) {
                $user = User::where('id', auth()->id())
                    ->where(function ($query) use ($rolesArray) {
                        foreach ($rolesArray as $role) {
                            $query->orWhereHas($role);
                        }
                    })
                    ->first();

                if($user) {
                    return $next($request);
                }
            }
        }
        return response()->json(['message' => 'you cant , you dont have the right permission'], Response::HTTP_OK);
    }
}
