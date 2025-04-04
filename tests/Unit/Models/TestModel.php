<?php

namespace Tests\Unit\Models;

use App\Models\BaseModel;

class TestModel extends BaseModel
{
    protected $id;
    protected $name;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
