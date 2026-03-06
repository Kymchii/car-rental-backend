<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use ImageKit\ImageKit;
use League\Flysystem\Filesystem;
use League\MimeTypeDetection\Generation\FlysystemProvidedMimeTypeProvider;

class ImageKitServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('imagekit', function ($app, $config) {
            $imageKit = new ImageKit(
                $config['public_key'],
                $config['private_key'],
                $config['url_endpoint'],

            );

            return new Filesystem(new ImageKitAdapter($imageKit));
        });
    }
}