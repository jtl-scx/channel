<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/07
 */

namespace JTL\SCX\Channel;

class SignUpController
{
    public function signUp(string $username, string $password): bool
    {
        if ($username === 'test' && $password === 'foo') {
            return true;
        }

        return false;
    }
}
