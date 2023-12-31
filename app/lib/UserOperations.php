<?php

namespace app\lib;

class UserOperations
{
    const RoleGuest = 'guest';
    const RoleAdmin = 'admin';
    const RoleUser = 'user';

    public static function getRoleUser()
    {
        $result = self::RoleGuest;
        if (isset($_SESSION['user']['id']) && $_SESSION['user']['is_admin']) {
            $result = self::RoleAdmin;
        } elseif (isset($_SESSION['user']['id'])) {
            $result = self::RoleUser;
        }
        return $result;
    }

    public static function getMenuLinks()
    {
        $role = self::getRoleUser();
        $list[] = [
            'title' => 'Мой профиль',
            'link' => '/user/profile'
        ];

        $list[] = [
            'title' => 'Каталог',
            'link' => '/product/list'
        ];
        $list[] = [
            'title' => 'Корзина',
            'link' => '/product/card'
        ];
        $list[] = [
            'title' => 'История',
            'link' => '/product/history'
        ];

        if ($role === self::RoleAdmin) {
            $list[] = [
                'title' => 'Глобальная история',
                'link' => '/product/global'
            ];
            $list[] = [
                'title' => 'Пользователи',
                'link' => '/user/users'
            ];
        }

        $list[] = [
            'title' => 'Выход',
            'link' => '/user/logout'
        ];

        return $list;

    }
}




