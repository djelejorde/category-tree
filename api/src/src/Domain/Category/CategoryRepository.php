<?php

declare(strict_types=1);

namespace SearchApi\Domain\Category;

use SearchApi\Domain\EntityRepositoryInterface;
use SearchApi\Domain\Category\Category;

use PDO;

class CategoryRepository implements EntityRepositoryInterface
{
    private $connection;
    private $table = 'categories';

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        return $this->connection
            ->query(
                'SELECT * FROM ' . $this->table
            )
            ->fetchAll()
        ;
    }

    public function findById(int $id): Category
    {
        $result = $this->findOneBy('id', $id);

        return new Category(
            (int) $result['id'],
            $result['label'],
            (int) $result['parent_id']
        );
    }

    /**
     *
     * @param  int $parentId
     *
     * @return  Category[]
     */
    public function findByParentId(int $parentId): array
    {
        $results = $this->findBy('parent_id', $parentId);
        $categories = [];

        foreach ($results as $result) {
            $categories[] = new Category(
                (int) $result['id'],
                $result['label'],
                (int) $result['parent_id']
            );
        }

        return $categories;
    }

    private function findOneBy(string $name, $value): array
    {
        $query = $this->connection
                    ->prepare(
                        "SELECT * FROM {$this->table} WHERE {$name} = :{$name}"
                    )
        ;
        
        $query->execute([$name => $value]);

        return $query->fetch();
    }

    private function findBy(string $name, $value): array
    {
        $query = $this->connection
                    ->prepare(
                        "SELECT * FROM {$this->table} WHERE {$name} = :{$name}"
                    )
        ;
        
        $query->execute([$name => $value]);

        return $query->fetchAll();
    }
}
