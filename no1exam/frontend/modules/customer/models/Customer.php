<?php
namespace frontend\modules\customer\models;

use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;
use common\components\CommonComponent;
use frontend\modules\customer\models\Tokens;

class Customer extends ActiveRecord
{

    public $agree;

    public $new_password;

    public $confirm_password;

    public $otp;

    public static function tableName()
    {
        return 'customers';
    }

    public function rules()
    {
        return [
            [
                [
                    'phone',
                    'password'
                ],
                'required',
                'on' => 'login',
                'message' => '{attribute} is required'
            ],
            [
                [
                    'fullname',
                    'phone',
                    'password',
                    'status',
                    'created_date',
                    'agree'
                ],
                'required',
                'on' => 'account',
                'message' => '{attribute} is required'
            ],
            [
                [
                    'phone'
                ],
                'required',
                'on' => 'forgotpassword',
                'message' => '{attribute} is required'
            ],
            [
                [
                    'id',
                    'new_password',
                    'confirm_password',
                    'otp'
                ],
                'required',
                'on' => 'changepassword',
                'message' => '{attribute} is required'
            ],
            [
                [
                    'phone'
                ],
                'trim'
            ],
            [
                [
                    'email',
                    'id'
                ],
                'safe',
                'on' => 'account'
            ],
            [
                'phone',
                'string',
                'min' => 10,
                'max' => 10
            ],
            [
                'password',
                'string',
                'max' => 100
            ],
            [
                'phone',
                'isValidPhone',
                'on' => 'account'
            ],
            [
                'phone',
                'match',
                'pattern' => '/^([0-9])+$/',
                'message' => 'Invalid Phone'
            ],
            [
                'email',
                'isValidEmail',
                'on' => 'account'
            ],
            [
                'phone',
                'validatePhone',
                'on' => 'forgotpassword'
            ],
            [
                [
                    'new_password',
                    'confirm_password',
                    'otp'
                ],
                'string',
                'min' => 6,
                'max' => 6,
                'on' => 'changepassword'
            ],
            [
                [
                    'confirm_password'
                ],
                'compare',
                'compareAttribute' => 'new_password',
                'on' => 'changepassword'
            ],
            [
                'otp',
                'validateOTP',
                'on' => 'changepassword'
            ],
            [
                'agree',
                'isAgreed',
                'on' => 'account'
            ],
            [
                'email',
                'email',
                'on' => 'account'
            ]
        ];
    }

    public function scenarios()
    {
        $arrScenarios = parent::scenarios();
        $arrScenarios['login'] = [
            'phone',
            'password'
        ];
        $arrScenarios['account'] = [
            'id',
            'fullname',
            'email',
            'phone',
            'password',
            'status',
            'created_date',
            'agree'
        ];
        $arrScenarios['forgotpassword'] = [
            'phone'
        ];
        $arrScenarios['changepassword'] = [
            'otp',
            'new_password',
            'confirm_password',
            'id'
        ];
        return $arrScenarios;
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Phone Number',
            'password' => 'Password',
            'fullname' => 'Fullname',
            'email' => 'Email',
            'phone' => 'Phone',
            'status' => 'Status',
            'otp' => 'OTP',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
            'id' => 'Id'
        ];
    }

    public static function getCustomer($arrInputs = [])
    {
        $objQuery = new Query();
        $objQuery->select([
            'c.id as customer_id',
            'c.fullname',
            'c.email',
            'c.phone',
            'c.password',
            'c.status',
            'c.image'
        ]);
        $objQuery->from('customers as c');
        // Phone
        if (isset($arrInputs['phone']) && ! empty($arrInputs['phone'])) {
            $objQuery = $objQuery->andWhere('c.phone=:Phone', [
                ':Phone' => $arrInputs['phone']
            ]);
        }
        // Email
        if (isset($arrInputs['email']) && ! empty($arrInputs['email'])) {
            $objQuery = $objQuery->andWhere('c.email=:Email', [
                ':Email' => $arrInputs['email']
            ]);
        }
        // Password
        if (isset($arrInputs['password']) && ! empty($arrInputs['password'])) {
            $objQuery = $objQuery->andWhere('c.password=:Password', [
                ':Password' => $arrInputs['password']
            ]);
        }
        $arrResponse = $objQuery->all();
        return $arrResponse;
    }

    public function isValidEmail($attribute, $params)
    {
        if (! empty($this->email)) {
            $arrUser = self::getCustomer([
                'email' => $this->email,
                'id' => $this->id
            ]);
            if (! empty($arrUser)) {
                $this->addError('email', 'Email is already exists');
                return false;
            } else {
                return true;
            }
        }
    }

    public function isValidPhone($attribute, $params)
    {
        if (! empty($this->phone)) {
            $arrUser = self::getCustomer([
                'phone' => $this->phone,
                'id' => $this->id
            ]);
            if (! empty($arrUser)) {
                $this->addError('phone', 'Phone is already exists');
                return false;
            } else {
                return true;
            }
        }
    }

    public function getDefaults()
    {
        return [
            'created_date' => date("Y-m-d H:i:s")
        ];
    }

    public function validatePhone($attributes, $params)
    {
        if (! empty($this->phone)) {
            $arrUser = self::getCustomer([
                'phone' => $this->phone,
                'id' => $this->id
            ]);
            if (empty($arrUser)) {
                $this->addError('phone', 'Invalid phone number is given');
                return false;
            } else {
                return true;
            }
        }
    }

    public function validateOTP($attributes, $params)
    {
        if (! empty($this->otp)) {
            $arrToken = Tokens::getTokens([
                'customer_id' => $this->id,
                'token' => $this->otp
            ]);
            if (empty($arrToken)) {
                $this->addError('otp', 'Invalid OTP is given');
                return false;
            } else {
                return true;
            }
        }
    }

    public static function updateCustomer($arrInputs, $arrWhere)
    {
        $objConnection = Yii::$app->db;
        $intUpdate = $objConnection->createCommand()
            ->update('customers', $arrInputs, $arrWhere)
            ->execute();
        return $intUpdate;
    }

    public function isAgreed($attribute, $params)
    {
        if ($this->agree == 'true') {
            return true;
        } else {
            $this->addError('agree', 'Terms and Conditions Are Required');
            return false;
        }
    }
}
 