Команды:

Command | Comment
------------ | -------------
ta-core:generate:sqlite-db | Генерация БД SQLite с сценариями
ta-core:push:test-in-db | Запись сгенерированных тестов из Sqllite в БД
ta-core:run:smoke | Отправка в Rabbitmq smoke тестов
php /var/www/bin/console rabbitmq:consumer -m 2000 run_test_by_tag | воркер запуска автотеста
---

Файлы с БД находятся: TestAutomationCoreBundle/Resource/SQLiteDB/

Файлы Feature используемые для генерации сценариев скидывать в: TestAutomationCoreBundle/Resource/FeaturesForGenerate/

 TestAutomationCoreBundle/Command/GenTestCommand.php 