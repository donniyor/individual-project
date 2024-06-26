<?php

use app\widgets\sidebar;

?>
<div class="app-sidebar">
    <div class="logo logo-sm">
        <a href="/">Опросник</a>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Основное
            </li>

            <?= sidebar::make()
                ->add('Администраторы', 'people_alt', 'admins', ['superAdmin'])
                ->add('Пройти опрос', 'done_all', 'test', ['superAdmin', 'admin'])
                ->add('Создать свой опрос', 'quiz', 'quizizz', ['superAdmin', 'admin'])
                ->add('Результаты опросов', 'check_circle', 'test-solution', ['superAdmin', 'admin'])
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