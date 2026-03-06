<?php

namespace App\Providers;

use App\Flysystem\ImageKitAdapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use ImageKit\ImageKit;
use League\Flysystem\Filesystem;

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

            $adapter = new ImageKitAdapter($imageKit);
            $filesystem = new Filesystem($adapter);

            return new FilesystemAdapter($filesystem, $adapter, $config, function ($path) use ($config) {
                return rtrim($config['url_endpoint'], '/') . '/' . ltrim($path, '/');
            });
        });
    }
}