<?php

namespace App\Models\Concerns;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

trait HasEncodedRouteKey
{
    public function getRouteKey(): mixed
    {
        return static::encodeRouteKey($this->getKey());
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        if ($field !== null && $field !== $this->getKeyName()) {
            return parent::resolveRouteBinding($value, $field);
        }

        $decodedKey = static::decodeRouteKey((string) $value);

        if ($decodedKey === null) {
            return null;
        }

        return $this->where($this->getKeyName(), $decodedKey)->first();
    }

    public static function encodeRouteKey(mixed $key): string
    {
        $encrypted = Crypt::encryptString((string) $key);

        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
    }

    public static function decodeRouteKey(string $value): ?string
    {
        $padding = strlen($value) % 4;

        if ($padding > 0) {
            $value .= str_repeat('=', 4 - $padding);
        }

        $encrypted = base64_decode(strtr($value, '-_', '+/'), true);

        if ($encrypted === false) {
            return null;
        }

        try {
            $decoded = Crypt::decryptString($encrypted);
        } catch (DecryptException) {
            return null;
        }

        return $decoded;
    }
}
