<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AppRegister extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cozy:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a project and get a token';

    /**
     * @return void
     * @throws
     */
    public function handle(): void
    {
        $email = $this->ask('Please enter your email');
        $user = User::whereEmail($email)->first();
        if (!$user) {
            $name = $this->ask('Please enter your name');
            $password = $this->secret('Please enter your password');
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        }

        $appName = $this->ask('Please enter your app name');
        $device = $this->ask('Please enter your device');
        $token = $user->createToken($appName . ':' . $device)->plainTextToken;

        echo 'App name: ', $appName, PHP_EOL;
        echo 'Device: ', $device, PHP_EOL;
        echo 'Token: ', $token, PHP_EOL;
    }

}
