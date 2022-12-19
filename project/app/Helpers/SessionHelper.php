<?php

namespace App\Helpers;

use Egal\Core\Session\Session;
use Exception;

class SessionHelper
{
    public static function getRoles(): array
    {
        Session::getActionMessage()->getParameters();
        return Session::getUserServiceToken()->getRoles();
    }

    public static function getAuthInformation(): array
    {
        return Session::getUserServiceToken()->getAuthInformation();
    }

    public static function checkRole(string $value): bool
    {
        return in_array($value, self::getRoles());
    }

    /**
     * @throws Exception
     */
    public static function getAuthAttribute(string $value): mixed
    {
        $authInfo = self::getAuthInformation();

        if (!array_key_exists($value, $authInfo)) {
            throw new Exception('Attribute not exist.', 500);
        }
        return $authInfo[$value];
    }

    public static function getSessionAttributes(): array
    {
        return Session::getActionMessage()->getParameters()['attributes'] ?? [];
    }

    public static function getSessionId(): int|null
    {
        return Session::getActionMessage()->getParameters()['id'] ?: null;
    }

    public static function getSessionAttributesWithId(): array
    {
        $attributes = self::getSessionAttributes();
        $attributes['id'] = self::getSessionId();

        return $attributes;
    }
}
