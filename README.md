# Гостевая книга

Проект гостевой книги на Laravel Framework. Позволяет оставлять записи с прикрепленными изображениями.

Основные возможности:
* **Добавление записей.** Записи может оставлять любой посетитель сайта. Защита от роботов с помощью Google 
Recaptcha. К записям можно прикреплять изображения;
* **Просмотр существующих записей.** Вывод всех оставленных записей в книге на главной странице с 
постраничной разбивкой. Изображения выводятся в виде галереи на Lightbox;
* **Регистрация.** Приложение поддерживает регистрацию. Зарегистрированный пользователь может редактировать 
(в том числе добавлять и удалять изображения) и удалять свои записи, а также выбирать количество записей, 
отображаемых на страницу в постраничной разбивке;
* **Отправка уведомлений о новых записях.** При желании, можно включить уведомления для администратора 
системы о новых записях в гостевой книге.

## Развертывание приложения

Так как приложение написано на [Laravel Framework](https://laravel.com/), нужно выполнить ряд требований 
для подготовки среды, в которой оно будет выполняться. Подробнее о требованиях к серверу можно прочитать 
[тут](https://laravel.com/docs/7.x#server-requirements). Там же описаны настройки веб-сервера для 
отображения "красивых" URL. Помимо указанных расширений для PHP, на сервере должно быть установлено 
расширение [GD](https://www.php.net/manual/ru/book.image.php). С его помощью создаются миниатюры для 
загружаемых изображений.

Далее нужно установить СУБД, так как в ней приложение хранит свои данные. Список поддерживаемых СУБД 
можно найти [тут](https://laravel.com/docs/7.x/database#introduction).

Для получения проекта из системы контроля версий и установки зависимостей, нужно чтобы на сервере были 
установлены [Git](https://git-scm.com/) и [Composer](https://getcomposer.org/doc/00-intro.md#system-requirements).

После этого можно приступить к развертыванию приложения. Оно включает следующие шаги:
* Клонировать проект из git-репозитория (либо загрузить его) - 
`git clone https://github.com/Nikita-C47/gb.git`;
* Перейти в корневую директорию проекта;
* Установить зависимости (фреймворк и вспомогательные библиотеки) с помощью Composer - 
`composer install`.

## Конфигурация приложения

После того как исходный код приложения развернут, нужно заняться его конфигурацией. В проекте присутствует 
файл .env.example, на основе которого можно заполнить конфигурацию приложения. Сохраните его под названием 
.env и заполните в файле .env следующие параметры (подробнее о заполнении файлов такого типа написано 
[здесь](https://github.com/vlucas/phpdotenv)):
* `APP_NAME` - название приложения. Отображается, например, на верхней навигационной панели. Вы можете 
задать свое, если Вас не устраивает стандартное;
* `APP_ENV` - окружение приложения. При развертывание на рабочем сервере, нужно указать 
`production`;
* `APP_DEBUG` - включение или отключение отладки. При включенной отладке все ошибки отображаются в 
браузере. На рабочем сервере должна быть отключена;
* `APP_URL` - хост, на котором разворачивается приложение (используется, например, при генерации 
ссылок, так что важный параметр);
* `DB_CONNECTION` - используемое подключение к СУБД (список поддерживаемых СУБД можно найти выше), 
там же описано как заполнять данный параметр и все параметры, связанные с БД;
* `DB_HOST` - хост СУБД;
* `DB_PORT` - порт СУБД;
* `DB_DATABASE` - база данных приложения;
* `DB_USERNAME` - имя пользователя для подключения к СУБД (пользователь должен иметь полные права на 
базу данных);
* `DB_PASSWORD` - пароль пользователя для подключения к СУБД.

Заключительный этап - настройка Google Recaptcha. Для ее использования, необходимо 
[получить ключ и секрет](http://www.google.com/recaptcha/admin) для вашего ресурса. В проекте 
используется Recaptcha v.2 типа чекбокс. После получения этих данных, нужно указать их в переменных 
`GOOGLE_RECAPTCHA_KEY` и `GOOGLE_RECAPTCHA_SECRET` (ключ и секрет, соответственно) файла .env.

## Настройка уведомлений

Дополнительный этап - настройка уведомлений в приложении. По-умолчанию уведомления о новых записях в 
гостевой книге отключены. Если Вы хотите их включить, нужно выполнить ряд шагов. Первое 
(и самое очевидное) - настроить отправку электронной почты с сервера. Второе - установить движок 
очередей, так как уведомления отправляются отложенно. Список поддерживаемых движков можно найти 
[тут](https://laravel.com/docs/7.x/queues). Соответственно для того, чтобы задания в очереди 
обрабатывались, нужно запустить воркер. О том как это сделать читайте 
[здесь](https://laravel.com/docs/7.x/queues#running-the-queue-worker) (там же присутствует конфигурация 
для Supervisor, к примеру).

После того, как необходимое ПО установлено и настроено, нужно внести изменения в файл конфигурации .env, 
в котором необходимо указать следующие параметры:
* `QUEUE_CONNECTION` - используемый движок очередей. О поддерживаемых движках и заполнении этого 
параметра упоминалось выше. При использовании Redis, нужно будет заполнить секцию с его настройками. В 
частности переменные `REDIS_HOST`, `REDIS_PASSWORD` и `REDIS_PORT`;
* `MAIL_DRIVER` - используемый драйвер для почты. Поддерживается как обычный SMTP, так и 
[сторонние сервисы](https://laravel.com/docs/7.x/mail#configuration);
* `MAIL_HOST` - хост сервера отправки электронной почты;
* `MAIL_PORT` - порт сервера отправки электронной почты;
* `MAIL_USERNAME` - имя пользователя для сервера отправки электронной почты;
* `MAIL_PASSWORD` - пароль пользователя для сервера отправки электронной почты;
* `MAIL_ENCRYPTION` - используемое шифрование электронной почты;
* `MAIL_FROM_ADDRESS` - адрес, от которого ведется отправка сообщений;
* `MAIL_FROM_NAME` - имя, от которого ведется отправка (по-умолчанию - название приложения);
* `ENABLE_NOTIFICATIONS` - настройка, отвечающая за включение отправки уведомлений. Для включения нужно 
указать `true`, для отключения - `false`;
* `ADMIN_EMAIL` - email, на который, собственно, и будут отправляться уведомления о новых записях.

## Лицензии

Сам Laravel распространяется по лицензии [MIT](https://opensource.org/licenses/MIT), как и многие 
компоненты, входящие в этот проект. Галерея картинок к каждой записи реализована на 
[Lightbox](https://lokeshdhakar.com/projects/lightbox2/). На использование проекта не налагается 
никаких ограничений, Вы можете модифицировать и изменять его по своему усмотрению. Моей целью в нем 
было только саморазвитие и еще один проект в портфолио. По всем вопросам, связанным с проектом, 
обращайтесь на мой контактный email - nikita_c47@outlook.com.

