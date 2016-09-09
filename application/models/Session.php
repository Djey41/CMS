<?php
namespace models;

/**
 * Class Session
 * @package models
 */
    class Session
    {
        /**
         * @var bool
         */
        private $logged_in=false;
        /**
         * using in logfile.php
         * @var
         */
        public $user_id;
        /**
         * @var
         */
        private $username;
        /**
         * @var
         */
        public $message;
        /**
         * @var
         */
        public $session;

        public function __construct()
        {
            session_start();
            $this->checkMessage();
            $this->checkLogin();
            if ($this->logged_in) {
                // actions to take right away if user is logged in
            } else {
                // actions to take right away if user is not logged in
            }
        }

        /**
         * @return bool
         */
        public function isLoggedIn(): bool
        {
            return $this->logged_in;
        }

        /**
         * @param $user
         */
        public function login(User $user)
        {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            setcookie('admin', $user->username, time()+3600*24);
            $this->logged_in = true;
        }

        /**
         * @return bool
         */
        public function logout()
        {
            unset($_SESSION['user_id']);
            setcookie('admin', '');
            unset($this->user_id);
            $this->logged_in = false;
        }

        /**
         * @param string $msg
         * @return mixed
         */
        public function message(string $msg="")
        {
            if (!empty($msg)) {
                $_SESSION['message'] = $msg;
            } else {
                return $this->message;
            }
        }

        /**
         * @return bool
         */
        private function checkLogin()
        {
            if (isset($_SESSION['user_id']) && isset($_COOKIE['admin'])) {
                $this->user_id = $_SESSION['user_id'];
                $this->logged_in = true;
            } else {
                unset($this->user_id);
                $this->logged_in = false;
            }
        }

        private function checkMessage()
        {
            if (isset($_SESSION['message'])) {
                $this->message = $_SESSION['message'];
                unset($_SESSION['message']);
            } else {
                $this->message = "";
            }
        }

    }
