CREATE USER 'yii2advanced_test'@'%';
CREATE DATABASE `yii2advanced_test` CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON yii2advanced_test.* TO 'yii2advanced_test'@'%' IDENTIFIED BY 'test_secret';
FLUSH PRIVILEGES;
