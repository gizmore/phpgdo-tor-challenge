<?php
namespace GDO\TorChallenge;

use GDO\Core\GDO;
use GDO\Core\GDO_Module;
use GDO\Core\GDO_RedirectError;
use GDO\Core\GDT;
use GDO\Core\GDT_Checkbox;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Token;
use GDO\Core\Website;
use GDO\Session\GDO_Session;
use GDO\UI\GDT_Redirect;
use GDO\UI\GDT_Success;
use GDO\User\GDO_User;
use GDO\Util\Random;

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
            GDT_String::make('eigentor'),
            GDT_Checkbox::make('eigentor_solved')->hidden()->initial('0'),
        ];
    }

    public function hookTorDetected(): void
    {
        $user = GDO_User::current();
        if ($user->isMember())
        {
            $code = $user->settingVar('TorChallenge', 'eigentor');
            if (!$code)
            {
                $old = Random::randomKey(GDO::TOKEN_LENGTH);
                $user->saveSettingVar('TorChallenge', 'eigentor', $old);
                Website::message('Eigentor', 'msg_tor_challenge_solved', [$old]);
            }
        }
    }


}
