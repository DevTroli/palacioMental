<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class SalvoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Request $request, Projeto $projeto)
    {
        $user = auth()->user();

        if ($projeto->salvos()->where('user_id', $user->id)->exists()) {
            $projeto->salvos()->detach($user->id);
        } else {
            $projeto->salvos()->attach($user->id);
        }

        return back();
    }
}
