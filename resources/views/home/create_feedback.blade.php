<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Review - Ceylon Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>
<body class="bg-gray-50 font-sans">

    @include('layouts.header');

    <section class="max-w-3xl mx-auto py-20 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Create a Review</h1>
        <p class="text-gray-600 mb-8 text-center">Share your experience with us. Your feedback helps us improve our services.</p>

        <form id="create-review-form" class="bg-white shadow-md rounded-lg p-8 space-y-6">
            <!-- Rating with Stars -->
            <div class="text-center">
                <label class="block text-gray-700 font-semibold mb-2">Rating</label>
                <div id="star-rating" class="flex justify-center space-x-2 cursor-pointer">
                    <span data-value="1" class="text-gray-300 text-3xl">★</span>
                    <span data-value="2" class="text-gray-300 text-3xl">★</span>
                    <span data-value="3" class="text-gray-300 text-3xl">★</span>
                    <span data-value="4" class="text-gray-300 text-3xl">★</span>
                    <span data-value="5" class="text-gray-300 text-3xl">★</span>
                </div>
                <input type="hidden" id="rating" name="rating" value="0">
            </div>

            <div>
                <label for="message" class="block text-gray-700 font-semibold mb-2">Your Review</label>
                <textarea id="message" name="message" rows="5" class="w-full border-gray-300 rounded-md p-2" placeholder="Write your review here..."></textarea>
            </div>

            <button type="submit" class="bg-[#1b5d38] hover:bg-[#154526] text-white px-6 py-2 rounded-lg shadow-md transition w-full">
                Submit Review
            </button>

            <p id="form-status" class="text-center text-sm text-green-600 hidden mt-2">Your review has been submitted!</p>
        </form>
    </section>

    <script>
        const stars = document.querySelectorAll('#star-rating span');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('mouseover', () => highlightStars(star.dataset.value));
            star.addEventListener('mouseout', () => highlightStars(ratingInput.value));
            star.addEventListener('click', () => {
                ratingInput.value = star.dataset.value;
                highlightStars(star.dataset.value);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                if (star.dataset.value <= rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        const form = document.getElementById('create-review-form');
        const statusText = document.getElementById('form-status');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const rating = document.getElementById('rating').value;
            const message = document.getElementById('message').value;

            if (rating === "0") {
                alert("Please select a rating");
                return;
            }

            try {
                const userid = {{ auth()->id() }};
                await axios.post('/api/feedback', { rating, message, userid }, {
                    headers: {
                        Authorization: `Bearer {{ session('auth_token') }}`,
                        'Content-Type': 'application/json'
                    }
                });

                // Create notification for successful review submission
                const newNotification = {
                    user_id: userid,
                    title: "Your Review Submitted",
                    content: "Your review has been successfully submitted.",
                    type: 'review',
                    ref: rating
                };
                await axios.post('/api/notification', newNotification, {
                    headers: {
                        Authorization: `Bearer {{ session('auth_token') }}`,
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    console.log('Notification created successfully');
                }).catch(err => {
                    console.error('Failed to create notification:', err.response?.data || err);
                });

                statusText.textContent = "Your review has been submitted!";
                statusText.classList.remove('hidden');
                form.reset();
                highlightStars(0); 
                window.location.href = "{{ route('aboutus') }}";
                
            } catch (err) {
                console.error('Error submitting review:', err);
                statusText.textContent = "Failed to submit review. Try again.";
                statusText.classList.remove('hidden');
                statusText.classList.add('text-red-600');
            }
        });
    </script>

    @include('layouts.footer');

</body>
</html>