<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        $owners = User::where('is_owner', true)->count();

        if ($owners > 1) {
            throw new RuntimeException('More than one owner account exists. Resolve this before seeding.');
        }

        if ($owners === 1) {
            $this->command?->info('Owner account already exists; credentials were left unchanged.');

            return;
        }

        $credentials = [
            'name' => config('owner.name'),
            'email' => Str::lower(trim((string) config('owner.email'))),
            'password' => config('owner.password'),
        ];

        Validator::make($credentials, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12', 'max:72'],
        ], [
            'email.required' => 'Set OWNER_EMAIL in .env before seeding the owner account.',
            'password.required' => 'Set OWNER_PASSWORD in .env before seeding the owner account.',
            'password.min' => 'OWNER_PASSWORD must contain at least 12 characters.',
            'password.max' => 'OWNER_PASSWORD must contain at most 72 characters.',
        ])->validate();

        // Reuse a previously registered account with this email when bootstrapping.
        $owner = User::whereRaw('LOWER(email) = ?', [$credentials['email']])->first() ?? new User;
        $owner->forceFill([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'email_verified_at' => now(),
            'remember_token' => null,
            'is_owner' => true,
        ])->save();

        $this->command?->info('Owner account seeded.');
    }
}
