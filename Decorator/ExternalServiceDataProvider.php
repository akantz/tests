<?php

namespace src\Integration;


use src\Integration\Exception\ExternalServiceException;

class ExternalServiceDataProvider implements DataProviderInterface
{
    private $host;
    private $user;
    private $password;

    public function __construct(
        string $host,
        string $user,
        string $password
    ) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param array $input
     *
     * @throws ExternalServiceException
     *
     * @return array
     */
    public function getResponse(array $input): array
    {
        $result = [
            'Some Result from external service'
        ];

        // ....

        return $result;
    }
}