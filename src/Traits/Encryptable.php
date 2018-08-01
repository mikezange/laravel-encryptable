<?php

namespace MikeZange\Encryptable\Traits;

use Illuminate\Contracts\Encryption\DecryptException;

trait Encryptable
{
    /**
     * @param $key
     *
     * @return string
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable)) {
            if (!empty($value)) {
                $value = $this->attemptDecryption($key, $value);
            }
        }

        return $value;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && !empty($value)) {
            $value = encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    public function attributesToArray() : array
    {
        $attributes = parent::attributesToArray();

        foreach ($this->encryptable as $key) {
            if (isset($attributes[$key]) && !empty($attributes[$key])) {
                $attributes[$key] = $this->attemptDecryption($key, $attributes[$key]);
            }
        }

        return $attributes;
    }


    private function attemptDecryption(string $field, string $value) : string
    {
        try {
            $decrypted = decrypt($value);
        } catch (DecryptException $exception) {
            app('log')->error('Encrypted data could not be decrypted properly', [
                'class' => get_class($this),
                'id' => $this->id,
                'field' => $field
            ]);

            $decrypted =  "{corrupt_data}";
        }

        return $decrypted;
    }
}
