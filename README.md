## Description
Reusable trait for encrypting Laravel model fields.

## Requirements

- Any fields that are encryptable need to be changed to type "text" in the database, due to the encrypted data string being much longer than the original data.
- `PHP >=7.0`
- `Laravel ~5.6`

## Installation

0. As always: back up your database - I am not responsible for any data loss

1. Install the package via Composer: 

    `composer require mike-zange/laravel-encryptable`

2. On your model add:

    ```
    use Encryptable;
    
    public $encryptable = [
        'field_1',
        'field_2',
        'field_3',
        'field_4'
    ];
    ```

The trait will take care of the rest