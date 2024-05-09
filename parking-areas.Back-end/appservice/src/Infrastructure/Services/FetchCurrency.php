<?php
namespace App\Infrastructure\Services;

use function PHPUnit\Framework\isEmpty;

class FetchCurrency implements FetchCurrencyInterface
{
    private ProviderInterface $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function fetch(array $input = []): array
    {
        $currencies = $this->provider->getContent($input);

        $currencyArr = array();

        foreach ($currencies as $currency)
        {
            if(is_array($currency))
            {
                $currencyArr[] = [
                    'usd' => $currency['USD'],
                    'pln' => $currency['PLN'],
                ];
            }
        }

        return $currencyArr;
    }
}
