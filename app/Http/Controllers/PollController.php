<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::where('status', 'active')->where('expires_at', '>', now())->get();
        return response()->json($polls);
    }

    public function vote()
    {
    }

    public function store()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
