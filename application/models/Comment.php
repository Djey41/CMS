<?php
namespace models;

    /**
     * Class Comment
     * Отправление комментариев
     */
    class Comment extends DBObject
    {

        /**
         * @staticvar string
         * @access [protected]
         */
        protected static $table_name="comments";
        /**
         * @access [protected]
         * @staticvar array
         */
        protected static $db_fields=['id', 'photograph_id', 'created', 'author', 'body'];
        /**
         * @access [public]
         * @var integer
         */
        public $photograph_id;
        /**
         * @var string
         */
        public $created;
        /**
         * @var string
         */
        public $author;
        /**
         * @var string
         */
        public $body;
        /**
         * @var string
         */
        public $id;


        /**
         * @param int $photo_id
         * @param string $author
         * @param string $body
         * @return Comment
         * @throws ExeptionMy
         */
        public static function make(int $photo_id, string $author="Anonymous", string $body=""): Comment
        {
            if (!empty($photo_id) && !empty($author) && !empty($body)) {

                $comment = new Comment();
                $comment->photograph_id = escapeIntValue($photo_id);
                $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
                $comment->author = $author;
                $comment->body = $body;
                return $comment;
            } else {
                throw new ExeptionMy('Заполните все поля для отправки комментария.');
            }
        }


        /**
         * @param int $photo_id
         * @param Pagination $pagination
         * @return array
         */
        public static function findCommentsOn(int $photo_id=0, Pagination $pagination): array
        {
            $sql = "SELECT id, photograph_id, created, author, body FROM " . self::$table_name;
            $sql .= " WHERE photograph_id=" . $photo_id;
            $sql .= " ORDER BY created ASC";
            $sql .= " LIMIT {$pagination->per_page}";
            $sql .= " OFFSET {$pagination->offset()}";
            $arr_comm2 = self::findBySql($sql);//  objects array
            return $arr_comm2;
        }

        /**
         * @param int $photo_id
         * @return array
         */
        public static function findCommentsOnForCurrent(int $photo_id=0): array
        {
            $sql = "SELECT id, photograph_id, created, author, body FROM " . self::$table_name;
            $sql .= " WHERE photograph_id=" . $photo_id;
            $arr_comm = parent::findBySql($sql);// objects array
            return $arr_comm;
        }

    /**
     *Блок отправки комментов на почту
     */
    public function tryToSendNotification()
        {
            tryToSendMessageToPost($this->author, $this->body, $this->created);
        }
    }
