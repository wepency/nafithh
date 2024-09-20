<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\models;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\di\Instance;
use yii\rbac\CheckAccessInterface;
use yii\web\Cookie;

/**
 * User is the class for the `user` application component that manages the user authentication status.
 *
 * You may use [[isGuest]] to determine whether the current user is a guest or not.
 * If the user is a guest, the [[identity]] property would return `null`. Otherwise, it would
 * be an instance of [[IdentityInterface]].
 *
 * You may call various methods to change the user authentication status:
 *
 * - [[login()]]: sets the specified identity and remembers the authentication status in session and cookie;
 * - [[logout()]]: marks the user as a guest and clears the relevant information from session and cookie;
 * - [[setIdentity()]]: changes the user identity without touching session or cookie
 *   (this is best used in stateless RESTful API implementation).
 *
 * Note that User only maintains the user authentication status. It does NOT handle how to authenticate
 * a user. The logic of how to authenticate a user should be done in the class implementing [[IdentityInterface]].
 * You are also required to set [[identityClass]] with the name of this class.
 *
 * User is configured as an application component in [[\yii\web\Application]] by default.
 * You can access that instance via `Yii::$app->user`.
 *
 * You can modify its configuration by adding an array to your application config under `components`
 * as it is shown in the following example:
 *
 * ```php
 * 'user' => [
 *     'identityClass' => 'app\models\User', // User must implement the IdentityInterface
 *     'enableAutoLogin' => true,
 *     // 'loginUrl' => ['user/login'],
 *     // ...
 * ]
 * ```
 *
 * @property-read string|int $id The unique identifier for the user. If `null`, it means the user is a guest.
 * This property is read-only.
 * @property IdentityInterface|null $identity The identity object associated with the currently logged-in
 * user. `null` is returned if the user is not logged in (not authenticated).
 * @property-read bool $isGuest Whether the current user is a guest. This property is read-only.
 * @property string $returnUrl The URL that the user should be redirected to after login. Note that the type
 * of this property differs in getter and setter. See [[getReturnUrl()]] and [[setReturnUrl()]] for details.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class User extends yii\web\User
{
    public $enableAutoLogin = true;

            public $authKeyParam = '__authKey';

        public function login($identity, $duration = 0)
        {
                // print_r($this->autoRenewCookie); die();
            if ($this->beforeLogin($identity, false, $duration)) {
                $this->switchIdentity($identity, $this->autoRenewCookie ? $duration : 0);
                // $this->switchIdentity($identity, $duration);
                $id = $identity->getId();
                $ip = Yii::$app->getRequest()->getUserIP();
                Yii::info("User '$id' logged in from $ip with duration $duration.", __METHOD__);
                $this->afterLogin($identity, false, $duration);
            }
            return !$this->getIsGuest();
        }

        public function logout($destroySession = true)
    {
      $identity = $this->getIdentity();
      if ($identity !== null && $this->beforeLogout($identity)) {
       $this->switchIdentity(null);
       $id = $identity->getId();
       $ip = Yii::$app->getRequest()->getUserIP();
       Yii::info("User '$id' logged out from $ip.", __METHOD__);
       if ($destroySession) {
        Yii::$app->getSession()->destroy();
       }
       $this->afterLogout($identity);
      }
      return $this->getIsGuest();
    }


    public function switchIdentity($identity, $duration = 0)
    {
       
      //           $this->setIdentity($identity);

      //   if (!$this->enableSession) {
      //       return;
      //   }

      //   /* Ensure any existing identity cookies are removed. */
      //   if ($this->enableAutoLogin && ($this->autoRenewCookie || $identity === null)) {
      //       $this->removeIdentityCookie();
      //   }

      //   $session = Yii::$app->getSession();
      //   if (!YII_ENV_TEST) {
      //       $session->regenerateID(true);
      //   }
      //    $session->remove($this->idParam);
      //   $session->remove($this->authTimeoutParam);
      //   $session->remove($this->authKeyParam);


      //   if ($identity instanceof IdentityInterface) {
      //       $session->set($this->idParam, $identity->getId());
      //       $session->set($this->authKeyParam, $identity->getAuthKey());
      //       if ($this->authTimeout !== null) {
      //           $session->set($this->authTimeoutParam, time() + $this->authTimeout);
      //       }
      //       if ($this->absoluteAuthTimeout !== null) {
      //           $session->set($this->absoluteAuthTimeoutParam, time() + $this->absoluteAuthTimeout);
      //       }
      //       if ($this->enableAutoLogin && $duration > 0) {
      //           $this->sendIdentityCookie($identity, $duration);
      //       }
      //   }elseif ($this->enableAutoLogin) {
      //  Yii::$app->getResponse()->getCookies()->remove(new Cookie($this->identityCookie));
      // }
      $session = Yii::$app->getSession();
      if (!YII_ENV_TEST) {
       $session->regenerateID(true);
      }
      $this->setIdentity($identity);
      $session->remove($this->idParam);
      $session->remove($this->authTimeoutParam);
      if ($identity instanceof IdentityInterface) {
            $session->set($this->idParam, $identity->getId());
       if ($this->authTimeout !== null) {
        $session->set($this->authTimeoutParam, time() + $this->authTimeout);
       }
       if ($duration > 0 && $this->enableAutoLogin) {
        $this->sendIdentityCookie($identity, $duration);
       }
      } elseif ($this->enableAutoLogin) {
       Yii::$app->getResponse()->getCookies()->remove(new Cookie($this->identityCookie));
      }
    }





    protected function sendIdentityCookie($identity, $duration)
    {
        $cookie = new Cookie($this->identityCookie);
        $cookie->value = json_encode([
            $identity->getId(),
            $identity->getAuthKey(),
            $duration,
        ]);
        $cookie->expire = time() + $duration;
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }

    public function getIsGuest($checkSession = true)
    {
        return $this->getIdentity($checkSession) === null;
    }


    protected function renewAuthStatus()
    {
      $session = Yii::$app->getSession();
      $id = $session->getHasSessionId() || $session->getIsActive() ? $session->get($this->idParam) : null;
      if ($id === null) {
       $identity = null;
      } else {
       /** @var IdentityInterface $class */
       $class = $this->identityClass;
       $identity = $class::findIdentity($id);
      }
      $this->setIdentity($identity);
      if ($this->authTimeout !== null && $identity !== null) {
       $expire = $session->get($this->authTimeoutParam);
       if ($expire !== null && $expire < time()) {
        $this->logout(false);
       } else {
        $session->set($this->authTimeoutParam, time() + $this->authTimeout);
       }
      }
      if ($this->enableAutoLogin) {
       if ($this->getIsGuest()) {
        $this->loginByCookie();
       } elseif ($this->autoRenewCookie) {
        $this->renewIdentityCookie();
       }
      }
    }

    protected function loginByCookie()
    {
      $name = $this->identityCookie['name'];
      $value = Yii::$app->getRequest()->getCookies()->getValue($name);
      if ($value !== null) {
       $data = json_decode($value, true);
       if (count($data) === 3 && isset($data[0], $data[1], $data[2])) {
        list ($id, $authKey, $duration) = $data;
        /** @var IdentityInterface $class */
        $class = $this->identityClass;
        $identity = $class::findIdentity($id);
        if ($identity !== null && $identity->validateAuthKey($authKey)) {
         if ($this->beforeLogin($identity, true, $duration)) {
          $this->switchIdentity($identity, $this->autoRenewCookie ? $duration : 0);
          $ip = Yii::$app->getRequest()->getUserIP();
          Yii::info("User '$id' logged in from $ip via cookie.", __METHOD__);
          $this->afterLogin($identity, true, $duration);
         }
        } elseif ($identity !== null) {
         Yii::warning("Invalid auth key attempted for user '$id': $authKey", __METHOD__);
        }
       }
      }
    }
}
