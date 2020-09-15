
# Sign In With Huawei for Laravel

![repository-open-graph-template](https://user-images.githubusercontent.com/1791050/66706715-21cc0800-eceb-11e9-90b4-0a6ae3dd97b7.png)

## Supporting This Package
*Code base fork from GeneaLabs/laravel-sign-in-with-apple*

This is an MIT-licensed open source project with its ongoing development made possible by the support of the community. If you'd like to support this, and our other packages, please consider sponsoring us via the button above.

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
            ->scopes(["profile", "email"])
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

Note that when processing the returned `$user` object, it is critical to know that the `sub` element is the unique identifier for the user, **NOT** the email address. For more details, visit https://developer.huawei.com/consumer/en/doc/development/HMS-References/account-obtain-token.

----------

#### Credits
1. https://developer.huawei.com/consumer/en/doc/development/HMS-References/account-obtain-token
2. https://forums.developer.huawei.com/forumPortal/en/topicview?tid=0201272938220820099&fid=0101187876626530001
3. https://developer.huawei.com/consumer/en/doc/development/HMS-Plugin-References-V1/scope-0000001050728398-V1

----------

## Commitment to Quality

## Contributing
Please observe and respect all aspects of the included [Code of Conduct](https://github.com/IMPRESSOLABS/laravel-sign-in-with-huawei/blob/master/CODE_OF_CONDUCT.md).

### Reporting Issues
When reporting issues, please fill out the included template as completely as
possible. Incomplete issues may be ignored or closed if there is not enough
information included to be actionable.

### Submitting Pull Requests
Please review the [Contribution Guidelines](https://github.com/IMPRESSOLABS/laravel-sign-in-with-huawei/blob/master/CONTRIBUTING.md). Only PRs that meet all criterium will be accepted.

## If you ❤️ open-source software, give the repos you use a ⭐️.
We have included the awesome `symfony/thanks` composer package as a dev dependency. Let your OS package maintainers know you appreciate them by starring the packages you use. Simply run `composer thanks` after installing this package. (And not to worry, since it's a dev-dependency it won't be installed in your live environment.)
