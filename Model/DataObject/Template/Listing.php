<?php

namespace TemplateMakerBundle\Model\DataObject\Template;

use Pimcore\Model\Listing\AbstractListing;
use Pimcore\Model\Paginator\PaginateListingInterface;

class Listing extends AbstractListing implements PaginateListingInterface
{
    /**
     * List of Templates
     * @var array|null
     */
    public $data = null;

    /**
     * @var string
     */
    public string $locale;

    public function count() : int {
        return $this->getTotalCount();
    }

    /**
     * @inheritDoc
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->setOffset($offset);
        $this->setLimit($itemCountPerPage);

        return $this->load();
    }

    /**
     * Get Paginator Adapter.
     *
     * @return $this
     */
    public function getPaginatorAdapter() : self {
        return $this;
    }

    /**
     * Set Locale.
     *
     * @param string $locale
     */
    public function setLocale(string $locale) : void {
        $this->locale = $locale;
    }

    /**
     * Get Locale.
     *
     * @return string
     */
    public function getLocale() : string {
        return $this->locale;
    }

    /**
     * Rewind.
     */
    public function rewind() : void {
        $this->getData();
        reset($this->data);
    }

    /**
     * current.
     *
     * @return mixed
     */
    public function current() : mixed {
        $this->getData();

        return current($this->data);
    }

    /**
     * key.
     *
     * @return string|int|null
     */
    public function key() : string|int|null {
        $this->getData();

        return key($this->data);
    }

    /**
     * next.
     *
     * @return void
     */
    public function next() : void {
        $this->getData();
        next($this->data);
    }

    /**
     * valid.
     *
     * @return bool
     */
    public function valid() : bool {
        $this->getData();

        return $this->current() !== false;
    }
}
