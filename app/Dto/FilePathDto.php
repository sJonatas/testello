<?php

namespace App\Dto;

class FilePathDto
{
    public function __construct(
        public string $name,
        public string $path,
        public ?int $id = null,
    ) {}
}
