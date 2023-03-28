<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\News\NewsResource;
use App\Models\News\News;
use Illuminate\Http\RedirectResponse;

class NewsController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('News/Index', [
            'news' => NewsResource::collection(News::paginate(15))
        ]);
    }

    public function show(News $news)
    {
//        return inertia('News/Show', [
//            'news' => NewsResource::singleItem($news)
//        ]);
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        News::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
