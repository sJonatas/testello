<?php

namespace App\Http\Controllers;

use App\Dto\FilePathDto;
use App\Jobs\FileCleanup;
use App\Jobs\ImportShippingRates;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;

class ShippingRatesController extends Controller
{
    public function import(Request $request, int $client_id)
    {
        $files = [];

        /** @var UploadedFile $file */
        foreach ($request->allFiles()['import'] as $file) {
            $files[] = new FilePathDto(
                $file->getClientOriginalName(),
                $file->storePublicly('imports', 'public'),
            );
        }

        Bus::chain([
            new ImportShippingRates($client_id, $files),
            new FileCleanup($files),
        ])->dispatch();

        alert()->success('Sucesso', 'Seu arquivo esta sendo procesado.');

        return redirect(route('clients.rates', ['id' => $client_id]));
    }
}
