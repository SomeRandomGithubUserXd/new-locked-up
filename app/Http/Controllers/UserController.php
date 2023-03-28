<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\Location;
use App\Models\User\User;
use Hash;
use Illuminate\Http\RedirectResponse;
use Inertia\Testing\Concerns\Has;

class UserController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('Users/Index', [
            'users' => UserResource::collection(User::paginate(15))
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    public function show(User $user)
    {
        return inertia('Users/Show', [
            'user' => UserResource::singleItem($user),
            'userRoles' => UserRoleEnum::getArray(),
            'locations' => Location::select(['id', 'name_ru'])->get()
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    public function create(User $user)
    {
        return inertia('Users/Create', [
            'user' => UserResource::singleItem($user),
            'userRoles' => UserRoleEnum::getArray(),
            'locations' => Location::select(['id', 'name_ru'])->get()
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $locationIds = $data['location_ids'];
        unset($data['location_ids']);
        $user = User::create($data);
        $user->locations()->sync($locationIds);
        return redirect()->route('users.index');
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $locationIds = $data['location_ids'];
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        unset($data['location_ids']);
        $user->update($data);
        $user->locations()->sync($locationIds);
        return redirect()->route('users.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        User::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
