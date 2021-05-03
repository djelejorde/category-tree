<?php

declare(strict_types=1);

namespace SearchApi\Application\Actions\Category;

use Psr\Http\Message\ResponseInterface as Response;

class GetCategoryAction extends CategoryAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData(
            $this->categoryRepository->findById((int) $this->resolveArg('id'))
        );
    }
}
