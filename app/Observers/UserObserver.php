<?php

namespace App\Observers;


class UserObserver
{
    public function saving()
    {
        \Cache::flush();
    }
}
