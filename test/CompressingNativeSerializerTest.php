<?php declare(strict_types=1);

namespace Amp\Serialization\Test;

use Amp\Serialization\CompressingSerializer;
use Amp\Serialization\Serializer;

class CompressingNativeSerializerTest extends NativeSerializerTest
{
    protected function createSerializer(): Serializer
    {
        return new CompressingSerializer(parent::createSerializer());
    }
}
