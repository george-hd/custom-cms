<?php
use \Cms\ViewHelpers\Form;

Form::create()->openForm()
    ->addAttributes([
        'method' => 'post',
        'action' => 'login',
        'id' => 'register-user-data',
    ])
    ->addLabel('Име',
        [
            'for' => 'fname',
        ])
    ->addFieldWithErrors([
        'id' => 'fname',
        'type' => 'text',
        'name' => 'fname'
    ])
    ->addLabel('Фамилия',
        [
            'for' => 'family',
        ])
    ->addFieldWithErrors([
        'id' => 'family',
        'type' => 'text',
        'name' => 'family'
    ])
    ->addLabel('Email',
        [
            'for' => 'email',
        ])
    ->addFieldWithErrors([
        'id' => 'email',
        'type' => 'email',
        'name' => 'email'
    ])
    ->addField([
        'id' => 'name',
        'type' => 'hidden',
        'name' => 'name',
        'value' => $model['name'],
    ])
    ->addField([
        'id' => 'password',
        'type' => 'hidden',
        'name' => 'password',
        'value' => $model['password'],
    ])
    ->addButton('Регистрация',
        [
            'type' => 'submit',
        ])
    ->render();