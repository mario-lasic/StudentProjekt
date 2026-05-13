<?php

namespace StudentProjekt\Exceptions;

use Exception;

class ValidationException extends Exception
{
    private string $polje;

    public function __construct(string $polje, string $poruka)
    {
        $this->polje = $polje;
        parent::__construct("Greška u polju '$polje': $poruka");
    }

    public function getPolje(): string
    {
        return $this->polje;
    }
}