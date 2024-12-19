<?php

namespace App\Traits;

trait DateHelperTrait
{
    public function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}
