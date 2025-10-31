<?php

namespace App\Jobs;

use App\Dto\FilePathDto;
use App\Enum\Statuses;
use App\Models\ImportedFile;
use App\Services\ShippingRateImporterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class ImportShippingRates implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $timeout = 60 * 60;

    /**
     * @param  FilePathDto[]  $filepaths
     */
    public function __construct(
        protected int $clientId,
        protected array $filepaths,
    ) {
        DB::beginTransaction();

        try {
            foreach ($this->filepaths as $filepath) {
                $model = ImportedFile::query()->create([
                    'filename' => $filepath->name,
                    'size' => Storage::disk('public')->size($filepath->path),
                ]);

                $filepath->id = $model->id;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception('Failed to queue files. '.$e->getMessage());
        }
    }

    /**
     * Execute the job.
     */
    public function handle(ShippingRateImporterService $shippingRateService): void
    {
        Log::withContext([
            'client_id' => $this->clientId,
            'filepaths' => $this->filepaths,
        ]);

        // todo: dispatch alert message
        foreach ($this->filepaths as $filepath) {
            try {
                ImportedFile::query()->find($filepath->id)->update(['status' => Statuses::Processando->value]);
                DB::beginTransaction();

                $path = Storage::disk('public')->path($filepath->path);

                $shippingRateService
                    ->forClient($this->clientId)
                    ->import($path, null, Excel::CSV);

                DB::commit();
                ImportedFile::query()->find($filepath->id)->update(['status' => Statuses::Sucesso->value]);
            } catch (\Exception $exception) {
                DB::rollBack();

                Log::error('Failed to import file(s)', ['error' => $exception->getMessage(), 'trace' => $exception->getTraceAsString()]);
                ImportedFile::query()->find($filepath->id)->update(['status' => Statuses::Falha->value, 'failure' => $exception->getMessage()]);
            }

        }
    }
}
