<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptHelper extends Model
{
    use HasFactory;
    public function encrypt($plaintext) {
        $ciphertext = Crypt::encryptString($plaintext);
        return $ciphertext;
    }

    public function decrypt($ciphertext) {
        $plaintext = Crypt::decryptString($ciphertext);
        return $plaintext;
    }
}