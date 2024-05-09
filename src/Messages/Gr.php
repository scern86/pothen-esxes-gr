<?php

namespace PothenEsxes\Messages;

class Gr implements Messages
{
    protected array $messages = [
        0 => 'Το αίτημα με αριθμό {{REQUEST_ID}} υποβλήθηκε επιτυχώς',
        1 => 'Το αίτημα με αριθμό {{REQUEST_ID}} έχει ήδη υποβληθεί',
        3 => 'Το αίτημα με αριθμό {{REQUEST_ID}} έχει ήδη υποβληθεί και διεκπεραιωθεί',
        9 => 'Ο ΑΦΜ δεν αντιστοιχεί σε πελάτη ή δεν μπορεί να ταυτοποιηθεί το πρόσωπο',
        10 => 'Μη έγκυρη είσοδος: {{INVALID_FIELD}}',
        90 => 'Το Π.Σ. του ιδρύματος είναι προσωρινά μη διαθέσιμο για λόγους προγραμματισμένης συντήρησης',
        99 => 'Σφάλμα κατά την καταγραφή του αιτήματος',
    ];

    const AITHMA_FIELDS_ERRORS = [
        'requestIDEmpty'=>'ο αριθμός αιτήματος είναι κενός',
        'requestIDInvalid'=>'request id invalid',/* no status */
        'requestTypeEmpty'=>'ο τύπος αιτήματος είναι κενός',
        'requestTypeInvalid'=>'ο τύπος αιτήματος δεν είναι έγκυρος (όχι 1 ή 2)',
        'afmEmpty'=>'ο ΑΦΜ είναι κενός',
        'afmInvalid'=>'ο ΑΦΜ δεν είναι αλγοριθμικά έγκυρος',
        'nameEmpty'=>'το όνομα είναι κενό',
        'surnameEmpty'=>'το επώνυμο είναι κενό',
        'birthDateEmpty'=>'η ημερομηνία γέννησης είναι κενή',
        'birthDateInvalid'=>'η ημερομηνία γέννησης δεν είναι έγκυρη (μη έγκυρο format ή ημερομηνία που δεν υφίσταται)',
        'referenceDateEmpty'=>'η ημερομηνία αναφοράς δεδομένων είναι κενή',
        'referenceDateInvalid'=>'η ημερομηνία αναφοράς δεδομένων δεν είναι έγκυρη',
        'referenceDateFuture'=>'η ημερομηνία αναφοράς δεδομένων είναι μελλοντική',
    ];

    public function getMessageByCode(int $code, array $replaces = []): string
    {
        $result = '';
        if(isset($this->messages[$code])) {
            $result = $this->messages[$code];
            if(!empty($replaces)){
                foreach ($replaces as $key => $value) {
                    $result = preg_replace('/{{'.strtoupper($key).'}}/',$value,$result);
                }
            }
        }
        return $result;
    }
}