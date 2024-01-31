<?php
namespace GDO\TorChallenge;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_String;

final class Module_TorChallenge extends GDO_Module
{

    public function getUserConfig(): array
    {
        return [
            GDT_String::make('eigentor'),
        ];
    }


}
