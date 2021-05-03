<?php

declare(strict_types=1);

namespace SearchApi\Application\Actions\Category;

use SearchApi\Application\Actions\Action;
use SearchApi\Domain\Category\CategoryRepository;
use Psr\Log\LoggerInterface;

abstract class CategoryAction extends Action
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @param LoggerInterface $logger
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        LoggerInterface $logger,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($logger);
        $this->categoryRepository = $categoryRepository;
    }
}
