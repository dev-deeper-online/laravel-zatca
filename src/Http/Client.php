<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Http;

use DevDeeper\ZATCA\DTOs\HttpOptions;
use DevDeeper\ZATCA\Exceptions\InvalidBaseURLException;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use DevDeeper\ZATCA\ZATCA;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

abstract class Client
{
    public function __construct(
        protected ZATCA $zatca,
    ) {}

    /**
     * @throws InvalidModeException
     * @throws InvalidBaseURLException
     * @throws ConnectionException
     * @throws RequestException
     */
    protected function request(HttpOptions $options): array
    {
        $client = Http::baseUrl($this->zatca->getBaseURL())
            ->asJson()
            ->withHeaders(array_merge(
                [
                    'Accept-Language' => app()->getLocale(),
                    'Accept-Version' => $this->zatca->getVersion(),
                ],
                $options->headers,
            ));

        if ($options->authenticated) {
            $client = $client->withBasicAuth(
                username: $this->zatca->getBinarySecurityToken(),
                password: $this->zatca->getSecret()
            );
        }

        $response = $client->send(
            method: $options->method,
            url: $options->path,
            options: [
                'json' => $options->body,
            ]
        )->throw();

        return $response->json();
    }
}
