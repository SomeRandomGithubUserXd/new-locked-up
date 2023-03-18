<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppealRequest;
use App\Http\Requests\Appeals\FilterRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\AppealResource;
use App\Models\Appeal;
use App\Models\Orders\Order;
use Illuminate\Http\RedirectResponse;

class AppealController extends AbstractControllerWithMultipleDeletion
{
    public function index(FilterRequest $request)
    {
        $appealQuery = Appeal::when($request->source, static function ($query) use ($request) {
            $query->where(['source_id' => array_search($request->get('source'), Appeal::$sources, true)]);
        })->orderByDesc('id');
        return inertia('Appeals/Index', [
            'appeals' => AppealResource::collection($appealQuery->paginate(15)),
            'sourceList' => Appeal::$sources
        ]);
    }

    public function show(Appeal $appeal)
    {
        return inertia('Appeals/Show', [
            'appeal' => AppealResource::singleItem($appeal),
            'statuses' => Appeal::$statuses,
            'sources' => Appeal::$sources,
            'forms' => collect(Appeal::$forms)->unique()
        ]);
    }

    public function update(AppealRequest $request, Appeal $appeal)
    {
        $appeal->update($request->getUnRefactoredValidatedData());
        return redirect()->route('appeals.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Appeal::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
