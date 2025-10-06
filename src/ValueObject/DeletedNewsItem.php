<?php

declare(strict_types=1);

namespace App\ValueObject;

class DeletedNewsItem
{
    public private(set) int $id {
        set {
            if ($value === 0) {
                throw new \InvalidArgumentException("News was not found!");
            }
            $this->id = (int) $value;
        }
    }
    
    public function __construct(array $post)
    {
        $this->id = (int) $post['id'] ?? 0;
    }
}
