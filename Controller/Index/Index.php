<?php

namespace ExequielLares\MockApi\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use ExequielLares\MockApi\Model\Config;
use Psr\Log\LoggerInterface;

/**
 *
 */
class Index implements ActionInterface, HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var null|string
     */
    private ?string $token = null;

    /**
     * @var array
     */
    private $errorFields = [];

    /**
     * @param RequestInterface $request
     * @param JsonFactory $jsonFactory
     * @param ForwardFactory $forwardFactory
     * @param Config $config
     * @param LoggerInterface $logger
     */
    public function __construct(
        private RequestInterface $request,
        private JsonFactory $jsonFactory,
        private ForwardFactory $forwardFactory,
        private Config $config,
        private LoggerInterface $logger
    )
    {
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $forward = $this->forwardFactory->create();
        if ($this->config->isEnabled()) {
            if ($this->config->isTokenValidationEnabled()) {
                if (!$this->validateToken()) {
                    return $this->getNotAuthorizedResponse();
                }
            }

            if ($this->config->isLogEnabled()) {
                $this->logger->info(print_r($this->getJSONRequestBody(), true));
            }

            if ($this->config->isFieldsValidationEnabled()) {
                if (!$this->validateJsonRequest()) {
                    return $this->getNotValidFieldResponse();
                }
            }

            if ($this->request->isGet()) {
                return $this->getGetResponse();
            }
            if ($this->request->isPost())
            {
                return $this->getPostResponse();
            }
        }
        return $forward->forward('no-route');

    }

    /**
     * @return bool
     */
    private function validateToken()
    {
        $checkToken = $this->config->isTokenValidationEnabled() ? $this->config->getBearerToken() : null;
        if ($checkToken !== null) {
            return $this->getBearerToken() === $checkToken;
        }
        return !empty($this->getBearerToken());
    }

    /**
     * @return string
     */
    private function getBearerToken()
    {
        if (!$this->token) {
            $authorizationHeader = $this->request->getHeader('Authorization');
            if ($authorizationHeader && preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
                $this->token = $matches[1];
            }
        }
        return $this->token;

    }

    /**
     * @return array
     */
    private function getJSONRequestBody(): array
    {
        return !empty($this->request->getContent()) ? json_decode($this->request->getContent(), true): [];
    }

    /**
     * @return bool
     */
    private function validateJsonRequest(): bool
    {
        if (!$this->config->isFieldsValidationEnabled()) return true;

        $body = $this->getJSONRequestBody();
        $requiredFields = $this->config->getFieldsToValidate();
        $validFields = [];
        foreach (array_keys($body) as $id) {
            if (in_array($id, $requiredFields)) {
                $validFields[] = $id;
            }
        }
        $this->errorFields = array_diff($requiredFields, $validFields);
        if (!empty($this->errorFields)) {
            return false;
        }
        return true;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    private function getGetResponse()
    {
        $result = $this->jsonFactory->create();
        $responseData = [
            'success' => true,
            'type' => 'GET',
            'message' => 'Success',
        ];

        if ($this->config->isShowRequestOnGetResponseEnabled()) {
            $responseData['request'] = $this->getJSONRequestBody();
        }
        $result->setData($responseData);
        return $result;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    private function getPostResponse()
    {
        $result = $this->jsonFactory->create();
        $responseData = [
            'success' => true,
            'type' => 'POST',
            'message' => $this->config->getSuccessMessage() ?? 'Success',
        ];

        if ($this->config->isShowRequestOnPostResponseEnabled()) {
            $responseData['request'] = $this->getJSONRequestBody();
        }

        if ($this->config->isErrorForcedEnabled()) {
            $responseData['success'] = false;
            $responseData['message'] = $this->config->getErrorMessage() ?? 'An error ocurred';
        }

        $result->setData($responseData);
        return $result;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    private function getNotAuthorizedResponse()
    {
        $result = $this->jsonFactory->create();
        $responseData = [
            'status' => 'Error',
            'message' => 'Not Authorized. Invalid Token',
        ];

        $result->setData($responseData)->setHttpResponseCode(403);
        return $result;
    }

    private function getNotValidFieldResponse()
    {
        $result = $this->jsonFactory->create();
        $responseData = [
            'status' => 'Error',
            'message' => 'Missing fields: ' . join(', ', $this->errorFields),
        ];

        $result->setData($responseData)->setHttpResponseCode(400);
        return $result;
    }

}

