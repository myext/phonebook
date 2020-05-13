1. Запустить: composer install

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
      php artisan migrate    
      php artisan db:seed   
      
      
5. Apache : при настройке виртуального хоста DocumentRoot - путь_до_проекта/public   


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



