<?php

namespace App\Http\Controllers;

use App\Models\BoosterPack;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class MainController extends Controller
{
    public function index(): View
    {
        return view('welcome');
    }

    public function posts(): JsonResponse
    {
        return response()->json(['posts' => Post::all()]);
    }

    public function boosterPacks(): JsonResponse
    {
        return response()->json(['boosterPacks' => BoosterPack::all()]);
    }

    public function login()
    {
        // TODO: task 1, аутентификация
    }

    public function logout()
    {
        // TODO: task 1, аутентификация
    }

    public function comment()
    {
        // TODO: task 2, комментирование
    }

    public function like_comment(int $comment_id)
    {
        // TODO: task 3, лайк комментария
    }

    public function like_post(int $post_id)
    {
        // TODO: task 3, лайк поста
    }

    public function add_money()
    {
        // TODO: task 4, пополнение баланса
    }

    public function get_post(int $post_id)
    {
        // TODO получения поста по id
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
