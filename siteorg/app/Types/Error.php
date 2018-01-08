<?php
namespace App\Types;

class Error
{
    const auth_key_bad = 'auth.key.bad'; // неправильный или отсутствует ключ авторизации


    const request_empty = 'request.empty'; // запрос пустой
    const request_json_error = 'request.json.error';// неправильная json строка

    const domain_required = 'domain.required';// домен обязательное поле
    const domain_length_min = 'domain.length.min';// слишком короткое имя домена
    const domain_length_max = 'domain.length.max';// слишком длинное имя домена
    const domain_name_error = 'domain.name.error';// не валидное имя домена
    const domain_user_has = 'domain.user.has';// домен принадлежит пользователю
    const domain_user_other_has = 'domain.user.other.has';// домен принадлежит другому  пользователю
    const domain_not_confirm = 'domain.not.confirm';// домен не подтвержден
    const domain_code = 'domain.code';// сайт вернул не 200 код
    const domain_screenshot_error = 'domain.screenshot.error';// ошибка получения скриншота сайта
    const domain_add_success = 'domain.add.success';// домен добавленн пользователю
    const domain_not_exist = 'domain.not.exist';// домен не найден



    const domain_id_required = 'domain.id.required';// id сайта обязательное поле
    const domain_id_not_found = 'domain.id.not.found';// id сайта не найден
    const domain_not_found = 'domain.not.found';//   сайт не найден
    const domain_confirm_error = 'domain.confirm.error';// ошибка подтверждения
    const domain_user_error = 'domain.user.error';// домен не добален пользователю


    const info_type_not_support = 'info.type.not.support';// тип данных не поддерживается

    const registrator_length_max = 'registrator.length.max';// слишком длинное имя регистратора




    const alexa_no_found = 'alexa.no.found';// не ответа с алексы

    
    const domain_expire = 'domain.expire';//домен истек

    const from_date_required = 'from.date.required';// дата обязательна
    const not_valid_date = 'not.valid.date';// дата не валидная

    const email_required = 'email.required';// email обязательное поле
    const email_not_valid = 'email.not.valid ';// email не валиден


    const name_required = 'name.required';// name обязательное поле

    const unknown_error = 'unknown.error';// тип данных не поддерживается

}