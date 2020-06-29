<?php

namespace Vatlayer;

use GuzzleHttp\Client;
use Vatlayer\Exceptions\RequestFailed;

class Vatlayer
{
    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * Vatlayer constructor.
     *
     * @param  \GuzzleHttp\Client  $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Validate the given VAT number.
     *
     * @param  string  $vatNumber
     * @param  int  $format
     * @return array|null
     */
    public function validate(string $vatNumber, int $format = 1): array
    {
        $url = $this->buildUrl('validate', [
            'vat_number' => $vatNumber,
            'format' => $format,
        ]);

        return $this->execute($url);
    }

    /**
     * Determines if the given VAT number is valid.
     *
     * @param  string  $vatNumber
     * @return bool
     */
    public function isValidVatNumber(string $vatNumber): bool
    {
        try {
            $response = $this->validate($vatNumber);
        } catch (\Exception $e) {
            return false;
        }

        return boolval(data_get($response, 'valid', false));
    }

    /**
     * Execute the API request for the given URL and parse the results.
     *
     * @param  string  $url
     * @return mixed
     *
     * @throws \Vatlayer\Exceptions\RequestFailed
     */
    protected function execute(string $url)
    {
        $response = $this->httpClient->get($url);

        $attributes = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200) {
            if (data_get($attributes, 'success', true) === false) {
                throw new RequestFailed(data_get($attributes, 'error.code'), data_get($attributes, 'error.info'));
            }

            return $attributes;
        }

        throw new RequestFailed($response->getStatusCode(), $response->getReasonPhrase());
    }

    /**
     * Build the URL which needs to be called.
     *
     * @param  string  $action
     * @param  array  $parameters
     * @return string
     */
    protected function buildUrl($action, $parameters): string
    {
        $parameters['access_key'] = config('services.vatlayer.key');

        $encrypted = boolval(config('services.vatlayer.encrypted', false));

        return sprintf(
            '%s://apilayer.net/api/%s?%s',
            $encrypted ? 'https' : 'http',
            $action,
            http_build_query($parameters)
        );
    }
}
