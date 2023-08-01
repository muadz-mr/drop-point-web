<?php

namespace App\Observers;

use App\Models\Package;

class PackageObserver
{
    /**
     * Handle the Package "created" event.
     */
    public function created(Package $package): void
    {
        //
    }

    /**
     * Handle the Package "updated" event.
     */
    public function updated(Package $package): void
    {
        //
    }

    /**
     * Handle the Package "deleted" event.
     */
    public function deleted(Package $package): void
    {
        $path = public_path($package->image_path);

        if ($package->image_path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * Handle the Package "restored" event.
     */
    public function restored(Package $package): void
    {
        //
    }

    /**
     * Handle the Package "force deleted" event.
     */
    public function forceDeleted(Package $package): void
    {
        //
    }
}
