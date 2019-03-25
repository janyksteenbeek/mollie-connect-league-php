<?php

namespace JanykSteenbeek\MollieConnect\OAuth2\Client\Provider\Resources;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MollieConnectResourceOwner implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected $response;

    /**
     * Construct resoucre owner.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Indicates the response contains a method object.
     *
     * Will always contain `organization` when requesting the resource owner from the API.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->response['resource'];
    }

    /**
     * The unique identifier of the organization method.
     *
     * @return string
     */
    public function getId()
    {
        return $this->response['id'];
    }

    /**
     * The name of the organization.
     *
     * @return string
     */
    public function getName()
    {
        return $this->response['name'];
    }

    /**
     * The preferred locale of the merchant which has been set in Mollie Dashboard.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->response['locale'];
    }

    /**
     * The address of the organization.
     *
     * @return OrganizationAddress
     */
    public function getAddress()
    {
        return new OrganizationAddress($this->response['address']);
    }

    /**
     * The organization's email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->response['email'];
    }

    /**
     * The registration number of the organization at the (local) chamber of commerce.
     *
     * @return string
     */
    public function getRegistrationNumber()
    {
        return $this->response['registrationNumber'];
    }

    /**
     * The VAT number of the organization, if based in the European Union. 
     * 
     * The VAT number has been checked with the VIES (http://ec.europa.eu/taxation_customs/vies/) by Mollie.
     *
     * @return string
     */
    public function getVatNumber()
    {
        return $this->response['vatNumber'];
    }

    /**
     * Return all of the account details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
