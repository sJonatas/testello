<?php

namespace App\Http\Controllers;

use App\Services\ImportedFilesService;

class ImportedFilesController extends Controller
{
    public function index(ImportedFilesService $importedFile)
    {
        return view('imported-files.index', ['files' => $importedFile->getPaginated()]);
    }
}
