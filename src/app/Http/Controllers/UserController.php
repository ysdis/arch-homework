<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function show(User $user): JsonResponse
    {
        return responder()->success(
            $user,
            UserTransformer::class
        )->respond();
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $fields = $request->validated();
        $user   = new User;

        foreach ($fields as $key => $field) {
            $user->{$key} = $field;
        }

        if ($user->save()) {
            return responder()->success($user, UserTransformer::class)->respond(200);
        }

        return responder()->error()->respond(500);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->delete()) {
            return responder()->success()->respond(200);
        }

        return responder()->error()->respond();
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $fields = $request->validated();

        foreach ($fields as $key => $field) {
            $user->{$key} = $field;
        }

        if ($user->save()) {
            return responder()->success([])->respond(201);
        }

        return responder()->error()->respond(500);
    }
}
