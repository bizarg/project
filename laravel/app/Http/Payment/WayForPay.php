<?php
// 5168 7556 2214 2236
// 08/19
// 860
namespace App\Http\Payment;
/**
 * WayForPay
 *
 * Class WayForPay
 * @author Chenakal Serhii
 */
class WayForPay
{
    const ADDRESS_URL_WAY_FOR_PAY = "https://secure.wayforpay.com/pay";
    const ADDRES_URL_WAY_WOR_PAY_INVOICE = 'https://api.wayforpay.com/api';
    /** @var  string Идентификатор продавца. Данное значение присваивается Вам со стороны WayForPay */
    protected $merchantAccount;
    /** @var  string SecretKey торговца */
    protected $merchantSecretKey;
    /**
     * @param string $merchantAccount Идентификатор продавца. Данное значение присваивается Вам со стороны WayForPay
     * @param string $merchantSecretKey SecretKey торговца
     */
    public function __construct($merchantAccount, $merchantSecretKey)
    {
        $this->merchantAccount = $merchantAccount;
        $this->merchantSecretKey = $merchantSecretKey;
    }
    /**
     * Устанавливает: Идентификатор продавца. Данное значение присваивается Вам со стороны WayForPay
     * @param string $merchantAccount Идентификатор продавца. Данное значение присваивается Вам со стороны WayForPay
     * @return $this
     */
    public function setMerchantAccount($merchantAccount)
    {
        $this->merchantAccount = $merchantAccount;
        return $this;
    }
    /**
     * Получить: Идентификатор продавца. Данное значение присваивается Вам со стороны WayForPay
     * @return string Идентификатор продавца. Данное значение присваивается Вам со стороны WayForPay
     */
    public function getMerchantAccount()
    {
        return $this->merchantAccount;
    }
}