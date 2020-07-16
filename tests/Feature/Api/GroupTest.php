<?php

namespace Tests\Feature\Api;

class GroupTest extends ResourceAbstract
{

    protected function getEndpointName(): string
    {
        return 'groups';
    }

    protected function getStoreData(): array
    {
        return [
            'name' => 'Test group',
        ];
    }

    protected function getUpdateData(): array
    {
        return [
            'name' => 'Updated group',
        ];
    }

    protected function getReturnEntityStruct(): array
    {
        return ['id', 'name', 'createdAt', 'updatedAt'];
    }
}
