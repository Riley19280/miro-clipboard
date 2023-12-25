<?php

namespace MiroClipboard\Utility;

trait SetPropertiesFromArray
{
    /**
     * @param array                  $data
     * @param array<string, Closure> $overrides
     *
     * @return mixed
     *
     * @internal
     */
    public function setPropertiesFromArray(array $data, array $overrides = []): self
    {
        foreach ($data as $key => $val) {
            if (array_key_exists($key, $overrides)) {
                $overrides[$key]($this, $val);
            } elseif (property_exists($this, $key)) {
                $reflectionProp = new \ReflectionProperty($this, $key);

                if (enum_exists($enumName = $reflectionProp->getType()->getName())) {
                    $this->$key = $enumName::from($val);
                } else {
                    $this->$key = $val;
                }
            }
        }

        return $this;
    }
}
