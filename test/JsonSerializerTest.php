<?php declare(strict_types=1);

namespace Amp\Serialization\Test;

use Amp\Serialization\JsonSerializer;
use Amp\Serialization\SerializationException;
use Amp\Serialization\Serializer;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    private const THROW_ON_ERROR = 4194304;

    protected function createSerializer(int $encodeOptions = 0, int $decodeOptions = 0): Serializer
    {
        return JsonSerializer::withAssociativeArrays($encodeOptions, $decodeOptions);
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

    public function testInvalidDataToUnserialize(): void
    {
        $this->expectException(SerializationException::class);

        $this->createSerializer()->unserialize('}');
    }

    /**
     * @depends testInvalidDataToUnserialize
     * @dataProvider provideSerializableData
     */
    public function testValidDataAfterInvalidData($data): void
    {
        $serializer = $this->createSerializer(self::THROW_ON_ERROR, self::THROW_ON_ERROR);

        try {
            $serializer->unserialize('}');
        } catch (SerializationException $e) {
            // Expected exception
        }

        $serialized = $serializer->serialize($data);

        $this->assertEquals($data, $serializer->unserialize($serialized));
    }
}
