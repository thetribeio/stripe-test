<?php
namespace AppBundle\Services;

use Stripe\Stripe;

class StripeService
{
    /**
     * @param string $stripeSecretKey
     */
    public function __construct($stripeSecretKey)
    {
        Stripe::setApiKey($stripeSecretKey);
    }

    /**
     * @param string $token
     */
    public function charge($token)
    {
        $charge = \Stripe\Charge::create([
            'amount' => 4200,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);

        return $charge;
    }
}
