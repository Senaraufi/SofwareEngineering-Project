<?php
/**
 * Currency Service
 * 
 * References:
 * - Currency conversion implementation inspired by Money PHP library: https://github.com/moneyphp/money
 * - Exchange rate handling based on best practices from Open Exchange Rates API: https://openexchangerates.org/
 * - Error handling approach follows the robust error handling pattern implemented in Database.php
 */

namespace App\Services;

class CurrencyService {
    // Default currency is USD
    private $baseCurrency = 'USD';
    
    // Available currencies with their symbols and exchange rates (relative to USD)
    private $currencies = [
        'USD' => [
            'name' => 'US Dollar',
            'symbol' => '$',
            'rate' => 1.0
        ],
        'EUR' => [
            'name' => 'Euro',
            'symbol' => '€',
            'rate' => 0.92
        ],
        'GBP' => [
            'name' => 'British Pound',
            'symbol' => '£',
            'rate' => 0.79
        ]
    ];
    
    /**
     * Get all available currencies
     * 
     * @return array Array of available currencies
     */
    public function getAvailableCurrencies() {
        return $this->currencies;
    }
    
    /**
     * Convert amount from base currency (USD) to target currency
     * 
     * @param float $amount Amount in base currency
     * @param string $targetCurrency Target currency code (USD, EUR, GBP)
     * @return float Converted amount
     * @throws \Exception If target currency is not supported
     */
    public function convert($amount, $targetCurrency) {
        if (!isset($this->currencies[$targetCurrency])) {
            throw new \Exception("Currency not supported: $targetCurrency");
        }
        
        return $amount * $this->currencies[$targetCurrency]['rate'];
    }
    
    /**
     * Format amount in specified currency
     * 
     * @param float $amount Amount to format
     * @param string $currency Currency code (USD, EUR, GBP)
     * @return string Formatted amount with currency symbol
     * @throws \Exception If currency is not supported
     */
    public function format($amount, $currency) {
        if (!isset($this->currencies[$currency])) {
            throw new \Exception("Currency not supported: $currency");
        }
        
        $symbol = $this->currencies[$currency]['symbol'];
        return $symbol . number_format($amount, 2);
    }
    
    /**
     * Get currency symbol
     * 
     * @param string $currency Currency code (USD, EUR, GBP)
     * @return string Currency symbol
     * @throws \Exception If currency is not supported
     */
    public function getSymbol($currency) {
        if (!isset($this->currencies[$currency])) {
            throw new \Exception("Currency not supported: $currency");
        }
        
        return $this->currencies[$currency]['symbol'];
    }
    
    /**
     * Get exchange rate between two currencies
     * 
     * @param string $fromCurrency Source currency code
     * @param string $toCurrency Target currency code
     * @return float Exchange rate
     * @throws \Exception If currencies are not supported
     */
    public function getExchangeRate($fromCurrency, $toCurrency) {
        if (!isset($this->currencies[$fromCurrency])) {
            throw new \Exception("Currency not supported: $fromCurrency");
        }
        
        if (!isset($this->currencies[$toCurrency])) {
            throw new \Exception("Currency not supported: $toCurrency");
        }
        
        // Calculate exchange rate between the two currencies
        $fromRate = $this->currencies[$fromCurrency]['rate'];
        $toRate = $this->currencies[$toCurrency]['rate'];
        
        return $toRate / $fromRate;
    }
}
