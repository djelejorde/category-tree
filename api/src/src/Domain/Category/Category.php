<?php

declare(strict_types=1);

namespace SearchApi\Domain\Category;

use JsonSerializable;

class Category implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $parentId;

    /**
     * @param int|null  $id
     * @param string    $label
     * @param string    $parentId
     */
    public function __construct(?int $id, string $label, int $parentId = 0)
    {
        $this->id = $id;
        $this->label = $label;
        $this->parentId = $parentId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'parentId' => $this->parentId,
        ];
    }
}
