<?php

namespace ExequielLares\MockApi\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\ForwardFactory;


/**
 *
 */
class Index implements ActionInterface, HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var
     */
    private $token;

    /**
     * @param RequestInterface $request
     * @param JsonFactory $jsonFactory
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        private RequestInterface $request,
        private JsonFactory $jsonFactory,
        private ForwardFactory $forwardFactory
    )
    {
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->validateToken()) {
            return $this->getNotAuthorizedResponse();
        }
        if ($this->request->isGet()) {
            return $this->getGetResponse();
        }
        if ($this->request->isPost())
        {
            return $this->getPostResponse();
        }
        $forward = $this->forwardFactory->create();
        return $forward->forward('no-route');

    }

    /**
     * @return bool
     */
    private function validateToken()
    {
        $checkToken = null;
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
        $result->setData($responseData);
        return $result;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    private function getPostResponse()
    {
        $result = $this->jsonFactory->create();
        $jsonBody = json_decode($this->request->getContent(), true);
        $responseData = [
            'success' => true,
            'type' => 'POST',
            'message' => 'Success',
            'request' => $jsonBody,
        ];

        $result->setData($responseData);
        return $result;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    private function getNotAuthorizedResponse()
    {
        $result = $this->jsonFactory->create();
        $jsonBody = json_decode($this->request->getContent(), true);
        $responseData = [
            'status' => 'Error',
            'message' => 'Not Authorized. Invalid Token',
        ];

        $result->setData($responseData)->setHttpResponseCode(403);
        return $result;
    }

}

