<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * Limpia y da formato a un número de teléfono.
     * Ejemplo: 51935190786@c.us → 935190786
     */
    public static function cleanPhone(?string $phone): string
    {
        if (!$phone) return '';

        $phone = preg_replace('/@.*/', '', $phone); // quita @c.us
        $phone = preg_replace('/^51/', '', $phone); // quita prefijo 51
        $phone = preg_replace('/\D/', '', $phone);  // deja solo dígitos

        return $phone;
    }
}
