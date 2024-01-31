<?php
namespace GDO\TorChallenge;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Checkbox;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Token;

final class Module_TorChallenge extends GDO_Module
{

    public function onLoadLanguage(): void
    {
        $this->loadLanguage('lang/torchallenge');
    }

    public function getDependencies(): array
    {
        return [
            'TorDetection',
        ];
    }

    public function getUserConfig(): array
    {
        return [
            GDT_String::make('eigentor')->initial(t('you_have_to_use_tor')),
            GDT_Checkbox::make('eigentor')->initial(t('you_have_to_use_tor')),
        ];
    }

    public function hookTorDetected(): void
    {
        GDT_Token::generateToken()
    }


}
