<?php

namespace PothenEsxes\Messages;

class Gr implements Messages
{
    protected array $messages = [
        0=>'Το αίτημα με αριθμό Α123456789012345678901 υποβλήθηκε επιτυχώς',

        99=>'Σφάλμα κατά την καταγραφή του αιτήματος',
    ];
    public function getMessageByCode(int $code)
    {
        return $this->messages[$code];
    }
}