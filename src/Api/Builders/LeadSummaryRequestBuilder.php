<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use DateTime;
use Olsgreen\AutoTrader\Api\Enums\LeadStatus;

class LeadSummaryRequestBuilder extends AbstractBuilder implements BuilderInterface
{
    /**
     * Status of a lead. Multiple statuses can be accepted.
     */
    protected ?array $status = null;

    /**
     * Start date of search. With format YYYY-MM-DD.
     */
    protected ?DateTime $fromDate = null;

    /**
     * End date of search. With format YYYY-MM-DD.
     */
    protected ?DateTime $toDate = null;

    /**
     * Number of pages. Default page is 0.
     */
    protected ?int $page = null;

    /**
     * Size of the page. Default size is 10.
     */
    protected ?int $pageSize = null;

    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $statuses = new LeadStatus();

        foreach ($status as $statusText) {
            if (!$statuses->contains($statusText)) {
                throw new \Exception(
                    sprintf('\'%s\' is an invalid lead status.', $statusText)
                );
            }
        }

        $this->status = $status;

        return $this;
    }

    public function getFromDate(): ?DateTime
    {
        return $this->fromDate;
    }

    public function setFromDate(DateTime $date): self
    {
        $this->fromDate = $date;

        return $this;
    }

    public function getToDate(): ?DateTime
    {
        return $this->toDate;
    }

    public function setToDate(DateTime $date): self
    {
        $this->toDate = $date;

        return $this;
    }

    public function setPage($page): self
    {
        $this->page = (int) $page;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPageSize($size): self
    {
        $this->pageSize = $size;

        return $this;
    }

    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }

    public function toArray(): array
    {
        return $this->filterPrepareOutput([
            'status'         => $this->status,
            'fromDate'       => $this->fromDate ? $this->fromDate->format('Y-m-d') : null,
            'toDate'         => $this->toDate ? $this->toDate->format('Y-m-d') : null,
            'pageSize'       => $this->pageSize,
            'page'           => $this->page,
        ]);
    }
}
