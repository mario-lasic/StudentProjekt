<?php

namespace StudentProjekt\Exceptions;

use StudentProjekt\Models\Smjer;
use Exception;

class SmjerException extends Exception
{
    private Smjer $smjer;

    public function __construct(Smjer $smjer, string $poruka)
    {
        $this->smjer = $smjer;
        parent::__construct("Greška kod upisa studenta u {$this->smjer->getNaziv()}: $poruka");
    }

}