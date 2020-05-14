1. Запустить: ```composer install```

2. Создать БД


3. Заполнить раздел БД в .env.example и переименовать в .env
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=phonebook
    DB_USERNAME=root
    DB_PASSWORD=zzzzgggg     
    
    ```    
    
4. Из корня проекта запустить     

      ```php artisan migrate```    
      ```php artisan db:seed```    
      
      
      
5. Apache : при настройке виртуального хоста     
   DocumentRoot :  путь_до_проекта/public   


6. API

 **GET**  http://ваш_домен/api/user  - получить все записи 
   
   Пример ответа 

```json    
    {"errors": false,   
       "data": [    
           {
               "id": 1,
               "name": "Иван",
               "surname": "Иванов",
               "patronymic": "Иванович",
               "phones": [
                   {
                       "id": 1,
                       "number": 111111111111,
                       "is_mobile": 1
                   },
                   {
                       "id": 2,
                       "number": 222222222222,
                       "is_mobile": 0
                   }
               ]
           },
           {
               "id": 9,
               "name": "Иван",
               "surname": "Иванов",
               "patronymic": "Юрьевич",
               "phones": [
                   {
                       "id": 11,
                       "number": 131457411172,
                       "is_mobile": 1
                   },
                   {
                       "id": 12,
                       "number": 933515336813,
                       "is_mobile": 0
                   }
               ]
           }
       ]
   }
```


**GET**  http://ваш_домен/api/user/1 - получить запись по id
   
   Пример ответа

```json
   {
       "errors": false,
       "data": [
           {
               "id": 9,
               "name": "Иван",
               "surname": "Иванов",
               "patronymic": "Юрьевич",
               "phones": [
                   {
                       "id": 11,
                       "number": 131457411172,
                       "is_mobile": 1
                   },
                   {
                       "id": 12,
                       "number": 933515336813,
                       "is_mobile": 0
                   }
               ]
           }
       ]
   }
```
  

**GET**  http://ваш_домен/api/user/name?name=Иван&surname=Иванов&patronymic=Юрьевич
 
 Найти запись по фамилии / имени / отчеству. Допускается указание всех либо 
 нескольких переменных, например только имя ?surname=Иванов
 
 Пример ответа

```json
 {"errors": false,
     "data": [
         {
             "id": 5,
             "name": "Иван",
             "surname": "Иванов",
             "patronymic": "Юрьевич",
             "phones": [
                 {
                     "id": 3,
                     "number": 111111111115,
                     "is_mobile": 1
                 },
                 {
                     "id": 4,
                     "number": 333333333333,
                     "is_mobile": 0
                 }
             ]
         }
     ]
 }  
```
 
 **GET**  http://ваш_домен/api/user/phone/131457411172
 
 Получить запись по номеру телефона ( допустимая длинна номера 10 - 12 знаков )
 
 Пример ответа 


 ```json
 {
     "errors": false,
     "data": [
         {
             "id": 9,
             "name": "Иван",
             "surname": "Иванов",
             "patronymic": "Юрьевич",
             "phones": [
                 {
                     "id": 11,
                     "number": 131457411172,
                     "is_mobile": 1
                 },
                 {
                     "id": 12,
                     "number": 933515336813,
                     "is_mobile": 0
                 }
             ]
         }
     ]
 }
 ```
  
 
   
**POST**  http://ваш_домен/api/user - создать запись. ( Символ "/" в конце URL недопустим )
 
 Номер телефона проверяется на уникальность
  
  Пример запроса

 ```json
  {
      "name": "Иван",
      "surname": "Иванов",
      "patronymic": "Юрьевич",
      "phones": [
          {
              "number": 131457461172,
              "is_mobile": 1
          },
          {
              "number": 933545336813,
              "is_mobile": 0
          }
      ]
  } 
  ```

  
  Пример ответа
  

```json
  {
      "errors": false,
      "data": [
          {
              "id": 12,
              "name": "Иван",
              "surname": "Иванов",
              "patronymic": "Юрьевич",
              "phones": [
                  {
                      "id": 30,
                      "number": 131457461172,
                      "is_mobile": 1
                  },
                  {
                      "id": 31,
                      "number": 933545336813,
                      "is_mobile": 0
                  }
              ]
          }
      ]
  }
  ```
  
  
  

**DELETE** http://ваш_домен/api/user/9  удалить запись

Пример ответа


```json    
{
    "errors": false,
    "data": [
        {
            "id": "9"
        }
    ]
}
```



**PUT** http://ваш_домен/api/user редактировать запись. ( Символ "/" в конце URL недопустим )

Пример запроса


```json    
{
    "id": 10,
    "name": "Иван",
    "surname": "Иванович",
    "patronymic": "Юрьевич",
    "phones": [
        {
            "number": 111111111199,
            "is_mobile": 0
        }
]
}
```
Пример ответа    


```json    
    {
    "errors": false,
    "data": [
        {
            "id": 10,
            "name": "Иван",
            "surname": "Иванович",
            "patronymic": "Юрьевич",
            "phones": [
                {
                    "id": 27,
                    "number": 111111111199,
                    "is_mobile": 0
                }
            ]
        }
    ]
    }
```    
    
**Погода**    

Сервис рассчитан на отображение прогноза на 5 дней. Погода обновляется каждые 30 мин.    
В файле   ```config/weather.php```   указать название города и его id ( текущие настройки для Минска ).    
Также указать ключ полученный от openweathermap.org. Для автоматического обновления добавить    
задачу в corn. ```$crontab -e```    и добавить запись    
```***** php /путь/до/файла/artisan shedule:run >>/dev/null 2>&1```   
Для "ручного" обновления погоды запустить из корня проекта     
```php artisan weather:get```    
Получить данные с локального сервкра     

**GET**  http://ваш_домен/api/weather/2020/05/15      

Пример ответа    
```{
    "errors": false,
    "data": [
        {
            "id": 1589587200,
            "city_id": 625144,
            "temperature": "4.51",
            "wind_speed": "2.74",
            "condition_weather": "ясно",
            "icon": "01n",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 00:00:00"
        },
        {
            "id": 1589598000,
            "city_id": 625144,
            "temperature": "4.1",
            "wind_speed": "2.2",
            "condition_weather": "переменная облачность",
            "icon": "03d",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 03:00:00"
        },
        {
            "id": 1589608800,
            "city_id": 625144,
            "temperature": "9.25",
            "wind_speed": "6.22",
            "condition_weather": "переменная облачность",
            "icon": "03d",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 06:00:00"
        },
        {
            "id": 1589619600,
            "city_id": 625144,
            "temperature": "10.4",
            "wind_speed": "7.57",
            "condition_weather": "небольшой дождь",
            "icon": "10d",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 09:00:00"
        },
        {
            "id": 1589630400,
            "city_id": 625144,
            "temperature": "11.55",
            "wind_speed": "8.76",
            "condition_weather": "небольшой дождь",
            "icon": "10d",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 12:00:00"
        },
        {
            "id": 1589641200,
            "city_id": 625144,
            "temperature": "10.92",
            "wind_speed": "8.21",
            "condition_weather": "небольшой дождь",
            "icon": "10d",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 15:00:00"
        },
        {
            "id": 1589652000,
            "city_id": 625144,
            "temperature": "7.26",
            "wind_speed": "5.16",
            "condition_weather": "переменная облачность",
            "icon": "03d",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 18:00:00"
        },
        {
            "id": 1589662800,
            "city_id": 625144,
            "temperature": "5.88",
            "wind_speed": "5.98",
            "condition_weather": "переменная облачность",
            "icon": "03n",
            "created_at": "2020-05-14T20:39:34.000000Z",
            "updated_at": "2020-05-14T20:39:34.000000Z",
            "city_name": "Минск",
            "time": "2020/05/16 21:00:00"
        }
    ]
}    
```

    
    



