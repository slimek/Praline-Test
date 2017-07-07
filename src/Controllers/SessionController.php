<?php
namespace Controllers;

use Models\UserInfo;
use Praline\Session\SessionManager;
use Praline\Slim\Controller;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class SessionController extends Controller
{
    /** @var  SessionManager */
    private $sessionManager;

    /** @var  LoggerInterface */
    private $logger;

    public function __construct($container)
    {
        $this->sessionManager = $container['sessionManager'];
        $this->logger = $container['logger'];
    }

    public function login(Request $request, Response $response)
    {
        $params = $request->getParsedBody();
        $this->checkParams($params, [
            'id' => static::PARAM_NUMBER,
            'name' => static::PARAM_STRING,
        ]);

        $user = new UserInfo($params['id'], $params['name']);
        $session = $this->sessionManager->newSession($user);

        $this->logger->debug(json_encode($user));

        $result = [
            'user' => $user,
            'accessToken' => $session->getNextAccessToken(),
        ];

        return $this->withJson($response, $result)
                    ->withHeader(SessionManager::NEXT_ACCESS_TOKEN_HEADER_NAME, $session->getNextAccessToken());

        // 附註：推薦以 response header 的方式將 next access token 傳回，這樣 client 的處理方式才能保持一致
    }

    public function proceed(Request $request, Response $response)
    {
        /** @var UserInfo $userInfo */
        $user = $request->getAttribute(UserInfo::ATTRIBUTE_NAME);

        $result = [
            'user' => $user,
            'time' => (new \DateTime())->format(\DateTime::ATOM),
        ];

        return $this->withJson($response, $result);
    }
}
