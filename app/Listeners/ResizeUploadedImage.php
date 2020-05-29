<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResizeUploadedImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ImageWasUploaded $event)
    {
        $path = $event->path();
        $image = Image::make($path);
        if($image->width() < 500) {
            return;
        }
        // resize the image to a width of 500 and constrain aspect ratio (auto height)
        $image->resize(null, 500, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $image->orientate();
        $image->save($path);
    }
}
