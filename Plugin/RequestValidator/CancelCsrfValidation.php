<?php
declare(strict_types = 1);

namespace ExequielLares\MockAPi\Plugin\RequestValidator;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\CsrfValidator;
use Magento\Framework\App\RequestInterface;

/**
 * @see \Magento\Framework\App\Request\CsrfValidator
 */
class CancelCsrfValidation
{
    /**
     * @see \Magento\Framework\App\Request\CsrfValidator::validate
     */
    public function aroundValidate(
        CsrfValidator $subject,
        callable $proceed,
        RequestInterface $request,
        ActionInterface $action
    ): void {
        if ($request->getModuleName() == 'mockapi') {
            // No CSRF validation
            return;
        }
        $proceed($request, $action);
    }
}
