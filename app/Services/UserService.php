<?php

namespace App\Services;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function getFriendIds(int $userId): array
    {
        // Get all friend relationships in a single query
        return Friend::query()->where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->get()
            ->map(function ($friendship) use ($userId) {
                // Return the ID of the other user in the friendship
                return $friendship->user_id == $userId
                    ? $friendship->friend_id
                    : $friendship->user_id;
            })
            ->unique()
            ->values()
            ->toArray();
    }

// Replace the old friends method with a more efficient version if still needed
    public function friends(int $userId): Collection
    {
        return User::query()->whereIn('id', function($query) use ($userId) {
            $query->select('friend_id')
                ->from('friends')
                ->where('user_id', $userId)
                ->union(
                    Friend::select('user_id')
                        ->where('friend_id', $userId)
                );
        })->get();
    }

}
