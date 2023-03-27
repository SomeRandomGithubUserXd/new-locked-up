<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Reviews\ReviewRequest;
use App\Http\Resources\Reviews\ReviewResource;
use App\Models\Quests\Quest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('Reviews/Index', [
            'reviews' => ReviewResource::collection(Review::paginate(15))
        ]);
    }

    public function create()
    {
        return inertia('Reviews/Create', [
            'questList' => Quest::query()
                ->where('name_ru', '!=', '')
                ->select(['id', 'name_ru'])
                ->orderBy('name_ru')
                ->get(),
        ]);
    }

    public function store(ReviewRequest $request)
    {
        Review::create($request->validated());
        return redirect()->route('reviews.index');
    }

    public function show(Review $review)
    {
        return inertia('Reviews/Show', [
            'review' => ReviewResource::singleItem($review),
            'questList' => Quest::query()
                ->where('name_ru', '!=', '')
                ->select(['id', 'name_ru'])
                ->orderBy('name_ru')
                ->get(),
        ]);
    }

    public function update(Review $review, ReviewRequest $request)
    {
        $review->update($request->validated());
        return redirect()->route('reviews.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Review::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
