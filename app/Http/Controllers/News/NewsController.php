<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\News\NewsRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\News\NewsResource;
use App\Models\News\News;
use App\Models\Quests\Quest;
use Illuminate\Http\RedirectResponse;

class NewsController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('News/Index', [
            'news' => NewsResource::collection(News::paginate(15))
        ]);
    }

    public function create()
    {
        return inertia('News/Create', [
            'questList' => Quest::where('name_ru', '!=', '')->get()
        ]);
    }


    public function store(NewsRequest $request)
    {
        $news = News::create($request->getUnRefactoredValidatedData());
        $news->quests()->sync($request->quests_attached);
        return redirect()->route('news.index');
    }


    public function update(NewsRequest $request, News $news)
    {
        $news->update($request->getUnRefactoredValidatedData());
        $news->quests()->sync($request->quests_attached);
        return redirect()->route('news.index');
    }


    public function show(News $news)
    {
        return inertia('News/Show', [
            'news' => NewsResource::singleItem($news),
            'questList' => Quest::where('name_ru', '!=', '')->get()
        ]);
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        News::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
