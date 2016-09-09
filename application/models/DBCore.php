<?php
namespace models;

    class DBCore
    {
        /**
         * @var
         */
        private static $db;
        private static $stmt;
        /**
         * @var array
         */
        protected static $placeholders = [];
        /**
         * @var array
         */
        protected static $attribute_pairs = [];
        /**
         * @var
         */
        public static $clean_id;
        /**
         * @var integer
         */
        //public static $rank_id;
        /**
         * @var string
         */
        public static $se;
        public static $last_query;

        /**
         * CoreDatabase constructor.
         */
        public function __construct()
        {
            $this->openConnection();
        }
        protected function destruct()
        {
            $this->closeConnection();
        }

        protected function openConnection()
        {
            $config = parse_ini_file(__DIR__ . '\..\..\dbconf.ini');
            $opt = array(
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            );

            self::$db = new \PDO($config['db.conn'], $config['db.user'], $config['db.pass'], $opt);
        }

        public function closeConnection()
        {
            if (isset($this->db)) {
                unset($this->db);
            }
        }


        /**
         * @param string $sql
         * @return bool
         */
        public static function myQuery($sql): bool
        {
            self::$last_query = $sql;
            new self;// core reload conctructor
            self::$stmt = self::$db->prepare($sql);
            if (!empty(static::$clean_id)) {
                self::$stmt->bindParam(':id', static::$clean_id, \PDO::PARAM_INT, 10000000);
            }

            if (!empty(static::$se)) {
                self::$stmt->bindParam(':se', static::$se, \PDO::PARAM_STR, 50);
            }
            if (!empty(User::$username) && !empty(User::$hash_password)) {
                self::$stmt->bindParam(':username', User::$username, \PDO::PARAM_STR, 50);
                self::$stmt->bindParam(':password', User::$hash_password, \PDO::PARAM_STR, 255);
            }
            if (!empty(static::$attribute_pairs)) {
                for ($i = 0, $size = count(static::$attribute_pairs); $i < $size; ++$i) {
                    self::$stmt->bindParam(static::$placeholders[$i], static::$attribute_pairs[$i], \PDO::PARAM_STR, 20);
            }
            }
            $res = self::$stmt->execute();
            self::confirmQuery($res);
            static::$clean_id = null;
            return (bool) $res;
        }


        /**
         * @return mixed
         */
        public static function myFetchArray()
        {
            $res = self::$stmt->fetch(\PDO::FETCH_ASSOC);
            return $res;
        }

        /**
         * @return mixed
         */
        public static function numRows()
        {
            $res = self::$stmt->fetch(\PDO::FETCH_NUM);
            self::confirmQuery($res);
            return $res;
        }

        /**
         * @return mixed
         */
        public static function insertId()
        {
            $res = self::$db->lastInsertId();
            return $res;
        }

        /**
         * @return mixed
         */
        public static function affectedRows()
        {
            $res = self::$stmt->rowCount();
            self::confirmQuery($res);
            return $res;
        }


        /**
         * @param $result
         * @throws string
         */
        private static function confirmQuery($result)
        {
            if (empty($result)) {
                throw new ExeptionPDOMy("Response \"" . self::$last_query . "\" wasn't to return a data");
            }
        }


    }
