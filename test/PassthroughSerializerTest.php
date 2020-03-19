<?php

namespace Amp\Serialization\Test;

use Amp\Serialization\PassthroughSerializer;
use Amp\Serialization\SerializationException;
use PHPUnit\Framework\TestCase;

class PassthroughSerializerTest extends TestCase
{
    public function testUnserializeSerializedData(): void
    {
        $serializer = new PassthroughSerializer;
        $data = 'test';
        $this->assertSame($data, $serializer->unserialize($serializer->serialize($data)));
    }

    public function testNonString(): void
    {
        $this->expectException(SerializationException::class);

        (new PassThroughSerializer)->serialize(1);
    }
}
