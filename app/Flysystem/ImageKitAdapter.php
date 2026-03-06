<?php

namespace App\Flysystem;

use ImageKit\ImageKit;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;

class ImageKitAdapter implements FilesystemAdapter
{
    public function __construct(private ImageKit $imageKit) {}

    public function write(string $path, string $contents, Config $config): void
    {
        $response = $this->imageKit->uploadFile([
            'file' => base64_encode($contents),
            'fileName' => basename($path),
            'folder' => dirname($path),
            'useUniqueFileName' => false, // matikan unique filename
        ]);

        if ($response->error) {
            throw new \Exception('ImageKit upload failed: ' . json_encode($response->error));
        }
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $this->write($path, stream_get_contents($contents), $config);
    }

    public function read(string $path): string
    {
        return file_get_contents($this->getUrl($path));
    }

    public function readStream(string $path)
    {
        return fopen($this->getUrl($path), 'r');
    }

    public function delete(string $path): void {}

    public function deleteDirectory(string $path): void {}

    public function createDirectory(string $path, Config $config): void {}

    public function setVisibility(string $path, string $visibility): void {}

    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, null, 'public');
    }

    public function mimeType(string $path): FileAttributes
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $mimeTypes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
        ];

        $mimeType = $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';

        return new FileAttributes($path, null, null, null, $mimeType);
    }

    public function lastModified(string $path): FileAttributes
    {
        return new FileAttributes($path, null, null, time());
    }

    public function fileSize(string $path): FileAttributes
    {
        return new FileAttributes($path, 0);
    }

    public function listContents(string $path, bool $deep): iterable
    {
        return [];
    }

    public function move(string $source, string $destination, Config $config): void {}

    public function copy(string $source, string $destination, Config $config): void {}

    public function fileExists(string $path): bool
    {
        return true;
    }

    public function directoryExists(string $path): bool
    {
        return true;
    }

    public function getUrl(string $path): string
    {
        return rtrim(env('IMAGEKIT_URL_ENDPOINT'), '/') . '/' . ltrim($path, '/');
    }
}