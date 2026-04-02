<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadsFiles
{
    public function uploadFile(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'public'
    ): string {
        $filename = time() . '_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($directory, $filename, $disk);
    }

    public function deleteFile(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }

    public function replaceFile(
        UploadedFile $file,
        ?string $oldPath = null,
        string $directory = 'uploads',
        string $disk = 'public'
    ): string {
        $this->deleteFile($oldPath, $disk);

        return $this->uploadFile($file, $directory, $disk);
    }
}