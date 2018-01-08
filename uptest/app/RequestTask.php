<?php


namespace App;


class RequestTask
{
    /**
     * основной урл
     */
    public $mainUrl;
    /**
     * выполняемое действие
     */
    public $action;
    /**
     * id задачи
     */
    public $taskId;
    /**
     * список урлов ресурсов
     */
    public $res;

    /**
     * запросов в минуту
     */
    public $taskPerMin;
    /**
     * время работы в секундах
     */
    public $workTime;
    /**
     * время генерации отчета в секундах
     */
    public $logGenPeriod;
    /**
     * тип тест
     */
    public $type;
    /**
     * приросте интенсивности
     */
    public $intensityStep;
    /**
     * время задержки между итерациями
     */
    public $waitTime;
}