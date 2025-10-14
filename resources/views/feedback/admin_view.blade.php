@extends('layouts.admin')

@section('title','View Feedback - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
    <h1 class="text-3xl font-bold text-[#1b5d38] mb-6 border-b pb-3">Feedback Details</h1>

    <div id="feedback-details" class="space-y-6">
        <p class="text-gray-500">Loading feedback details...</p>
    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <a href="{{ route('admin.feedback.index') }}" 
           class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-medium shadow-sm transition">
           ← Back
        </a>
        <button id="delete-btn" 
                class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium shadow-md transition">
            Delete Feedback
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const feedbackId = "{{ request()->route('id') }}"; 
    const feedbackContainer = document.getElementById('feedback-details');
    const deleteBtn = document.getElementById('delete-btn');

    async function fetchFeedbackWithUser() {
        try {
            // 1. Get feedback
            const feedbackRes = await axios.get(`/api/feedback/${feedbackId}`, {
                headers: { Authorization: `Bearer {{ session('auth_token') }}` }
            });

            const feedback = feedbackRes.data.data; // <- important

            // 2. Get user if available
            let user = { first_name: 'Anonymous', last_name: '', email: '', profile_photo_path: '', profile_photo_url: '' };
            if (feedback.userid) {
                try {
                    const userRes = await axios.get(`/api/users/${feedback.userid}`, {
                        headers: { Authorization: `Bearer {{ session('auth_token') }}` }
                    });
                    user = userRes.data.data || userRes.data;
                } catch (err) {
                    console.error('Failed to fetch user info:', err);
                }
            }

            // 3. Determine profile image
            let profileImage = '';
            if (user.profile_photo_path) {
                profileImage = `/storage/${user.profile_photo_path}`;
            } else if (user.profile_photo_url) {
                profileImage = user.profile_photo_url;
            } else {
                profileImage = "https://ui-avatars.com/api/?name=" + encodeURIComponent(user.first_name + " " + user.last_name);
            }

            // 4. Render details
            feedbackContainer.innerHTML = `
                <div class="flex items-center space-x-5 border-b pb-5">
                    <img src="${profileImage}" 
                         alt="Profile" 
                         class="w-20 h-20 rounded-full border shadow-sm object-cover"
                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(user.first_name + ' ' + user.last_name)}';">
                    <div>
                        <p class="text-xl font-semibold text-gray-900">${user.first_name} ${user.last_name}</p>
                        <p class="text-sm text-gray-500">${user.email}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-5">
                    <div class="bg-gray-50 p-4 rounded-xl border">
                        <h2 class="text-sm font-medium text-gray-600">Rating</h2>
                        <p class="mt-1 text-lg font-semibold text-yellow-600">
                            ${'★'.repeat(feedback.rating)}${'☆'.repeat(5 - feedback.rating)}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border">
                        <h2 class="text-sm font-medium text-gray-600">Submitted At</h2>
                        <p class="mt-1 text-gray-800">${new Date(feedback.created_at).toLocaleString()}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border">
                    <h2 class="text-sm font-medium text-gray-600">Review</h2>
                    <p class="mt-2 text-gray-900 leading-relaxed">${feedback.message}</p>
                </div>
            `;
        } catch (err) {
            console.error(err);
            feedbackContainer.innerHTML = `<p class="text-red-500">Failed to load feedback details.</p>`;
        }
    }

    fetchFeedbackWithUser();

    deleteBtn.addEventListener('click', function () {
        if (!confirm('Are you sure you want to delete this feedback?')) return;

        axios.delete(`/api/feedback/${feedbackId}`, {
            headers: { Authorization: `Bearer {{ session('auth_token') }}` }
        })
        .then(() => {
            alert('Feedback deleted successfully.');
            window.location.href = '/admin/feedback';
        })
        .catch(err => {
            console.error(err);
            alert('Failed to delete feedback.');
        });
    });
});
</script>
@endsection
