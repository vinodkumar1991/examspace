<?php
namespace app\modules\customer\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Session;
use yii\helpers\Json;
use frontend\modules\customer\models\Customer;
use common\components\CommonComponent;
use frontend\modules\customer\models\Tokens;

class CustomerController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionAccount()
    {
        return $this->render('/account', []);
    }

    public function actionCreateAccount()
    {
        $arrResponse = [];
        $arrInputs = Yii::$app->request->post();
        if (! empty($arrInputs)) {
            $objCustomer = new Customer();
            $objCustomer->scenario = 'account';
            $arrInputs = array_merge($arrInputs, $objCustomer->getDefaults());
            $objCustomer->attributes = $arrInputs;
            if ($objCustomer->validate()) {
                $objCustomer->password = Yii::$app->getSecurity()->generatePasswordHash($objCustomer->getAttribute('password'));
                $objCustomer->save();
                $arrResponse['customer_id'] = $objCustomer->id;
                $arrResponse['message'] = 'Account Created Successfully';
            } else {
                $arrResponse['errors'] = $objCustomer->errors;
            }
        }
        unset($arrInputs);
        echo Json::encode($arrResponse);
    }

    public function actionDoLogin()
    {
        $arrResponse = [];
        $arrInputs = Yii::$app->request->post();
        if (! empty($arrInputs)) {
            $objCustomer = new Customer();
            $objCustomer->scenario = 'login';
            $objCustomer->attributes = $arrInputs;
            if ($objCustomer->validate()) {
                $arrValidatedInputs = $objCustomer->getAttributes();
                $arrCustomer = Customer::getCustomer([
                    'phone' => $arrValidatedInputs['phone']
                ]);
                $arrCustomer = isset($arrCustomer[0]) ? $arrCustomer[0] : [];
                if (! empty($arrCustomer)) {
                    if (Yii::$app->getSecurity()->validatePassword($arrValidatedInputs['password'], $arrCustomer['password'])) {
                        $this->setSession($arrCustomer);
                    } else {
                        $arrResponse['errors']['password'] = [
                            'Invalid Password'
                        ];
                    }
                } else {
                    $arrResponse['errors']['phone'] = [
                        'Invalid Phone'
                    ];
                    $arrResponse['errors']['password'] = [
                        'Invalid Password'
                    ];
                }
            } else {
                $arrResponse['errors'] = $objCustomer->errors;
            }
        }
        echo Json::encode($arrResponse);
    }

    private function setSession($arrCustomer)
    {
        $objSession = Yii::$app->session;
        $arrSessionData = [
            'fullname' => $arrCustomer['fullname'],
            'email' => $arrCustomer['email'],
            'phone' => $arrCustomer['phone'],
            'image' => $arrCustomer['image'],
            'player_id' => $arrCustomer['customer_id']
        ];
        $objSession['player_data'] = $arrSessionData;
        unset($arrCustomer, $arrSessionData);
        return true;
    }

    public function actionLogout()
    {
        $objSession = Yii::$app->session;
        $objSession->remove('player_data');
        $this->redirect(Yii::getAlias('@web') . '/home');
    }

    public function actionGenerateOtp()
    {
        $arrResponse = [];
        $arrInputs = Yii::$app->request->post();
        if (! empty($arrInputs)) {
            $objCustomer = new Customer();
            $objCustomer->scenario = 'forgotpassword';
            $objCustomer->attributes = $arrInputs;
            if ($objCustomer->validate()) {
                $arrValidatedInputs = $objCustomer->getAttributes();
                $arrCustomer = Customer::getCustomer([
                    'phone' => $arrValidatedInputs['phone']
                ])[0];
                $arrTokenInputs[] = [
                    'category_type' => 'forgotpassword',
                    'customer_id' => $arrCustomer['customer_id'],
                    'token' => CommonComponent::getNumberToken(6),
                    'created_date' => date('Y-m-d H:i:s')
                ];
                // Send Token To MSG91 :: Need to implement
                $arrResponse['token_id'] = Tokens::create($arrTokenInputs);
                $arrResponse['customer_id'] = $arrCustomer['customer_id'];
                $arrResponse['message'] = 'Token sent successfully to your mobile number';
            } else {
                $arrResponse['errors'] = $objCustomer->errors;
            }
        }
        echo Json::encode($arrResponse);
        exit();
    }

    public function actionChangePassword()
    {
        $arrResponse = [];
        $arrInputs = Yii::$app->request->post();
        if (! empty($arrInputs)) {
            $objCustomer = new Customer();
            $objCustomer->scenario = 'changepassword';
            $objCustomer->attributes = $arrInputs;
            if ($objCustomer->validate()) {
                $arrValidatedInputs = $arrInputs;
                $arrValidatedInputs['password'] = Yii::$app->getSecurity()->generatePasswordHash($arrValidatedInputs['new_password']);
                unset($arrValidatedInputs['confirm_password'], $arrValidatedInputs['new_password'], $arrValidatedInputs['otp']);
                $arrResponse['is_updated'] = Customer::updateCustomer($arrValidatedInputs, [
                    'id' => $arrValidatedInputs['id']
                ]);
                $arrResponse['message'] = 'Password changed successfully';
                unset($arrValidatedInputs);
            } else {
                $arrResponse['errors'] = $objCustomer->errors;
            }
        }
        echo Json::encode($arrResponse);
        exit();
    }
}
