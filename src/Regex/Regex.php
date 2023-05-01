<?php

namespace Street\App\Regex;

class Regex
{
    /**
     * @var string
     */
    const ONE_SPACE_OR_MORE = '/\s+/';

    const MULTIPLE_ENTRY_SEPARATORS = "/&|and/";

    // one latter or one letter followed by dot
    const INITIAL_REGEX = '/^[A-Z]\.?$/i';

}
