@extends('layouts.member')

@section('title','Edit Feedback - Member Dashboard')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
    <h1 class="text-3xl font-bold text-[#1b5d38] mb-6 border-b pb-3">Edit Feedback</h1>

    <div id="feedback-form-container" class="space-y-6">
        <p class="text-gray-500">Loading feedback...</p>
    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <a href="{{ route('feedback.index',['id'=>auth()->id()]) }}" 
           class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-medium shadow-sm transition">
           ← Back
        </a>
        <button id="update-btn" 
                class="px-5 py-2.5 bg-[#1b5d38] hover:bg-[#154a2c] text-white rounded-xl font-medium shadow-md transition">
            Update Feedback
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const feedbackId = "{{ $id }}";  // use the passed ID
    const formContainer = document.getElementById('feedback-form-container');
    const updateBtn = document.getElementById('update-btn');

    let feedbackData = {};

    async function fetchFeedback() {
        try {
            const res = await axios.get(`/api/feedback/${feedbackId}`);
            feedbackData = res.data;

            formContainer.innerHTML = `
                <div class="bg-gray-50 p-6 rounded-xl border space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating (1-5)</label>
                        <input type="number" id="feedback-rating" min="1" max="5" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1b5d38]"
                               value="${feedbackData.rating}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Review Message</label>
                        <textarea id="feedback-message" rows="5" 
                                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1b5d38]">${feedbackData.message}</textarea>
                    </div>
                </div>
            `;
        } catch (err) {
            console.error(err);
            formContainer.innerHTML = `<p class="text-red-500">Failed to load feedback.</p>`;
        }
    }

    fetchFeedback();

    updateBtn.addEventListener('click', async function () {
        const rating = document.getElementById('feedback-rating').value;
        const message = document.getElementById('feedback-message').value;

        if (!rating || rating < 1 || rating > 5) {
            alert('Rating must be between 1 and 5.');
            return;
        }

        if (!message.trim()) {
            alert('Message cannot be empty.');
            return;
        }

        try {
            await axios.put(`/api/feedback/${feedbackId}`, {
                rating: rating,
                message: message
            });

            alert('Feedback updated successfully.');
            window.location.href = '{{ route("feedback.index",["id"=>auth()->id()]) }}';
        } catch (err) {
            console.error(err);
            alert('Failed to update feedback.');
        }
    });
});
</script>
@endsection
