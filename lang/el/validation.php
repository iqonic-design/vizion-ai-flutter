<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Το :attribute πρέπει να γίνει αποδεκτό.',
    'accepted_if' => 'Το :attribute πρέπει να γίνει αποδεκτό όταν το :other είναι :value.',
    'active_url' => 'Το :attribute δεν είναι ένα έγκυρο URL.',
    'after' => 'Το :attribute πρέπει να είναι μια ημερομηνία μετά την :date.',
    'after_or_equal' => 'Το :attribute πρέπει να είναι μια ημερομηνία μετά ή ίση με την :date.',
    'alpha' => 'Το :attribute πρέπει να περιέχει μόνο γράμματα.',
    'alpha_dash' => 'Το :attribute πρέπει να περιέχει μόνο γράμματα, αριθμούς, παύλες και κάτω παύλες.',
    'alpha_num' => 'Το :attribute πρέπει να περιέχει μόνο γράμματα και αριθμούς.',
    'array' => 'Το :attribute πρέπει να είναι ένας πίνακας.',
    'before' => 'Το :attribute πρέπει να είναι μια ημερομηνία πριν από την :date.',
    'before_or_equal' => 'Το :attribute πρέπει να είναι μια ημερομηνία πριν ή ίση με την :date.',
    'between' => [
        'array' => 'Το :attribute πρέπει να έχει μεταξύ :min και :max στοιχεία.',
        'file' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max κιλομπάιτ.',
        'numeric' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max.',
        'string' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max χαρακτήρες.',
    ],
    'boolean' => 'Το πεδίο :attribute πρέπει να είναι αληθές ή ψευδές.',
    'confirmed' => 'Η επιβεβαίωση του :attribute δεν ταιριάζει.',
    'current_password' => 'Ο κωδικός πρόσβασης είναι εσφαλμένος.',
    'date' => 'Το :attribute δεν είναι μια έγκυρη ημερομηνία.',
    'date_equals' => 'Το :attribute πρέπει να είναι μια ημερομηνία ίση με την :date.',
    'date_format' => 'Το :attribute δεν ταιριάζει με τη μορφή :format.',
    'declined' => 'Το :attribute πρέπει να απορριφθεί.',
    'declined_if' => 'Το :attribute πρέπει να απορριφθεί όταν το :other είναι :value.',
    'different' => 'Το :attribute και το :other πρέπει να είναι διαφορετικά.',
    'digits' => 'Το :attribute πρέπει να είναι :digits ψηφία.',
    'digits_between' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max ψηφία.',
    'dimensions' => 'Το :attribute έχει μη έγκυρες διαστάσεις εικόνας.',
    'distinct' => 'Το πεδίο :attribute έχει διπλή τιμή.',
    'email' => 'Το :attribute πρέπει να είναι μια έγκυρη διεύθυνση email.',
    'ends_with' => 'Το :attribute πρέπει να τελειώνει με ένα από τα ακόλουθα: :values.',
    'enum' => 'Η επιλεγμένη τιμή :attribute δεν είναι έγκυρη.',
    'exists' => 'Η επιλεγμένη τιμή :attribute δεν είναι έγκυρη.',
    'file' => 'Το :attribute πρέπει να είναι ένα αρχείο.',
    'filled' => 'Το πεδίο :attribute πρέπει να έχει μια τιμή.',
    'gt' => [
        'array' => 'Το :attribute πρέπει να έχει περισσότερα από :value στοιχεία.',
        'file' => 'Το :attribute πρέπει να είναι μεγαλύτερο από :value κιλομπάιτ.',
        'numeric' => 'Το :attribute πρέπει να είναι μεγαλύτερο από :value.',
        'string' => 'Το :attribute πρέπει να είναι μεγαλύτερο από :value χαρακτήρες.',
    ],
    'gte' => [
        'array' => 'Το :attribute πρέπει να έχει :value στοιχεία ή περισσότερα.',
        'file' => 'Το :attribute πρέπει να είναι τουλάχιστον :value κιλομπάιτ.',
        'numeric' => 'Το :attribute πρέπει να είναι τουλάχιστον :value.',
        'string' => 'Το :attribute πρέπει να έχει τουλάχιστον :value χαρακτήρες.',
    ],
    'image' => 'Το :attribute πρέπει να είναι μια εικόνα.',
    'in' => 'Η επιλεγμένη τιμή :attribute δεν είναι έγκυρη.',
    'in_array' => 'Το πεδίο :attribute δεν υπάρχει στο :other.',
    'integer' => 'Το :attribute πρέπει να είναι ένας ακέραιος αριθμός.',
    'ip' => 'Το :attribute πρέπει να είναι μια έγκυρη διεύθυνση IP.',
    'ipv4' => 'Το :attribute πρέπει να είναι μια έγκυρη διεύθυνση IPv4.',
    'ipv6' => 'Το :attribute πρέπει να είναι μια έγκυρη διεύθυνση IPv6.',
    'json' => 'Το :attribute πρέπει να είναι μια έγκυρη συμβολοσειρά JSON.',
    'lt' => [
        'array' => 'Το :attribute πρέπει να έχει λιγότερα από :value στοιχεία.',
        'file' => 'Το :attribute πρέπει να είναι μικρότερο από :value κιλομπάιτ.',
        'numeric' => 'Το :attribute πρέπει να είναι μικρότερο από :value.',
        'string' => 'Το :attribute πρέπει να είναι μικρότερο από :value χαρακτήρες.',
    ],
    'lte' => [
        'array' => 'Το :attribute δεν πρέπει να έχει περισσότερα από :value στοιχεία.',
        'file' => 'Το :attribute πρέπει να είναι το πολύ :value κιλομπάιτ.',
        'numeric' => 'Το :attribute πρέπει να είναι το πολύ :value.',
        'string' => 'Το :attribute πρέπει να είναι το πολύ :value χαρακτήρες.',
    ],
    'mac_address' => 'Το :attribute πρέπει να είναι μια έγκυρη διεύθυνση MAC.',
    'max' => [
        'array' => 'Το :attribute δεν πρέπει να έχει περισσότερα από :max στοιχεία.',
        'file' => 'Το :attribute δεν πρέπει να είναι μεγαλύτερο από :max κιλομπάιτ.',
        'numeric' => 'Το :attribute δεν πρέπει να είναι μεγαλύτερο από :max.',
        'string' => 'Το :attribute δεν πρέπει να είναι μεγαλύτερο από :max χαρακτήρες.',
    ],
    'mimes' => 'Το :attribute πρέπει να είναι ένα αρχείο τύπου: :values.',
    'mimetypes' => 'Το :attribute πρέπει να είναι ένα αρχείο τύπου: :values.',
    'min' => [
        'array' => 'Το :attribute πρέπει να έχει τουλάχιστον :min στοιχεία.',
        'file' => 'Το :attribute πρέπει να είναι τουλάχιστον :min κιλομπάιτ.',
        'numeric' => 'Το :attribute πρέπει να είναι τουλάχιστον :min.',
        'string' => 'Το :attribute πρέπει να είναι τουλάχιστον :min χαρακτήρες.',
    ],
    'multiple_of' => 'Το :attribute πρέπει να είναι πολλαπλάσιο του :value.',
    'not_in' => 'Η επιλεγμένη τιμή :attribute δεν είναι έγκυρη.',
    'not_regex' => 'Η μορφή του :attribute δεν είναι έγκυρη.',
    'numeric' => 'Το :attribute πρέπει να είναι ένας αριθμός.',
    'present' => 'Το πεδίο :attribute πρέπει να είναι παρόν.',
    'prohibited' => 'Το πεδίο :attribute είναι απαγορευμένο.',
    'prohibited_if' => 'Το πεδίο :attribute είναι απαγορευμένο όταν το :other είναι :value.',
    'prohibited_unless' => 'Το πεδίο :attribute είναι απαγορευμένο εκτός αν το :other είναι σε :values.',
    'prohibits' => 'Το πεδίο :attribute απαγορεύει το :other να είναι παρόν.',
    'regex' => 'Η μορφή του :attribute δεν είναι έγκυρη.',
    'required' => 'Το πεδίο :attribute είναι υποχρεωτικό.',
    'required_array_keys' => 'Το πεδίο :attribute πρέπει να περιέχει κλειδιά για: :values.',
    'required_if' => 'Το πεδίο :attribute απαιτείται όταν το :other είναι :value.',
    'required_unless' => 'Το πεδίο :attribute απαιτείται εκτός αν το :other είναι σε :values.',
    'required_with' => 'Το πεδίο :attribute απαιτείται όταν το :values είναι παρόν.',
    'required_with_all' => 'Το πεδίο :attribute απαιτείται όταν τα :values είναι παρόντα.',
    'required_without' => 'Το πεδίο :attribute απαιτείται όταν το :values δεν είναι παρόν.',
    'required_without_all' => 'Το πεδίο :attribute απαιτείται όταν κανένα από τα :values δεν είναι παρόν.',
    'same' => 'Το :attribute και το :other πρέπει να ταιριάζουν.',
    'size' => [
        'array' => 'Το :attribute πρέπει να περιέχει :size στοιχεία.',
        'file' => 'Το :attribute πρέπει να είναι :size κιλομπάιτ.',
        'numeric' => 'Το :attribute πρέπει να είναι :size.',
        'string' => 'Το :attribute πρέπει να είναι :size χαρακτήρες.',
    ],
    'starts_with' => 'Το :attribute πρέπει να ξεκινά με ένα από τα ακόλουθα: :values.',
    'string' => 'Το :attribute πρέπει να είναι μια συμβολοσειρά.',
    'timezone' => 'Το :attribute πρέπει να είναι ένα έγκυρο ζώνη ώρας.',
    'unique' => 'Το :attribute έχει ήδη ληφθεί.',
    'uploaded' => 'Το :attribute απέτυχε να φορτωθεί.',
    'url' => 'Το :attribute πρέπει να είναι ένα έγκυρο URL.',
    'uuid' => 'Το :attribute πρέπει να είναι ένα έγκυρο UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
