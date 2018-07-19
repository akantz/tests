<?php

namespace src\Integration;


use DateInterval;
use Exception;
use src\Integration\Exception\ExternalServiceException;

class ExternalServiceCacheDecorator implements DataProviderInterface
{
    private $cache;

    private $logger;

    /**
     * @var DataProviderInterface
     */
    private $internal;

    private $cacheInterval;

    public function __construct(
        DataProviderInterface $internal,
        CacheInterface $cache,
        DateInterval $cacheInterval
    ) {
        $this->internal = $internal;
        $this->cache = $cache;
        $this->cacheInterval = $cacheInterval;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array $input
     * @return array
     */
    public function getResponse(array $input): array
    {
        try {
            $result = $this->findInCache($input);

            if (false === $result) {
                $result = $this->internal->getResponse($input);
                $this->putInCache($input, $result);
            }

            return $result;
        } catch (ExternalServiceException $e) {
            $this->logger->critical(
                sprintf(
                    'External service exception: %s',
                    $e->getMessage()
                )
            );
        } catch (Exception $e) {
            $this->logger->critical(
                sprintf(
                    'Unknown exception: %s',
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * @param array $input
     * @return bool|mixed
     */
    private function findInCache(array $input)
    {
        $cacheKey = $this->createCacheKey($input);
        $cachedValue = $this->cache->get($cacheKey);

        return
            null !== $cachedValue
                ? $cachedValue
                : false
            ;
    }

    /**
     * @param array $input
     * @param $value
     */
    private function putInCache(array $input, $value)
    {
        $this->cache->set(
            $this->createCacheKey($input),
            $value,
            $this->cacheInterval
        );

    }

    /**
     * @param array $input
     * @return string
     */
    private function createCacheKey(array $input)
    {
        return sha1(json_encode($input));
    }
}