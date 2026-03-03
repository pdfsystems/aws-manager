<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\text;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Creates a new user';

    public function handle(): void
    {
        $name = text('Name', 'John Doe', required: true);
        $email = text('Email', 'hello@example.com', required: true, validate: ['email']);
        $password = Str::password(16);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('User created successfully!');
        $this->info("Generated password: $password");
    }
}
