<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class StockItemRetailAdvertsDisplayOptionsBuilder extends AbstractBuilder
{
    protected $excludePreviousOwners = false;

    protected $excludeStrapline = false;

    protected $excludeMot = false;

    protected $excludeWarranty = false;

    protected $excludeInteriorDetails = false;

    protected $excludeTyreCondition = false;

    protected $excludeBodyCondition = false;

    public function getExcludePreviousOwners(): bool
    {
        return $this->excludePreviousOwners;
    }

    public function setExcludePreviousOwners(bool $value): self
    {
        $this->excludePreviousOwners = $value;

        return $this;
    }

    public function getExcludeStrapline(): bool
    {
        return $this->excludeStrapline;
    }

    public function setExcludeStrapline(bool $value): self
    {
        $this->excludeStrapline = $value;

        return $this;
    }

    public function getExcludeMot(): bool
    {
        return $this->excludeMot;
    }

    public function setExcludeMot(bool $value): self
    {
        $this->excludeMot = $value;

        return $this;
    }

    public function getExcludeWarranty(): bool
    {
        return $this->excludeWarranty;
    }

    public function setExcludeWarranty(bool $value): self
    {
        $this->excludeWarranty = $value;

        return $this;
    }

    public function getExcludeInteriorDetails(): bool
    {
        return $this->excludeInteriorDetails;
    }

    public function setExcludeInteriorDetails(bool $value): self
    {
        $this->excludeInteriorDetails = $value;

        return $this;
    }

    public function getExcludeTyreCondition(): bool
    {
        return $this->excludeTyreCondition;
    }

    public function setExcludeTyreCondition(bool $value): self
    {
        $this->excludeTyreCondition = $value;

        return $this;
    }

    public function getExcludeBodyCondition(): bool
    {
        return $this->excludeBodyCondition;
    }

    public function setExcludeBodyCondition(bool $value): self
    {
        $this->excludeBodyCondition = $value;

        return $this;
    }

    public function toArray(): array
    {
        return $this->filterPrepareOutput([
            'excludePreviousOwners' => $this->excludePreviousOwners,
            'excludeStrapline' => $this->excludeStrapline,
            'excludeMot' => $this->excludeMot,
            'excludeWarranty' => $this->excludeWarranty,
            'excludeInteriorDetails' => $this->excludeInteriorDetails,
            'excludeTyreCondition' => $this->excludeTyreCondition,
            'excludeBodyCondition' => $this->excludeBodyCondition,
        ]);
    }
}