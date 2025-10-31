<?php

namespace App\Services;

use App\Models\ImportedFile;

class ImportedFilesService
{
    public function __construct(
        protected ImportedFile $importedFile
    ) {}

    public function getPaginated()
    {
        return $this->importedFile->paginate(10);
    }
}
