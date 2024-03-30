<?php

namespace App\Observers;

use App\Traits\Observer\Blameable;
use Illuminate\Support\Facades\Auth;

class TaskObserver extends BaseObserver
{
    use Blameable;
}
