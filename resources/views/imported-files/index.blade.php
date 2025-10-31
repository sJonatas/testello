<x-layout>
    <x-slot:pageTitle>
        Arquivos Importados
    </x-slot:pageTitle>
    <x-slot:subtitle>
        Lista de arquivos de faixas de CEP importados.
    </x-slot:subtitle>

    <div class="table-responsive mt-4">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Tamanho</th>
                    <th>Status</th>
                    <th>Motivo da Falha</th>
                    <th>Finalizado em</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($files as $file)
                <tr>
                    <td><h6 class="mb-0 fw-bolder">{{$file->filename}}</h6></td>
                    <td>{{round(($file->size / 1000)/1000, 4)}}mb</td>
                    <td>
                        @php
                        $statusClass = match($file->status->value) {
                            \App\Enum\Statuses::Sucesso->value => 'success',
                            \App\Enum\Statuses::Processando->value => 'warning',
                            \App\Enum\Statuses::Falha->value => 'danger',
                            \App\Enum\Statuses::NaFila->value => 'secondary',
                        }
                        @endphp
                        <span class="badge text-bg-{{$statusClass}}">
                            {{$file->status}}
                        </span>
                    </td>
                    <td>{{$file->failure}}</td>
                    <td>{{$file->updated_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $files->onEachSide(2)->links() }}
    </div>
</x-layout>
