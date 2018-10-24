<?php

namespace ShawnRong\Avocado\Models;

use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthorization
{

    protected $token;

    public function __construct($token = null)
    {
        $this->token = $token;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function toArray()
    {
        $payload = $this->getPayload();

        $expiredAt        = Carbon::createFromTimestamp($payload->get('exp'))
                                  ->toDateTimeString();
        $refreshExpiredAt = Carbon::createFromTimestamp($payload->get('iat'))
                                  ->addMinutes(config('jwt.refresh_ttl'))
                                  ->toDateTimeString();

        return [
            'id'                 => hash('md5', $this->token),
            'token'              => $this->token,
            'expired_at'         => $expiredAt,
            'refresh_expired_at' => $refreshExpiredAt,
        ];
    }

    public function getPayload()
    {
        return JWTAuth::setToken($this->token)->getPayload();
    }
}
