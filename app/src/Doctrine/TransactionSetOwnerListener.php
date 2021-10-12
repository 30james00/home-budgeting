<?php

namespace App\Doctrine;

use App\Entity\Transaction;
use Symfony\Component\Security\Core\Security;

class TransactionSetOwnerListener
{
    private Security $security;

    public function __construct(Security $security)
    {

        $this->security = $security;
    }

    public function prePersist(Transaction $transaction)
    {
        if ($this->security->getUser()) {
            $transaction->setMadeBy($this->security->getUser());
        }
    }
}