<?php

declare(strict_types=1);

namespace SearchApi\Application\Actions\Category;

use Psr\Http\Message\ResponseInterface as Response;

class GetCategoriesAction extends CategoryAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $parent = $this->getQueryParam('parent');
        
        if (isset($parent) && is_numeric($parent)) {
            return $this->respondWithData($this->categoryRepository->findByParentId((int) $parent));
        }

        return $this->respondWithData($this->categoryRepository->findAll());
    }
}
