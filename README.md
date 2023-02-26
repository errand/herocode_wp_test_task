# Test task for HeroCode

## How to test
- Install Wordpress
- Clone or download the repository in the root of the active theme
- Include _aleksandr_shatskikh/aleksandr_shatskikh.php in the functions.php

Note: that was the client's wish not to delive the code NOT as a plugin.

## Requirements
- Wordpress >5.6
- PHP >7.4
- npm for Guttenberg block manipulations (if needed)

## The task description:
### ЦЕЛИ
1. Зарегистрировать custom post types и custom taxonomy.
2. Создать Гутенберг блок.
3. Реализовать логику при публикации в одном custom post type. 
   
### ТЕХНИЧЕСКИЕ ПОДРОБНОСТИ

Весь код должен быть написан без использования плагинов.
   
Нужно создать новую папку в корне темы {your_name} и в нём файл {your_name}.php который будет подключён к functions.php
   
Весь ваш код должен располагаться в этой папке.
   
После завершения задания нужно данную папку скинуть Аргену в telegram в .zip

Всё что явно не указано в ТЗ - на ваше усмотрение.

Будет проверяться на WP 6.1.1, PHP 8.2 и в рандомной теме из репозитория WordPress.

### КЛЮЧЕВЫЕ ЭТАПЫ
- Зарегистрировать custom post types
- Нужно зарегистрировать 2 custom post type: “Товары” и “Наборы”. 
- Зарегистрировать custom taxonomy
- Нужно зарегистрировать 1 custom taxonomy “Бренды”, который привязан к обоим post type созданным на предыдущем шаге.
- Gutenberg block: Нужно зарегистрировать 1 gutenberg блок для post types. С одним значением для ввода стоимости товара и набора. Публикация товара
- При публикации поста в custom post type “Товары”, должна быть следующая логика:
   - Данный пост не единственный в привязанной рубрике taxonomy “Бренды”:
     - создаётся новый post в post type “Наборы”, который привязывается к
   этой-же рубрике taxonomy “Бренды”.
     - стоимость всех товаров в данной рубрике суммируется и переносится с
   дисконтом -20%.
     - название нового post “Набор {название рубрики}”.
     - шаблон контента нового post:
      “В данный набор входит:
   {списком ul перечисляется название постов привязанных к данной рубрике}”

       
## What was done

✅ Custom post types: Product and Set

✅ Custom taxonomy: Brand

✅ Custom meta field

✅ Custom Guttenberg plugin which saves meta Price field

✅ The logic when creating the Product post with Price and Brand tag triggers two things:
- ~~deleting all the previously created Sets in the same Brand term~~
- update the Set Price if Product updated or Deleted
- creating the new Set where in the Price field saves the sum of the prices of the Products in the same Brand term - 20%
  
✅ Rewrite the Set content to display the list of the Product with the same Brand term and the total price of the Products.
