<?php

namespace MiroClipboard\Utility;

use MiroClipboard\MiroClipboardData;
use MiroClipboard\Objects\MiroGroup;

trait HasGroup
{
    protected ?MiroGroup $group = null;

    public function group(): ?MiroGroup
    {
        return $this->group;
    }

    /**
     * @internal
     */
    public function setGroup(MiroGroup $group): static
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @param MiroClipboardData $clipboardData
     *
     * @return void
     *
     * @internal
     */
    public function resolveGroupClipboardDataReferences(MiroClipboardData $clipboardData): void
    {
        foreach ($clipboardData->getObjects() as $object) {
            if ($object instanceof MiroGroup) {
                if (in_array($this->getId(), $object->toArray()['items'])) {
                    if (in_array(HasGroup::class, class_uses(static::class))) {
                        $this->group = $object;
                    }
                }
            }
        }
    }
}
