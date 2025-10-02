<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback = Feedback::active()->get();

        return response()->json($feedback,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
            'userid' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create feedback
        $feedback = Feedback::create([
            'userid' => $request->userid, 
            'rating' => $request->rating,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => 'success',
            'feedback' => $feedback
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'message' => 'Feedback not found'
                ], 404);
            }

            return response()->json($feedback, 200);

        } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Failed to fetch feedback',
                    'error' => $e->getMessage()
                ], 500);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
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
            // Find feedback by ID
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'message' => 'Feedback not found'
                ], 404);
            }

            // Update feedback fields
            $feedback->rating = $request->rating;
            $feedback->message = $request->message;
            $feedback->save();

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'message' => 'Feedback not found'
                ], 404);
            }

            $feedback->delete();

            return response()->json([
                'message' => 'Feedback deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
public function member($id)
{
    try {
        // 1. Get all feedbacks from MongoDB
        $allFeedbacks = Feedback::all();

        // 2. Filter feedbacks where userid matches the given ID
        $userId = (string)$id;
        $filteredFeedbacks = $allFeedbacks->filter(function ($feedback) use ($userId) {
            return (string)$feedback->userid === $userId;
        })->values(); // reindex the collection

        return response()->json([
            'message' => 'Feedbacks retrieved successfully',
            'data' => $filteredFeedbacks
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch feedbacks',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
