{{-- Satu ulasan. $review: star, body, user->username, created_at --}}
@props(['review'])
<article class="mb-2.5 rounded-sm border border-line bg-deep p-3.5">
    <div class="flex items-center justify-between text-sm">
        <span class="font-bold">{{ $review->user->username ?? $review->user->name }}</span>
        <span class="text-soft">{{ $review->created_at?->format('d/m/Y') }}</span>
    </div>
    <p class="text-sm text-star">{{ str_repeat('★', $review->star) }}{{ str_repeat('☆', 5 - $review->star) }}</p>
    <p class="mt-1 text-sm text-muted">{{ $review->body }}</p>
</article>
