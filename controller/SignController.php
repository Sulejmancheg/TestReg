<?php

namespace controller;

class SignController extends Controller
{
    public function actionIn()
    {
            $this->getModel()->setTemplate('sign/in');
            $this->getModel()->setTitle('Страница входа');
    }
}