<?php

namespace App\Jobs;

use App\Dto\FilePathDto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileCleanup implements ShouldQueue
{
    use Queueable;

    /**
     * @var FilePathDto[] array
     */
    public array $files;

    /**
     * @param  FilePathDto[]  $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }

    public function handle()
    {
        Log::withContext(['files' => $this->files]);

        foreach ($this->files as $file) {
            Storage::disk('public')->delete($file->path);
        }
    }
}
