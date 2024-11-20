<?php

namespace App\Observers;

class ShelfObserver
{
    public function creating($shelf)
    {
        if (empty($shelf->order)) {
            $shelf->order = $shelf->order ?? $shelf->warehouse->shelves()->max('order') + 1;
        }
    }
}
