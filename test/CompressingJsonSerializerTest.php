<?php declare(strict_types=1);

namespace Amp\Serialization\Test;

use Amp\Serialization\CompressingSerializer;
use Amp\Serialization\Serializer;

class CompressingJsonSerializerTest extends JsonSerializerTest
{
    protected function createSerializer(int $encodeOptions = 0, int $decodeOptions = 0): Serializer
    {
        return new CompressingSerializer(parent::createSerializer($encodeOptions, $decodeOptions));
    }
}
