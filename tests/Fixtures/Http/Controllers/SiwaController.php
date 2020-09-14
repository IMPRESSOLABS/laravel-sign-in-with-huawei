<?php

namespace ImpressoLabs\LaravelSignInWithHuawei\Tests\Fixtures\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class SiwaController
{
    public function login()
    {
        return Socialite::driver("huawei")
            ->scopes(["name", "email"])
            ->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver("huawei")
            ->user();
    }
}
