<?php

namespace App\Observers;

use App\Traits\Observer\Blameable;
use Illuminate\Support\Facades\Auth;

class UserObserver extends BaseObserver
{
    use Blameable;
}
