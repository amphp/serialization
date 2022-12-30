<?php declare(strict_types=1);

namespace Amp\Serialization\Test;

use Amp\Serialization\NativeSerializer;
use Amp\Serialization\SerializationException;
use Amp\Serialization\Serializer;
use PHPUnit\Framework\TestCase;

class NativeSerializerTest extends TestCase
{
    protected function createSerializer(): Serializer
    {
        return new NativeSerializer;
    }

    public function provideSerializeData(): iterable
    {
        return [
            ['test'],
            [new \stdClass],
            [3.14],
            [['test', 1, new \stdClass]],
        ];
    }

    /**
     * @dataProvider provideSerializeData
     */
    public function testUnserializeSerializedData($data): void
    {
        $serializer = $this->createSerializer();

        $serialized = $serializer->serialize($data);

        $this->assertEquals($data, $serializer->unserialize($serialized));
    }

    public function provideLargeSerializeData(): iterable
    {
        return [
            [\str_repeat('a', 1 << 20)],
            [[\str_repeat('a', 1024), \str_repeat('b', 1024), \str_repeat('c', 1024)]],
        ];
    }

    /**
     * @depends      testUnserializeSerializedData
     * @dataProvider provideLargeSerializeData
     */
    public function testUnserializeSerializedLargeData($data): void
    {
        $data = [
            \str_repeat('a', 1024),
            \str_repeat('b', 1024),
            \str_repeat('c', 1024),
        ];

        $serializer = $this->createSerializer();

        $serialized = $serializer->serialize($data);

        $this->assertEquals($data, $serializer->unserialize($serialized));
    }

    public function provideUnserializableData(): iterable
    {
        return [
            [function () {
                // Empty function
            }],
            [new class() {
                // Empty class
            }],
        ];
    }

    /**
     * @dataProvider provideUnserializableData
     */
    public function testUnserializableData($data): void
    {
        $this->expectException(SerializationException::class);

        $this->createSerializer()->serialize($data);
    }

    public function provideInvalidData(): iterable
    {
        return [
            ['invalid data'],
        ];
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testUnserializeInvalidData($data): void
    {
        $this->expectException(SerializationException::class);

        $this->createSerializer()->unserialize($data);
    }
}
