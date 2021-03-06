<?php

namespace ImpressoLabs\LaravelSignInWithHuawei\Tests\Browser;


use Laravel\Dusk\Browser;
use ImpressoLabs\LaravelSignInWithHuawei\Tests\BrowserTestCase;

class SignInWithHuaweiTest extends BrowserTestCase
{
    public function testButtonIsRendered()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/tests")
                ->assertSee("Sign in with Huawei");
        });
    }

    public function testRedirectShowsHuaweiIdLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/tests")
                ->click('#sign-in-with-huawei')
                ->assertSee("Use your Huawei ID to sign in to Test Service ID.");
        });
    }
}
