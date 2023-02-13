### Запуск проекта для локальной разработки

1) docker-compose build
2) docker-compose up -d
3) sh fill_wiremock.sh - мокаем заглушки ServiceOne

### Функционирующие методы: 

GET http://localhost/service/one/settings - получение настроек сервиса "ServiceOne"


PUT http://localhost/service/one/settings - обновление настроек сервиса "ServiceOne"
BODY:
{
    "field1": "field",
    "field2": false,
    "field3": [
    "field3.one",
    "field3.two",
    "field3.two"
    ]   
}

