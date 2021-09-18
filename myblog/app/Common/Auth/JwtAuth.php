<?php


namespace App\Common\Auth;

use Lcobucci\JWT\Builder;
//use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use App\Common\Error\ErrorCode;
use App\Exceptions\ApiException;

/**
 * 单例 一次请求中所有出现使用jwt的地方都是一个用户
 *
 * Class JwtAuth
 * @package App\Common\Auth
 */
class JwtAuth
{
    /**
     * jwt token
     * @var
     */
    private $token;

    /**
     * claim iss
     * @var string
     */
    private $iss = 'api.test.com';

    /**
     * claim aud
     * @var string
     */
    private $aud = 'my_server_app';

    /**
     * claim uid
     * @var
     */
    private $uid;

    /**
     * secrect
     * @var string
     */
    private $secrect = '$32fadgaeagaefag';

    /**
     * decode token
     * @var
     */
    private $decodeToken;

    /**
     * 单例模式 jwtAuth句柄
     * @var
     */
    private static $instance;

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    /**
     * 获取token
     * @return string
     */
    public function getToken()
    {
        return (string)$this->token;
    }

    /**
     * 设置token
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * uid
     * @param $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    public function getUid()
    {
        return $this->uid;
    }

    /**
     * 编码jwt token
     * @return $this
     */
    public function encode()
    {
        $time = time();
        $this->token = (new Builder())->setHeader('alg', 'Sha256')
            ->setIssuer($this->iss)
            ->setAudience($this->aud)
            ->setIssuedAt($time)
            ->setExpiration($time + 3600)
            ->set('uid', $this->uid)
            ->sign(new Sha256(), $this->secrect)
            ->getToken();

        return $this;
    }

    /**
     * parse string token
     * @return \Lcobucci\JWT\Token
     */
    public function decode()
    {
        if (!$this->decodeToken) {
            try {
                $this->decodeToken = (new Parser())->parse((string)$this->token);
            } catch (\Exception $exception) {
                throw new ApiException(ErrorCode::ERR_TOKEN);
            }

            $this->uid = $this->decodeToken->getClaim('uid');
        }

        return $this->decodeToken;
    }

    /**
     * verify
     * @return bool
     */
    public function verify()
    {
        $result = $this->decode()->verify(new Sha256(), $this->secrect);

        return $result;
    }

    /**
     * validate
     * @return bool
     */
    public function validate()
    {
        $data = new ValidationData();
        $data->setIssuer($this->iss);
        $data->setAudience($this->aud);

        return $this->decode()->validate($data);
    }
}