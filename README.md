
# Sign In With Huawei for Laravel


## Supporting This Package
*Code base fork from https://github.com/GeneaLabs/laravel-sign-in-with-apple*

This is an MIT-licensed open source project with its ongoing development made possible by the support of the community. If you'd like to support this, and our other packages, please consider sponsoring us via the button above.

https://medium.com/@starkliew/how-to-sign-in-using-huawei-id-with-laravel-336a2397b930

## Table of Contents
- [Requirements](#Requirements)
- [Installation](#Installation)
- [Configuration](#Configuration)
- [Implementation](#Implementation)
  - [Controller](#Controller)

<a name="Requirements"></a>
## Requirements

- PHP 7.2+
- Laravel 7+
- Socialite 4.2+
- Huawei Developer Account

<a name="Installation"></a>
## Installation

1. Install the composer package:
    ```sh
    composer require impressolabs/laravel-sign-in-with-huawei
    ```

<a name="Configuration"></a>
## Configuration

<a name="Implementation"></a>
## Implementation

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class HuaweiSigninController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return Socialite::driver("huawei")
            ->redirect();
    }

    public function callback(Request $request)
    {
        // get abstract user object, not persisted
        $user = Socialite::driver("huawei")
            ->user();
        
    }
}
```

----------

#### Credits
1. https://github.com/GeneaLabs/laravel-sign-in-with-apple
2. https://developer.huawei.com/consumer/en/doc/development/HMS-References/account-obtain-token
3. https://forums.developer.huawei.com/forumPortal/en/topicview?tid=0201272938220820099&fid=0101187876626530001
4. https://developer.huawei.com/consumer/en/doc/development/HMS-Plugin-References-V1/scope-0000001050728398-V1

----------



