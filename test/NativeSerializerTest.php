<?php

namespace Amp\Serialization\Test;

use Amp\Serialization\NativeSerializer;
use Amp\Serialization\Serializer;

class NativeSerializerTest extends AbstractSerializerTest
{
    public function createSerializer(): Serializer
    {
        return new NativeSerializer;
    }
}
