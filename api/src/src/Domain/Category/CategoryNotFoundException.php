<?php

declare(strict_types=1);

namespace SearchApi\Domain\Category;

use SearchApi\Domain\DomainException\DomainRecordNotFoundException;

class CategoryNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The category you requested does not exist.';
}
