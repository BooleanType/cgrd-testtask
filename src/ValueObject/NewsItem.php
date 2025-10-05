<?php

declare(strict_types=1);

namespace App\ValueObject;

class NewsItem
{
    public private(set) int $id = 0;
    
    public private(set) string $title {
        set {
            if (strlen(trim($value)) === 0) {
                throw new \InvalidArgumentException("Title must be non-empty!");
            }
            $this->title = trim($value);
        }
    }
    
    public private(set) string $description {
        set {
            if (strlen(trim($value)) === 0) {
                throw new \InvalidArgumentException("Description must be non-empty!");
            }
            $this->description = trim($value);
        }
    }
    
    public function __construct(array $post)
    {
        $this->title = $post['title'] ?? '';
        $this->description = $post['description'] ?? '';
        $this->id = (int) $post['id'] ?? 0;
    }
}
