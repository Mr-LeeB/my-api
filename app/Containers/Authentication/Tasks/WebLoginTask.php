<?php

namespace App\Containers\Authentication\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authentication\Exceptions\LoginFailedException;
use App\Containers\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use SebastianBergmann\Environment\Console;

/**
 * Class WebLoginTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class WebLoginTask extends Task
{
    /**
     * @param string $email
     * @param string $password
     * @param bool   $remember
     *
     * @return Authenticatable
     * @throws LoginFailedException
     */
    public function run(string $email, string $password, bool $remember = false): Authenticatable
    {
        if (!$user = Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            // throw new LoginFailedException();
            $userExist = User::where('email', $email)->first();
            if ($userExist) {
                throw new LoginFailedException('Password is incorrect');
            } else {
                throw new LoginFailedException('Email does not exist');
            }
        }
        return Auth::user();
    }
}