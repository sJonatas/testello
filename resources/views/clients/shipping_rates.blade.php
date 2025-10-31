<x-layout>
    <x-slot:pageTitle>
        {{$client->full_name}} - Tabela de Fretes
    </x-slot:pageTitle>
    <x-slot:subtitle>
        Lista de custos para faixas de CEP.
    </x-slot:subtitle>

    <div class="text-right mt-10">
        <form method="post" action="{{route('shipping-rate.import', ['client_id' => $client->id])}}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="import[]" multiple class="form-control mt-10" required accept="text/csv"/>

            <button type="submit" class="btn btn-info mt-10">
                <i class="ti ti-arrow-up"></i> Importar
            </button>
        </form>
    </div>

    <div class="table-responsive mt-4">
        @if ($rates->isEmpty())
            <span class="alert-muted">Nenhuma faixa de CEP registrada.</span>
        @endif

        @if ($rates->isNotEmpty())
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
            <thead>
            <tr>
                <th>CEP Origem</th>
                <th>CEP Destino</th>
                <th>Peso Minimo</th>
                <th>Peso Maximo</th>
                <th>Custo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rates as $rate)
                <tr>
                    <td>{{$rate->from_postcode}}</td>
                    <td>{{$rate->to_postcode}}</td>
                    <td>{{$rate->from_weight}}</td>
                    <td>{{$rate->to_weight}}</td>
                    <td>{{$rate->cost}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $rates->onEachSide(5)->links() }}
        @endif
    </div>
</x-layout>
