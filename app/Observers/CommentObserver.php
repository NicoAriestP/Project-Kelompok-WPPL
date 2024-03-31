<?php

namespace App\Observers;

use App\Traits\Observer\Blameable;

class CommentObserver extends BaseObserver
{
    use Blameable;
}
