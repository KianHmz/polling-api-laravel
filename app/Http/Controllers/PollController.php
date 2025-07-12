<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::where('status', 'active')
            ->where('expires_at', '>', now())
            ->get();

        return response()->json($polls);
    }

    public function vote(Request $request, $pollId)
    {
        try {
            $user = Auth::user();
            $poll = Poll::find($pollId);

            # check if poll exists
            if (!$poll) {
                return response()->json([
                    'message' => 'Poll not found!'
                ], 404);
            }

            if ($poll->status !== 'active' || $poll->expires_at < now()) {
                return response()->json([
                    'message' => 'Poll is inactive!'
                ], 403);
            }

            $request->validate([
                'choice' => 'required|string',
            ]);

            # check if user has alr voted
            $existingVote = Vote::where('poll_id', $pollId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingVote) {
                return response()->json([
                    'message' => 'You have already voted!'
                ], 403);
            }

            # submit vote
            $found = false;
            $choices = $poll->choices;
            foreach ($choices as &$choice) {
                if ($choice['choice_text'] === $request->choice) {
                    $choice['votes_count']++;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                return response()->json([
                    'message' => 'Selected option is invalid!'
                ], 404);
            }

            $poll->choices = $choices;
            $poll->save();

            Vote::create([
                'poll_id' => $poll->_id,
                'user_id' => $user->_id,
                'choice_selected' => $request->choice,
            ]);

            return response()->json([
                'message' => 'Vote submitted successfully!'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error!',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server error!',
                'error' => $e->getMessage()
            ], 500);
        }
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
