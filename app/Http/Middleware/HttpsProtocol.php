<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsProtocol
{
    public function handle ( Request $request, Closure $next )
    {
        /*
         * HTTPS REDIRECT SETTING
         */
        if (env('APP_REDIRECT_HTTPS') == 'true') {
            if ( !$request->secure() && !$this->is_https() ) {
                if( $_SERVER ['REQUEST_METHOD'] == "POST") {
                    abort(403);
                }
                return redirect()->secure( $request->getRequestUri() );
            }
            app()['request']->server->set( 'HTTPS', true );
        }
        return $next( $request );
    }

    private function is_https ()
    {
        if ( !empty( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) !== 'off') {
            return true;
        } elseif (isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        } elseif ( !empty( $_SERVER['HTTP_FRONT_END_HTTPS'] ) && strtolower( $_SERVER['HTTP_FRONT_END_HTTPS'] ) !== 'off') {
            return true;
        }

        return false;
    }
}
