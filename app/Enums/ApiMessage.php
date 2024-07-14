<?php

namespace App\Enums;

enum ApiMessage: string
{
    case SUCCESS = 'Success';
    case ERROR = 'Error';
    case CREDITS_ADDED_SUCCESS = 'Credits added successfully.';
    case USER_BALANCE_RETRIEVED_SUCCESS = 'User balance retrieved successfully.';
    case ALL_BALANCES_RETRIEVED_SUCCESS = 'All user balances retrieved successfully.';
    case BALANCE_AT_TIME_RETRIEVED_SUCCESS = 'User balance at given time retrieved successfully.';
    case LOGIN_SUCCESS = 'Login successful.';
    case REGISTER_SUCCESS = 'Registration successful.';
    case INVALID_CREDENTIALS = 'Invalid credentials';
    case VALIDATION_FAILED = 'Validation failed';
    case ADD_CREDITS_FAILED = 'Failed to add credits';
    case RETRIEVE_USER_BALANCE_FAILED = 'Failed to retrieve user balance';
    case RETRIEVE_ALL_BALANCES_FAILED = 'Failed to retrieve all balances';
    case RETRIEVE_BALANCE_AT_TIME_FAILED = 'Failed to retrieve balance at given time';
    case TRANSFER_SUCCESS = 'Transfer successful.';
    case INSUFFICIENT_BALANCE = 'Insufficient balance.';
}
