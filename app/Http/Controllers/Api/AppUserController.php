<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppUserRequest;
use App\Http\Requests\UpdateAppUserRequest;
use App\Models\AppUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AppUserController extends Controller
{
    public function store(StoreAppUserRequest $request): JsonResponse
    {
        $user = AppUser::updateOrCreate(
            ['phone' => $request->phone],
            [
                'name' => $request->name,
                'last_seen_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'Welcome!',
            'data' => $this->formatUser($user),
        ], 200);
    }

    public function update(UpdateAppUserRequest $request, AppUser $appUser): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($appUser->avatar) {
                Storage::disk('public')->delete($appUser->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $appUser->update($data);

        return response()->json([
            'message' => 'Profile updated successfully!',
            'data' => $this->formatUser($appUser->fresh()),
        ], 200);
    }

    /**
     * @return array<string, mixed>
     */
    private function formatUser(AppUser $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'avatar_url' => $user->avatar
                ? asset('storage/'.$user->avatar)
                : null,
            'last_seen_at' => $user->last_seen_at?->toISOString(),
        ];
    }
}
