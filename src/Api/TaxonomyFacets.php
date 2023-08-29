<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\TaxonomyFacetRequestBuilder;

/**
 * @see https://developers.autotrader.co.uk/api#taxonomy-facets
 *
 * ALL methods must provide a request parameter including one of:
 *
 * vehicleType, makeId, modelId, generationId
 */
class TaxonomyFacets extends AbstractApi
{
    /**
     * Retrieve available fuel types for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function fuelTypes(string $advertiserId, $request): array
    {
        return $this->facet('fuelTypes', $advertiserId, $request);
    }

    /**
     * Retrieve available transmission types for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function transmissionTypes(string $advertiserId, $request): array
    {
        return $this->facet('transmissionTypes', $advertiserId, $request);
    }


    /**
     * Retrieve available body types for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function bodyTypes(string $advertiserId, $request): array
    {
        return $this->facet('bodyTypes', $advertiserId, $request);
    }

    /**
     * Retrieve available trims for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function trims(string $advertiserId, $request): array
    {
        return $this->facet('trims', $advertiserId, $request);
    }

    /**
     * Retrieve available doors for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function doors(string $advertiserId, $request): array
    {
        return $this->facet('doors', $advertiserId, $request);
    }

    /**
     * Retrieve available drivetrains for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function drivetrains(string $advertiserId, $request): array
    {
        return $this->facet('drivetrains', $advertiserId, $request);
    }

    /**
     * Retrieve available body types for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function wheelbaseTypes(string $advertiserId, $request): array
    {
        return $this->facet('wheelbaseTypes', $advertiserId, $request);
    }

    /**
     * Retrieve available cab types for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function cabTypes(string $advertiserId, $request): array
    {
        return $this->facet('cabTypes', $advertiserId, $request);
    }

    /**
     * Retrieve available axle configurations for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function axleConfigurations(string $advertiserId, $request): array
    {
        return $this->facet('axleConfigurations', $advertiserId, $request);
    }

    /**
     * Retrieve available badge engine sizes for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function badgeEngineSizes(string $advertiserId, $request): array
    {
        return $this->facet('badgeEngineSizes', $advertiserId, $request);
    }

    /**
     * Retrieve available styles for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function styles(string $advertiserId, $request): array
    {
        return $this->facet('styles', $advertiserId, $request);
    }

    /**
     * Retrieve available sub styles for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function subStyles(string $advertiserId, $request): array
    {
        return $this->facet('subStyles', $advertiserId, $request);
    }

    /**
     * Retrieve available end layouts for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function endLayouts(string $advertiserId, $request): array
    {
        return $this->facet('endLayouts', $advertiserId, $request);
    }

    /**
     * Retrieve available bedroom layouts for a given set of parameters.
     *
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function bedroomLayouts(string $advertiserId, $request): array
    {
        return $this->facet('bedroomLayouts', $advertiserId, $request);
    }

    /**
     * Retrieve available facet items for a given set of parameters.
     *
     * @param string $name
     * @param string $advertiserId
     * @param array|TaxonomyFacetRequestBuilder $request
     * @return array
     */
    public function facet(string $name, string $advertiserId, $request) : array
    {
        $availableFacets = [
            'fuelTypes',
            'transmissionTypes',
            'bodyTypes',
            'trims',
            'doors',
            'drivetrains',
            'wheelbaseTypes',
            'cabTypes',
            'axleConfigurations',
            'badgeEngineSizes',
            'styles',
            'subStyles',
            'endLayouts',
            'bedroomLayouts',
        ];

        if (!in_array($name, $availableFacets)) {
            throw new \InvalidArgumentException(
                'The $name argument must be one of ' . implode(', ', $availableFacets)
            );
        }

        if (!($request instanceof TaxonomyFacetRequestBuilder)) {
            if (is_array($request)) {
                $request = TaxonomyFacetRequestBuilder::create($request);
            }

            // Throw an invalid argument exception if it's anything else.
            else {
                throw new \InvalidArgumentException(
                    'The $request argument must be an array or TaxonomyFacetRequestBuilder.'
                );
            }
        }

        $options = array_merge($request->toArray(), ['advertiserId' => $advertiserId]);

        return $this->_get('/taxonomy/' . $name, $options);
    }
}