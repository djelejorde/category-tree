<?php

declare(strict_types=1);

namespace SearchApi\Domain;

interface EntityRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id);
}