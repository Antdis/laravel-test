<?php

namespace App\Http\Controllers;

use App\Models\BoosterPack;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(): View
    {
        return view('welcome');
    }

    public function boosterPacks(): JsonResponse
    {
        return response()->json(['boosterPacks' => BoosterPack::all()]);
    }

    public function login(Request $request): Response
    {
        $validated = $request->validate([
            'login'    => ['required', 'email:strict'],
            'password' => ['required'],
        ]);

        $user = User::query()
            ->where('email', $validated['login'])
            ->where('password', $validated['password'])
            ->first();

        if (!$user) {
            return response('', 400);
        }

        Auth::login($user);

        return response('');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function addMoney(Request $request): Response
    {
        $request->validate(['sum' => ['required', 'numeric', 'min:1']]);
        $sum = (float) $request->input('sum');

        $user = auth()->user();

        User::where('id', $user->id)->update([
            'wallet_balance'        => DB::raw("wallet_balance + $sum"),
            'wallet_total_refilled' => DB::raw("wallet_total_refilled + $sum"),
        ]);

        return response('');
    }

    public function buy_boosterpack()
    {
        // Check user is authorize
//        if (!User_model::is_logged()) {
//            return $this->response_error(System\Libraries\Core::RESPONSE_GENERIC_NEED_AUTH);
//        }

        // TODO: task 5, покупка и открытие бустерпака
    }


    /**
     * @return object|string|void
     */
    public function get_boosterpack_info(int $bootserpack_info)
    {
        // Check user is authorize
//        if (!User_model::is_logged()) {
//            return $this->response_error(System\Libraries\Core::RESPONSE_GENERIC_NEED_AUTH);
//        }


        //TODO получить содержимое бустерпака
    }
}
