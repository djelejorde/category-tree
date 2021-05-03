<?php

declare(strict_types=1);

namespace SearchApi\Application\Actions\Category;

use Psr\Http\Message\ResponseInterface as Response;

class GetChildCategoriesAction extends CategoryAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData(
            $this->categoryRepository->findByParentId((int) $this->resolveArg('id'))
        );
    }
}
