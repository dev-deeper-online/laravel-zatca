<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Templates;

class OpenSSLPemTemplate
{
    public function build(string $path): void
    {
        $tempKey = openssl_pkey_new([
            'private_key_type' => OPENSSL_KEYTYPE_EC,
            'curve_name' => 'secp256k1',
        ]);

        openssl_pkey_export_to_file($tempKey, $path);
    }
}
