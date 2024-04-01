<?php

use app\widgets\sidebar;

?>
<div class="app-sidebar">
    <div class="logo logo-sm">
        <a href="/">Bilim Makon Admin</a>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Основное
            </li>

            <?= sidebar::make()
                ->add('Регионы', 'place', 'regions', ['superAdmin'])
                ->add('Детскийе Сады', 'child_care', 'kindergarten', ['superAdmin'])
                ->add('Пользователи', 'account_circle', 'users', ['superAdmin'])
                ->add('Счета', 'paid', 'transactions', ['superAdmin', 'admin'], 'transactions?TransactionsSearch[payment_status]=SUCCESS')
                ->add('Обратная Связь', 'add_comment', 'feedbacks', ['superAdmin'])
                ->add('Администраторы', 'people_alt', 'admins', ['superAdmin'])
                ->all()
            ?>

            <li class="sidebar-title">
                Системное
            </li>

            <?= sidebar::make()
                ->add('Журнал событий', 'import_contacts', 'log-actions', ['superAdmin'])
                ->add('Выход', 'logout', 'auth/out')
                ->all()
            ?>

        </ul>
    </div>
</div>