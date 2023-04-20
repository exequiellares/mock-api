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
    const CONFIG_PATH_ENABLE_LOG = 'mockapi/general/enable_log';
    const CONFIG_PATH_VALIDATE_TOKEN = 'mockapi/general/validate_token';
    const CONFIG_PATH_TOKEN = 'mockapi/general/token';
    const CONFIG_PATH_GET_DISPLAY_REQUEST = 'mockapi/general/get_display_request';
    const CONFIG_PATH_POST_DISPLAY_REQUEST = 'mockapi/general/post_display_request';
    const CONFIG_PATH_VALIDATE_FIELDS = 'mockapi/general/validate_fields';
    const CONFIG_PATH_FIELDS_TO_VALIDATE = 'mockapi/general/fields_to_validate';

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
    public function isLogEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLE_LOG, $scopeType, $scopeCode);
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

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return bool
     */
    public function isFieldsValidationEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_VALIDATE_FIELDS, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return array
     */
    public function getFieldsToValidate(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): array
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_FIELDS_TO_VALIDATE, $scopeType, $scopeCode);
        return empty($value) ? [] : explode(',', $value);
    }
}
