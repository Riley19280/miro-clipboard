<?php

namespace MiroClipboard\Utility;

use ReflectionNamedType;
use ReflectionProperty;

trait SetPropertiesFromArray
{
    /**
     * @param array                   $data
     * @param array<string, \Closure> $overrides
     *
     * @return self
     *
     * @internal
     */
    public function setPropertiesFromArray(array $data, array $overrides = []): self
    {
        foreach ($data as $key => $val) {
            if (array_key_exists($key, $overrides)) {
                $overrides[$key]($this, $val);
            } elseif (property_exists($this, $key)) {
                $reflectionProp = new ReflectionProperty($this, $key);

                $propType = $reflectionProp->getType();

                if (
                    $propType instanceof ReflectionNamedType &&
                    enum_exists($enumName = $propType->getName()) &&
                    (new \ReflectionEnum($enumName))->isBacked()
                ) {
                    /** @phpstan-ignore-next-line */
                    $this->$key = $enumName::from($val);
                } else {
                    $this->$key = $val;
                }
            }
        }

        return $this;
    }
}
