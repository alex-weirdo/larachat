<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 20.12.19
 * Time: 19:43
 */
?>
@extends('errors::minimal')
@section('title', 'Сайт на техобслуживании. Приходите позже')
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Сайт на техобслуживании. Приходите позже'))
