<?php
namespace models;

    /**
     * Class Databaseobject
     *
     * @package models
     */
    class DBObject extends DBCore
    {
        /**
         * @var array
         */
        protected static $placeholders = [];
        /**
         * @var array
         */
        protected static $attribute_pairs = [];
        /**
         * @var array
         */
        private static $name_attr = [];
        /**
         * @var array
         */
        private static $attribute_pairs_placeholders = [];
         /**
         * @var string
         */
        public $sql;
        /**
         * @staticvar
         */
        public static $clean_id;

        /**
         *  @var integer
         */
        public $id;
        /**
         *  @var object
         */
        public static $object;

        /**
         * @return array
         */
        public static function findAll(): array
        {
            $sql = "SELECT * FROM " . static::$table_name;
            return self::findBySql($sql);
        }


        /**
         * @param int $id
         * @return mixed
         */
        public static function findById(int $id=0)//: ? object
        {
            self::$clean_id = escapeIntValue($id);
            $sql = "SELECT * FROM ".static::$table_name." WHERE id=:id LIMIT 1";
            $result_array = self::findBySql($sql);
            return array_shift($result_array);
        }

        /**
         * @param string $sql
         * @return array
         */
        public static function findBySql(string $sql=''): array
        {
           self::myQuery($sql);
           $object_array = [];
           while ($row = self::myFetchArray()) {
                $object_array[] = self::instantiate($row);
           }
           return $object_array;
        }

        /**
         * @return mixed
         */
        public static function countAll()//: ? integer
        {
            $sql = "SELECT COUNT(*) FROM ".static::$table_name;
            self::myQuery($sql);
            $row = self::myFetchArray();
            return array_shift($row);
        }


        /**
         * @param array $record
         * @return object
         */
        private static function instantiate(array $record)//: ?object
        {
            if(self::$object instanceof static) {
                self::$object = null;// clean copy of object
            }
            //gc_collect_cycles();// start Garbage Collection working either
            self::$object = new static();
            foreach ($record as $attribute=>$value) {
            if (self::$object->hasAttribute($attribute)) {
                self::$object->$attribute = $value;
            }
            }
            return self::$object;
        }

        /**
         * @param $attribute
         * @return bool
         */
        private function hasAttribute(string $attribute): bool
        {
            return array_key_exists($attribute, $this->attributes());
        }

        /**
         * @return array
         */
        private function attributes(): array
        {
            $attributes = [];
            foreach(static::$db_fields as $field) {
                if (property_exists($this, $field)) {
                    $attributes[$field] = $this->$field;
                }
            }
            return $attributes;
        }

        /**
         * @return array
         */
        private function sanitizedAttributes(): array
        {
            $clean_attributes = [];
            foreach ($this->attributes() as $key => $value) {
                $clean_attributes[$key] = escapeValue($value);
            }
            return $clean_attributes;
        }

        /**
         * @return void
         */
        public function saveDB()
        {
            isset($this->id) ? $this->update() : $this->create();
        }

        public function create()
        {
            $this->id = $this->insertId();
            $attributes = $this->sanitizedAttributes();
            foreach ($attributes as $key => $value) {
                self::$name_attr[] = $key;
                self::$placeholders[] = ':' . $key;
                self::$attribute_pairs[] = "$value";
            }
            $sql = "INSERT INTO ".static::$table_name." (";
            $sql .= join(", ", self::$name_attr);
            $sql .= ") VALUES (";
            $sql .= join(", ", self::$placeholders);
            $sql .= ")";
            self::myQuery($sql);
        }

        public function update()
        {
            $attributes = $this->sanitizedAttributes();
            foreach ($attributes as $key => $value) {
                self::$attribute_pairs_placeholders[] = "{$key}=:{$key}";
                self::$placeholders[] = ":{$key}";
                self::$attribute_pairs[] = "{$value}";
            }
            $sql = "UPDATE ".static::$table_name." SET ";
            $sql .= join(", ", self::$attribute_pairs_placeholders);
            $sql .= " WHERE id=:id";
            self::myQuery($sql);
        }

        public function delete($name_id)
        {
            self::$clean_id = escapeIntValue($this->id);
            $sql = "DELETE FROM ".static::$table_name;
            $sql .= " WHERE ".$name_id."=:id";
            self::myQuery($sql);
        }
    }
