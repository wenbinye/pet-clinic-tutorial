<?php

namespace winwin\petClinic\admin\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\security\AuthInterface;
use winwin\petClinic\admin\services\AuthProviderInterface;
use winwin\petClinic\controllers\Controller;
use winwin\support\exception\ValidationException;
use winwin\support\validation\ValidatorFactory;

class SignUpController extends Controller
{
    /**
     * @Inject()
     *
     * @var ValidatorFactory
     */
    private $validatorFactory;

    /**
     * @Inject()
     *
     * @var AuthProviderInterface
     */
    private $authProvider;

    /**
     * @Inject()
     *
     * @var AuthInterface
     */
    private $auth;

    public function logout()
    {
        $this->auth->logout();
        $this->redirect('/admin/');
    }

    public function initLoginForm()
    {
        $this->render('admin/login');
    }

    public function processLoginForm()
    {
        $params = $this->request->getParsedBody();
        $validator = $this->validatorFactory->create($params);
        $validator->rule('required', ['username', 'password']);
        try {
            if (!$validator->validate()) {
                throw new ValidationException($validator->errors());
            }
            if (!$this->authProvider->exists($params['username'])) {
                throw new ValidationException(['username' => ['用户不存在']]);
            }
            if (!$this->authProvider->verifyPassword($params['username'], $params['password'])) {
                throw new ValidationException(['password' => ['密码不匹配']]);
            }
        } catch (ValidationException $e) {
            return $this->render('admin/login', array_merge($params, [
                'errors' => $e->getErrors(),
            ]));
        }
        $this->auth->login($this->authProvider->getIdentity($params['username']));
        $this->redirect('/admin/');
    }
}
