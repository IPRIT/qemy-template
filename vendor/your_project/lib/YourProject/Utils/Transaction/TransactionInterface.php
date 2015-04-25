<?php

namespace YourProject\Utils\Transaction;

interface TransactionInterface {

    function begin();
    function rollback();
    function commit();
    function isBusy();
}