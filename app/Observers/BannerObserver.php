<?php

namespace App\Observers;

use App\Models\Banner;

class BannerObserver
{
    /**
     * Handle the Banner "created" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function created(Banner $banner)
    {
        if (is_null($banner->order)) {
            $banner->order = Banner::max('order') + 1;
            return;
        }

        $lowerPriorityBanners = Banner::where('order', '>=', $banner->order)
            ->get();

        foreach ($lowerPriorityBanners as $lowerPriorityBanner) {
            $lowerPriorityBanner->order++;
            $lowerPriorityBanner->saveQuietly();
        }
    }

    /**
     * Handle the Banner "updated" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function updated(Banner $banner)
    {
        if ($banner->isClean('order')) {
            return;
        }

        if (is_null($banner->order)) {
            $banner->order = Banner::max('order');
        }

        if ($banner->getOriginal('order') > $banner->order) {
            $orderRange = [
                $banner->order, $banner->getOriginal('order')
            ];
        } else {
            $orderRange = [
                $banner->getOriginal('order'), $banner->order
            ];
        }

        $lowerPriorityBanners = Banner::where('id', '!=', $banner->id)
            ->whereBetween('order', $orderRange)
            ->get();

        foreach ($lowerPriorityBanners as $lowerPriorityBanner) {
            if ($banner->getOriginal('order') < $banner->order) {
                $lowerPriorityBanner->order--;
            } else {
                $lowerPriorityBanner->order++;
            }
            $lowerPriorityBanner->saveQuietly();
        }
    }

    /**
     * Handle the Banner "deleted" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function deleted(Banner $banner)
    {
        $lowerPriorityCategories = Banner::where('order', '>', $banner->order)
            ->get();

        foreach ($lowerPriorityCategories as $lowerPriorityBanner) {
            $lowerPriorityBanner->order--;
            $lowerPriorityBanner->saveQuietly();
        }
    }
}
