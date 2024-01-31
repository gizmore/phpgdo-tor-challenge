<?php
namespace GDO\TorChallenge;

use GDO\Core\GDO;
use GDO\Core\GDO_Module;
use GDO\Core\GDO_RedirectError;
use GDO\Core\GDT_Checkbox;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Token;
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
            GDT_String::make('eigentor')->initial(t('you_have_to_use_tor')),
        ];
    }

    /**
     * @throws GDO_RedirectError
     */
    public function hookTorDetected(): void
    {
        $user = GDO_User::current();
        if (!($old = $user->settingVar('TorChallenge', 'eigentor')))
        {
            $old = Random::randomKey(GDO::TOKEN_LENGTH);
            $user->saveSettingVar('TorChallenge', 'eigentor', $old);
            $href = href('TorChallenge', 'Solved');
            throw new GDO_RedirectError('msg_tor_challenge_solved', [$old], $href);
        }
    }


}
