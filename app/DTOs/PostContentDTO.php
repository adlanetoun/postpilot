<?php

namespace App\DTOs;

class PostContentDTO
{
    public function __construct(
        public string $content,
        public array $platforms,
        public ?string $mediaUrl = null
    ) {}
}
