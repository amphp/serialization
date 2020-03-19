<?php

namespace Amp\Serialization\Test;

use Amp\Serialization\CompressingSerializer;
use Amp\Serialization\NativeSerializer;
use Amp\Serialization\Serializer;

class CompressingSerializerTest extends AbstractSerializerTest
{
    public function createSerializer(): Serializer
    {
        return new CompressingSerializer(new NativeSerializer);
    }
}
