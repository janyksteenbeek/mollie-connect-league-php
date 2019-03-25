<?php

namespace JanykSteenbeek\MollieConnect\OAuth2\Client\Provider\Resources;

class OrganizationAddress
{
    /**
     * @var array
     */
    protected $response;

    /**
     * Construct organization address.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Street and number of the address of the organization.`
     *
     * @return string
     */
    public function getStreetAndNumber()
    {
        return $this->response['streetAndNumber'];
    }

    /**
     * Postal code of the address of the organization.
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->response['postalCode'];
    }

    /**
     * City of the address of the organization.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->response['city'];
    }

    /**
     * Country of the address of the organization.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->response['country'];
    }

    /**
     * Return all of the address details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
