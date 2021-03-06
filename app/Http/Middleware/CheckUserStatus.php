<?php

namespace App\Http\Middleware;

use App\School;
use App\Schoolyear;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\User;
use Illuminate\Support\Facades\Redirect;

class CheckUserStatus
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */


  // code for billing after authenitification
  public function handle($request, Closure $next)
  {
    if (Auth::check()) {
      $util = User::find(Auth::id());
      if ($util->status == false) {
        $request->session()->put('checkpoint', 'billing is on going');

        return redirect()->route('checkpoint');
      } else {
        session()->forget('checkpoint');

        $utilConnect = User::find(Auth::id());
        if ($utilConnect->state == false); {
          $utilConnect->state = true;
          $utilConnect->save();
        }
      }
    }
    return $next($request);
  }
}
