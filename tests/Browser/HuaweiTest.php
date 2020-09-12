<?php

namespace GeneaLabs\LaravelSignInWithApple\Tests\Browser;

use GeneaLabs\LaravelSignInWithApple\Tests\BrowserTestCase;
use Laravel\Dusk\Browser;

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

    public function testRedirectShowsAppleIdLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/tests")
                ->click('#sign-in-with-huawei')
                ->assertSee("Use your Huawei ID to sign in to Test Service ID.");
        });
    }
}
