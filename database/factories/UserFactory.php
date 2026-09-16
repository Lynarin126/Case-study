<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $khmerFirsts = ['វណ្ណៈ', 'សុភា', 'ពិសិដ្ឋ', 'សុវណ្ណ', 'រតនា', 'ស្រីមុំ', 'បុនរិទ្ធ', 'ចិន្តា'];
        $khmerLasts = ['សុខ', 'ជា', 'ហេង', 'ចាន់', 'កែវ', 'អ៊ុក', 'ឈុំ', 'ម៉ៅ'];
        $latinFirsts = ['Vannak', 'Sophea', 'Piseth', 'Sovann', 'Rattana', 'Sreymom', 'Bunrith', 'Chinda'];
        $latinLasts = ['Sok', 'Chea', 'Heng', 'Chan', 'Keo', 'Ouk', 'Chhom', 'Mao'];

        $index = fake()->numberBetween(0, count($khmerFirsts) - 1);
        $kFirst = $khmerFirsts[$index];
        $kLast = $khmerLasts[$index];
        $lFirst = $latinFirsts[$index];
        $lLast = $latinLasts[$index];

        return [
            'first_name' => $kFirst,
            'last_name' => $kLast,
            'first_name_latin' => $lFirst,
            'last_name_latin' => $lLast,
            'name' => "{$kFirst} {$kLast}",
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
