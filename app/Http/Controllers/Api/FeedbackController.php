<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display all feedbacks.
     */
    public function index()
    {
        try {
            $feedbacks = Feedback::all(); // from MongoDB

            // Fetch related users from MySQL
            $userIds = $feedbacks->pluck('userid')->filter()->unique();
            $users = User::whereIn('id', $userIds)->get()->keyBy('id');

            // Attach user info to feedbacks
            $feedbacks = $feedbacks->map(function ($fb) use ($users) {
                $fb->user = $users[$fb->userid] ?? null;
                return $fb;
            });

            return response()->json([
                'status' => 'success',
                'data' => $feedbacks
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch feedbacks',
                'error' => $e->getMessage()
            ], 500);
        }
    }


        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'message' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                $feedback = Feedback::create([
                    'userid' => Auth::id(),  // use authenticated user
                    'rating' => $request->rating,
                    'message' => $request->message,
                ]);

                return response()->json([
                    'status' => 'success',
                    'data' => $feedback
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create feedback',
                    'error' => $e->getMessage()
                ], 500);
            }
        }


    public function show(string $id)
    {
        try {
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $feedback
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found'
                ], 404);
            }

            // Only allow owner to update
            if ($feedback->userid != Auth::id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            $feedback->update([
                'rating' => $request->rating,
                'message' => $request->message
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback updated successfully',
                'data' => $feedback
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found'
                ], 404);
            }

            $feedback->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function member($id)
    {
        try {
            $feedbacks = Feedback::where('userid', (string)$id)->get();

            return response()->json([
                'status' => 'success',
                'data' => $feedbacks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch member feedbacks',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
