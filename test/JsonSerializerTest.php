<?php

namespace Amp\Serialization\Test;

use Amp\Serialization\JsonSerializer;
use Amp\Serialization\Serializer;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    protected function createSerializer(): Serializer
    {
        return JsonSerializer::withAssociativeArrays();
    }

    public function provideSerializableData(): iterable
    {
        return [
            ['test'],
            [1],
            [3.14],
            [['test', 1, 3.14]],
            [[\str_repeat('a', 1024), \str_repeat('b', 1024), \str_repeat('c', 1024)]]
        ];
    }

    /**
     * @dataProvider provideSerializableData
     */
    public function testUnserializeSerializedData($data): void
    {
        $serializer = $this->createSerializer();

        $serialized = $serializer->serialize($data);

        $this->assertEquals($data, $serializer->unserialize($serialized));
    }
}
