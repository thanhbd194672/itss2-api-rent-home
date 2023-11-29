<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {
        $user = $request->user();
        if ($user instanceof User) {
            return $next($request);
        } else {
            return $this->_response();
        }
    }

    protected function redirectTo($request): ?string
    {
        throw new HttpResponseException($this->_response());
    }

    protected function _response(): Response|Application|ResponseFactory
    {
        return response('Authorization', SymfonyResponse::HTTP_UNAUTHORIZED);
    }
}
