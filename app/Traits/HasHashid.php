<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids as HashidsManager;

trait HasHashid
{
    /**
     * Override: get the value used for hashid encoding.
     * Override this in models with non-numeric primary keys.
     */
    public function getHashidSource(): int|string
    {
        return $this->getKey();
    }

    /**
     * Override route binding to decode hashid.
     * Laravel calls this when resolving {model} in routes.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        // Try to decode hashid → get original ID
        $decoded = HashidsManager::decode($value);

        if (!empty($decoded)) {
            $value = $decoded[0];

            // If primary key is string (like user_id = "000001"), format with leading zeros
            if ($this->keyType === 'string' && is_int($value)) {
                // Use 6-digit padding (matches user_id format)
                $value = str_pad($value, (int) config('cpital.generated_user_id_length', 6), '0', STR_PAD_LEFT);
            }
        }

        return parent::resolveRouteBinding($value, $field);
    }

    /**
     * Override: return hashid as route key.
     * This makes route('admin.users.edit', $user) generate /admin/users/aB3xK7/edit
     */
    public function getRouteKey(): string
    {
        return $this->hashid;
    }

    /**
     * Encode this model's key for URL display.
     * Usage: $user->hashid  (in blade: {{ $user->hashid }})
     */
    public function getHashidAttribute(): string
    {
        return HashidsManager::encode((int) $this->getHashidSource());
    }

    /**
     * Static helper: encode an ID.
     * Usage: User::hashId(1) → "aB3xK7yz"
     */
    public static function hashId(int|string $id): string
    {
        return HashidsManager::encode((int) $id);
    }

    /**
     * Static helper: decode a hashid.
     * Usage: User::unhashId("aB3xK7yz") → 1
     */
    public static function unhashId(string $hash): int|null
    {
        $decoded = HashidsManager::decode($hash);
        return !empty($decoded) ? $decoded[0] : null;
    }
}
