<?php
namespace GDO\TorChallenge\Method;

use GDO\Core\GDT;
use GDO\Core\Method;
use GDO\UI\GDT_Success;
use GDO\User\GDO_User;

final class Solved extends Method
{

    public function isAlwaysAllowed(): bool
    {
        return true;
    }

    public function execute(): GDT
    {
        $user = GDO_User::current();
        $code = $user->settingVar('TorChallenge', 'eigentor');
        return GDT_Success::make()->text('msg_tor_challenge_solved', [$code]);
    }
}
