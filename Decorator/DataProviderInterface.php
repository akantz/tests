<?php

namespace src\Integration;


interface DataProviderInterface
{
    public function getResponse(array $input): array;
}