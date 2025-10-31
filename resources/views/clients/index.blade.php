<x-layout>
    <x-slot:pageTitle>
        Clientes
    </x-slot:pageTitle>
    <x-slot:subtitle>
        Lista de clientes cadastrados.
    </x-slot:subtitle>

    <div class="table-responsive mt-4">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td><h6 class="mb-0 fw-bolder">{{$client->first_name}}</h6></td>
                    <td>{{$client->last_name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->status->value}}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{route('clients.rates', ['id' => $client->id])}}">
                            <i class="ti ti-list"></i> Faixa de CEPs
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $clients->onEachSide(2)->links() }}
    </div>
</x-layout>
