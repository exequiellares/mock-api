<?php

namespace ExequielLares\MockApi\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 *
 */
class Config
{

    const CONFIG_PATH_ENABLED = 'mockapi/general/enabled';
    const CONFIG_PATH_VALIDATE_TOKEN = 'mockapi/general/validate_token';
    const CONFIG_PATH_TOKEN = 'mockapi/general/token';
    const CONFIG_PATH_GET_DISPLAY_REQUEST = 'mockapi/general/get_display_request';
    const CONFIG_PATH_POST_DISPLAY_REQUEST = 'mockapi/general/post_display_request';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {

    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return bool
     */
    public function isEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return bool
     */
    public function isTokenValidationEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_VALIDATE_TOKEN, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return string
     */
    public function getBearerToken(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_TOKEN, $scopeType, $scopeCode);
        return ($value !== null) ? (string) $value : '';
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return bool
     */
    public function isShowRequestOnGetResponseEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_GET_DISPLAY_REQUEST, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return bool
     */
    public function isShowRequestOnPostResponseEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_POST_DISPLAY_REQUEST, $scopeType, $scopeCode);
    }
}
