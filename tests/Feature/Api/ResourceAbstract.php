<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

abstract class ResourceAbstract extends TestCase
{

    use RefreshDatabase;

    protected static $lastId;

    protected $dump = false;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->defaultHeaders = [
            'X-API-TOKEN' => env('API_AUTH_TOKEN'),
        ];
    }

    abstract protected function getEndpointName(): string;
    abstract protected function getStoreData(): array;
    abstract protected function getUpdateData(): array;
    abstract protected function getReturnEntityStruct(): array;

    public function testCRUD()
    {
        // Create
        $response = $this->postJson(
            '/api/' . $this->getEndpointName(),
            $this->getStoreData()
        );
        if ($this->dump) $response->dump();
        $lastId = json_decode($response->getContent())->data->id;
        $this->assertStoreResult($response);

        // READ
        $response = $this->getJson('/api/' . $this->getEndpointName());
        if ($this->dump) $response->dump();
        $this->assertIndexResult($response);

        $response = $this->getJson('/api/' . $this->getEndpointName() . '/' . $lastId);
        if ($this->dump) $response->dump();
        $this->assertShowResult($response);

        // Update
        $response = $this->patchJson(
            '/api/' . $this->getEndpointName() . '/' . $lastId,
            $this->getUpdateData()
        );
        if ($this->dump) $response->dump();
        $this->assertUpdateResult($response);

        // Delete
        $response = $this->deleteJson('/api/' . $this->getEndpointName() . '/' . $lastId);
        if ($this->dump) $response->dump();
        $this->assertDestroyResult($response);
    }

    protected function assertStoreResult(TestResponse $response)
    {
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => $this->getReturnEntityStruct()
        ]);
        $response->assertJson(['data' => $this->mapResponseData($this->getStoreData())]);
    }

    protected function assertIndexResult(TestResponse $response)
    {
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'list' => [$this->getReturnEntityStruct()]
            ]
        ]);
        $response->assertJson([
            'data' => [
                'list' => [$this->mapResponseData($this->getStoreData())]
            ]
        ]);
    }

    protected function assertShowResult(TestResponse $response)
    {
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->getReturnEntityStruct()
        ]);
        $response->assertJson([
            'data' => $this->mapResponseData($this->getStoreData())
        ]);
    }

    protected function assertUpdateResult(TestResponse $response)
    {
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->getReturnEntityStruct()
        ]);
        $response->assertJson(['data' => $this->mapResponseData($this->getUpdateData())]);
    }

    protected function assertDestroyResult(TestResponse $response)
    {
        $response->assertStatus(204);
    }

    protected function mapResponseData($data)
    {
        $r = [];
        foreach ($data as $k => $v) {
            $kParts = explode('_', $k);
            $newK = array_shift($kParts);
            $kParts = array_map('ucfirst', $kParts);
            $newK .= implode('', $kParts);
            $r[$newK] = $v;
        }
        return $r;
    }
}
