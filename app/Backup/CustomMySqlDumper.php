<?php

// app/Backup/CustomMySqlDumper.php

namespace App\Backup;

use Spatie\DbDumper\Databases\MySql;

class CustomMySqlDumper extends MySql
{
    public static function create(): self
    {
        return new static();
    }
}
