<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll(?string $search = null): Collection
    {
        return User::search($search)->latest('id')->get();
    }

    public function create(array $data): User
    {
        $khmerName = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
        $latinName = trim(($data['first_name_latin'] ?? '') . ' ' . ($data['last_name_latin'] ?? ''));
        $combinedName = $khmerName ?: $latinName;

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'first_name_latin' => $data['first_name_latin'],
            'last_name_latin' => $data['last_name_latin'] ?? null,
            'name' => $combinedName,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function update(User $user, array $data): bool
    {
        $khmerName = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
        $latinName = trim(($data['first_name_latin'] ?? '') . ' ' . ($data['last_name_latin'] ?? ''));
        $combinedName = $khmerName ?: $latinName;

        $updateData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'first_name_latin' => $data['first_name_latin'],
            'last_name_latin' => $data['last_name_latin'] ?? null,
            'name' => $combinedName,
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        return $user->update($updateData);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
