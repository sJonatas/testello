<?php

namespace App\Enum;

enum Statuses: string
{
    case Ativo = 'ativo';
    case Inativo = 'inativo';

    case NaFila = 'Na Fila';
    case Processando = 'Processando';
    case Sucesso = 'Sucesso';
    case Falha = 'Falha';

    public static function values()
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
