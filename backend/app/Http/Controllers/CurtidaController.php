<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class CurtidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Request $request, Projeto $projeto)
    {
        $user = auth()->user();

        if ($projeto->curtidas()->where('user_id', $user->id)->exists()) {
            $projeto->curtidas()->detach($user->id);
        } else {
            $projeto->curtidas()->attach($user->id);
        }

        return back();
    }
}
