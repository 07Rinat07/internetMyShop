<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProfileResource;
use App\Http\Requests\ProfileUpsertRequest;
use App\Models\Profile;

class ProfileController extends Controller {
    public function index() {
        return response()->json([
            'data' => ProfileResource::collection(
                auth()->user()->profiles()->latest('id')->get()
            )->resolve(),
        ]);
    }

    public function store(ProfileUpsertRequest $request) {
        $profile = auth()->user()->profiles()->create($request->validated());

        return response()->json([
            'data' => (new ProfileResource($profile))->resolve(),
        ], 201);
    }

    public function show(Profile $profile) {
        $profile = $this->ownedProfile($profile);

        return response()->json([
            'data' => (new ProfileResource($profile))->resolve(),
        ]);
    }

    public function update(ProfileUpsertRequest $request, Profile $profile) {
        $profile = $this->ownedProfile($profile);
        $profile->update($request->validated());

        return response()->json([
            'data' => (new ProfileResource($profile->fresh()))->resolve(),
        ]);
    }

    public function destroy(Profile $profile) {
        $this->ownedProfile($profile)->delete();

        return response()->json([], 204);
    }

    private function ownedProfile(Profile $profile) {
        if ((int)$profile->user_id !== (int)auth()->id()) {
            abort(404);
        }

        return $profile;
    }
}
