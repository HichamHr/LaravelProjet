<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $etudiant
     * @param null $prof
     * @param $admin
     * @return mixed
     * @internal param array $roles
     */
    public function handle($request, Closure $next, $etudiant=null , $prof=null , $admin=null)
    {
        $roles = array();
        // Get the required roles from the route
        //$roles = $this->getRequiredRoleForRoute($_roles);
        if($etudiant != null) $roles[] = $etudiant;
        if($prof != null) $roles[] = $prof;
        if($admin != null) $roles[] = $admin;
        //echo json_encode($roles);
        // Check if a role is required for the route, and
        // if so, ensure that the user has that role.
        //echo json_encode($request);
        if($request->user()->hasRole($roles) || !$roles)
        {
            return $next($request);
        }
        return response([
            'error' => [
                'code' => 'INSUFFICIENT_ROLE',
                'description' => 'You are not authorized to access this resource.'
            ]
        ], 401);
    }

    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}
