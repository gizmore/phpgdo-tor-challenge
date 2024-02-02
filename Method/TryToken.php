<?php
namespace GDO\TorChallenge\Method;

use GDO\Core\GDO_ArgError;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Token;
use GDO\Core\GDT_UInt;
use GDO\Core\MethodAjax;
use GDO\User\GDO_User;
use GDO\User\GDO_UserSetting;

final class TryToken extends MethodAjax
{

    public function gdoParameters(): array
    {
        return [
            GDT_Token::make('token')->notNull(),
        ];
    }

    /**
     * @throws GDO_DBException
     * @throws GDO_ArgError
     */
    public function execute(): GDT
    {
        $result = 0;
        $token = $this->gdoParameterVar('token');
        $user = GDO_UserSetting::table()->select('uset_user_t.*')->
            joinObject('uset_user')->
            fetchTable(GDO_User::table())->
            where("uset_name='eigentor' AND uset_var='$token'")->
            first()->exec()->fetchObject();
        if ($user)
        {
            /**
             * @var GDO_User $user
             */
            if ($user->settingVar('TorChallenge', 'eigentor_solved'))
            {
                $result = 2;
            }
            else
            {
                $user->saveSettingVar('TorChallenge','eigentor_solved', '1');
                $result = 1;
            }
        }
        return GDT_UInt::make('status')->initial((string)$result);
    }

}
