<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 24/06/18
 * Time: 1:39
 */

/**
 * Class MustAuthenticated
 * @property UserTokenModel $userToken;
 * @property UserModel $user;
 * @property AuthModel $auth;
 * @property CI_Session $session;
 * @property CI_Loader $load;
 */
class MustAuthenticated
{
    private $loginPage = 'auth/login';

    private $mustLogin = ['*'];

    private $allowGuest = [
        Login::class, Logout::class, Register::class, Password::class, Page::class, Error404::class,
        Migrate::class, Automate::class
    ];

    /**
     * Check if user is authenticated.
     *
     * @param string $loginUrl
     */
    public function checkAuth($loginUrl)
    {
        if($this->needAuthenticated()) {
            if (!AuthModel::isLoggedIn()) {
                $rememberToken = get_cookie('remember_token');

                if (empty($rememberToken)) {
                    $redirectTo = '?redirect=' . urlencode(current_url());

                    if(empty($loginUrl)) {
                        redirect($this->loginPage . $redirectTo);
                    }
                    redirect($loginUrl . $redirectTo);
                }

                $this->loginWithCookie($rememberToken, $loginUrl);
            }
        }
    }

    /**
     * Login with remember token.
     *
     * @param $rememberToken
     * @param $loginUrl
     */
    private function loginWithCookie($rememberToken, $loginUrl)
    {
        $CI = get_instance();
        $CI->load->model('UserTokenModel', 'userToken');
        $CI->load->model('UserModel', 'user');

        $email = $CI->userToken->verifyToken($rememberToken, UserTokenModel::TOKEN_REMEMBER);
        $user = $CI->user->getBy(['prv_users.email' => $email], true);
        if(empty($user)) {
            redirect($loginUrl);
        } else {
            $CI->session->set_userdata([
                'auth.id' => $user['id'],
                'auth.is_logged_in' => true,
                'auth.remember_me' => true,
                'auth.remember_token' => $rememberToken
            ]);
        }
    }

    /**
     * Find out if we need to check user session or not.
     *
     * @return bool
     */
    private function needAuthenticated()
    {
        $controller = get_class(get_instance());
        
        $mustAuthenticated = $this->mustLogin[0] == '*';
        
        if($mustAuthenticated) {
            // all controller need to be authenticated,
            // but exclude guest's controller (the blacklist controller)
            foreach ($this->allowGuest as $guestController) {
                if($controller == $guestController) {
                    $mustAuthenticated = false;
                    break;
                }
            }
        } else {
            // we specify whitelist of which controllers that we need to check
            // if user need to be authenticated
            foreach ($this->mustLogin as $restrictedController) {
                if($controller == $restrictedController) {
                    $mustAuthenticated = true;
                    break;
                }
            }
        }
        
        return $mustAuthenticated;
    }
}
