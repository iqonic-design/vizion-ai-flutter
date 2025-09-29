<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Trait\AuthTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class AuthenticatedSessionController extends Controller
{
    use AuthTrait;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->with('subscriptionPackage')->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User with this email does not exist.',
            ])->onlyInput('email');
        }

        if ($user->email_verified_at === null) {
            return back()->withErrors([
                'email' => 'Your email is not verified. Please verify your email address.',
            ])->onlyInput('email');
        }
       
            $islogin = $this->loginTrait($request);
            
            if (isset($islogin['error'])) {
        
                return back()->withErrors([
                    'email' => $islogin['error']
                ])->onlyInput('email');
            } elseif ($islogin['status'] == 406) {
    
                return back()->withErrors([
                    'email' => $islogin['message']
                ])->onlyInput('email');
    
            } else {
    
              $request->session()->regenerate();
        
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                Artisan::call('config:cache');
                Artisan::call('route:clear');
        
                return redirect()->intended(RouteServiceProvider::HOME);
            }

            if($isLogin=='user'){

                return back()->withErrors([
                    'email' => "User Don't have permission to login ",
                ])->onlyInput('email');

            }
    
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
