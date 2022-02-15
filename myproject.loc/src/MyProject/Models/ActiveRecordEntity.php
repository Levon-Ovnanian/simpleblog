<?php
namespace MyProject\Models;

use MyProject\Models\Users\User;
use MyProject\Services\Db;

abstract class ActiveRecordEntity implements \JsonSerializable
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $id;
    
    /**
     * return protected property $id;
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * set protected property $id;
     *
     * @param integer $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * return table name from Db;
     *
     * @return string
     */
    abstract static protected function getTableName(): string;
    
    /**
     * function to present object as array;
     * (processing of JSON queries)
     * @return array|null
     */
    public function jsonSerialize(): ?array
    {
        return $this->mapPropertiesToDbFormat();
    }
    
    /**
     * special function changes name of property according to PHP syntax 
     * then assigns values to properties of the object; 
     * @param string $name
     * @param [type] $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }
    
    /**
     * function changes input string data according to camelCase style;
     * 
     * @param string $source
     * @return string
     */
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * function gets the array of properties and values,
     * whose keys where changed according to msq syntaxes;
     * then calls function 'insert' with that array as params of the function;
     * @return void
     */
    public function create(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat(); ///gets the array of properties and values with msq syntaxes;
        $this->insert($mappedProperties); ///calls function 'insert' and gives array to operate;    
    }
    
    /**
     * function gets the array of properties and values,
     * whose keys where changed according to msq syntaxes;
     * then calls function 'update' with that array as params of the function;
     * @return void
     */
    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat(); ///gets the array of properties and values with msq syntaxes;
        $this->update($mappedProperties); ///calls function 'update' and gives array to operate;    
    }
        
    /**
     * creates array created from object properties names and values;
     * finally returns array whose keys where changed according to msq syntaxes;
     * @return array
     */
    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this); ///initiates an object of class ReflectionObject;
        $properties = $reflector->getProperties(); ///getting properties of object;
        $mappedProperties = [];
        
        foreach ($properties as $property) {
            $propertyName = $property->getName(); ///assigns property name to variable $propertyName;
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName); ///changes property name from camelCase to under_score style;
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName; ///creates array whose keys are properties names in under_score style; 
        }
        return $mappedProperties;
    }
    
    /**
     * changes input string data from camelCase to under_score style;
     *
     * @param string $source
     * @return string
     */
    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }
   
    /**
     * function inserts data to Db table; 
     * as data source uses array based on object properties names and values;
     * @param array $mappedProperties
     * @return void
     */
    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties); ///deletes array element with null value;
        $columns = [];
        $paramsNames = [];
        $params2values = [];
        
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`' . $columnName . '`'; ///array[`column_name`];
            $paramName = ':' . $columnName; ///string ':column_name';
            $paramsNames[] = $paramName; ///array[':column_name'];
            $params2values[$paramName] = $value; ///array[':column_name' => value] for sql binding; 
        }
        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);
        
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ')
        VALUES (' . $paramsNamesViaSemicolon . ');';
        
        $db = Db::getInstance(); ///check if connection with Db is active;

        $db->query($sql, $params2values , static::class); 
        $this->id = $db->getLastInsertId(); ///assigns last used id in Db table to object property 'id';
        $this->refresh(); ///function fills the object properties according to Db table columns values;    
    }
 
    /**
     * function fills the object properties according to Db table columns values;
     *
     * @return void
     */
    protected function refresh(): void
    {
        $getObject = static::getById($this->id); ///creates object by filling his properties by Db table values;
        $reflector = new \ReflectionObject($getObject);
        $properties = $reflector->getProperties();
        
        foreach ($properties as $property)
        {
            $property->setAccessible(true); ///sets properties access specifier as 'accessible';
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($getObject);
            $this->$propertyName = $propertyValue; ///assigns $getObject->properties to $this->properties;
        } 
    }
    
    /**
     * updates Db table columns values by values from given array;
     *
     * @param array $mappedProperties
     * @return void
     */
    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; ///string ':param1';
            $columns2params[] = $column . ' = ' . $param; ///array['column_name = :param1'] for sql binding;
            $params2values[$param] = $value; ///array[':param1 => value'] for sql binding;
            $index++;
        } 
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) .
            ' WHERE id = ' . $this->id;
        
        $db = Db::getInstance(); ///check if connection with Db is active;

        $db->query($sql, $params2values, static::class);
    }
    
    /**
     * function deletes data from Db table by specific row id;
     *
     * @return void
     */
    public function delete(): void
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        $db->query('DELETE FROM ' . static::getTableName() . ' WHERE id = :id;',
        [':id' => $this->id]
        );
        $this->id = null;
    }

    /**
     * function deletes data from Db table by specific column value;
     *
     * @param string $columnName
     * @param [type] $value
     * @return void
     */
    public function deleteByColumn(string $columnName, $value): void
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        $db->query('DELETE FROM ' . static::getTableName() . ' WHERE ' . $columnName . ' = :value;',
            [':value' => $value]);     
    }
    
    /**
     * gets list of all positions from column 'id' of Db table 'articles' to use this list as a map in page pagination;
     * used for correct data display sequence in case of inconsistency of values in column 'id' of Db;
     * @param string $orderBy
     * @param string $optional
     * @return array|null
     */
    public static function getStartingId(string $orderBy, string $optional = ''): ?array 
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        
        $result = $db->query('SELECT articles.id FROM articles ' . $optional . ' ORDER BY ' . $orderBy . ';'
        );

        if ($result === []) {
            return null;
        }

        return $result;
    }

    /**
     * gets list of all positions from column 'id' of Db table 'articles' to use this list as a map in page pagination;
     * used for correct data display sequence in case of inconsistency of values in column 'id' of Db;
     * @param string $orderBy
     * @return array|null
     */
    public static function getStartingIdForSortingWithComments(string $orderBy): ?array 
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        $sql = "SELECT DISTINCT users_comments.article_id FROM users_comments ORDER BY users_comments.article_id " . $orderBy . ";";

        $result = $db->query($sql);

        if ($result === []) {
            return null;
        }

        return $result;
    }

    /**
     * gets list of all positions from column 'id' of Db table 'articles' to use this list as a map in page pagination;
     * used for correct data display sequence in case of inconsistency of values in column 'id' of Db;
     * @param string $join
     * @param string $searchArgs
     * @param string $orderBy
     * @return array|null
     */
    public static function getStartingIdForSortingWithSearchArgs(array $searchArgs, string $orderBy, string $optional = ''): ?array 
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        if ($optional === 'ratingDESC' AND $searchArgs[0] === 'nickname'){
            $sql = $db->query('SELECT articles.id FROM ' . static::getTableName() . ' INNER JOIN users ON users.nickname LIKE :value WHERE articles.plus >= 10 AND articles.author_id = users.id ORDER BY ' . $orderBy . ';',
                [
                    ':value' => "%" . $searchArgs[1]. "%"
                ]
            );   

        }
        elseif ($optional === 'ratingDESC') {
            $sql = $db->query('SELECT articles.id FROM ' . static::getTableName() . ' WHERE articles.plus >= 10 AND articles.' . $searchArgs[0] . ' LIKE :value ORDER BY ' . $orderBy . ';',
                [
                    ':value' => "%" . $searchArgs[1]. "%"
                ]
            );     
        }
        elseif ($searchArgs[0] === 'nickname') {
            $sql = $db->query('SELECT articles.id FROM ' . static::getTableName() . ' INNER JOIN users WHERE users.nickname LIKE :value AND articles.author_id = users.id ORDER BY ' . $orderBy . ';',
                [
                    ':value' => "%" . $searchArgs[1]. "%"
                ]
            );        

        } else {
            $sql = $db->query('SELECT articles.id FROM articles  WHERE articles.' . $searchArgs[0] . ' LIKE :value ORDER BY ' . $orderBy . ';',
                [   
                    ':value' => "%" . $searchArgs[1] . "%",
                ]
            );
        }
        if ($sql === []) {
            return null;
        }

        return $sql;
    }

    /**
     * gets list of all positions from column 'id' of Db table 'articles' to use this list as a map in page pagination;
     * used for correct data display sequence in case of inconsistency of values in column 'id' of Db;
     * @param string $orderBy
     * @param array $getValues
     * @return array|null
     */
    public static function getStartingIdForSortingWithCommentsWithSearchArgs(string $orderBy, array $getValues): ?array 
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
         
        if ($getValues[0] === 'nickname') {
            $sql = $db->query('SELECT DISTINCT articles.id as id FROM articles INNER JOIN users ON users.nickname LIKE :value
            AND users.id = articles.author_id INNER JOIN users_comments WHERE articles.id = users_comments.article_id ORDER BY articles.id ' . $orderBy . ';',
                [
                    ':value' => "%" . $getValues[1] . "%"
                ]
            );
        } else {
            $sql = $db->query('SELECT DISTINCT users_comments.article_id as id FROM users_comments INNER JOIN articles ON articles.' . $getValues[0] . ' LIKE :value
                WHERE articles.id = users_comments.article_id ORDER BY users_comments.article_id ' . $orderBy . ';',
                [   
                    ':value' => "%" . $getValues[1] . "%"
                ]        
            );
        }

        if ($sql === []) {
            return null;
        }
        return $sql;
    }

    /**
    * function creates query to Db to get data according to page pagination 
    * data ordered by specified column name DESC;
    * @param integer $pageNum
    * @param integer $itemsPerPage
    * @param string $orderBy
    * @return array
    */
    public static function getPage(int $pageNum, int $itemsPerPage, string $orderBy): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active; 
        
        $nextPage = ($pageNum - 1) * $itemsPerPage;
        $idAsArray = static::getStartingId($orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
        return $db->query(
            sprintf('SELECT * FROM `%s` WHERE id <= %d ORDER BY %s LIMIT %d;',
            static::getTableName(),
            $idAsArray[$nextPage]->id, ///starting article id in query;
            $orderBy,
            $itemsPerPage
            ), 
            [],
            static::class
        );
    }
   
    /**
    * function creates query to Db to get data according to page pagination; 
    * data ordered by specified column name ASC;
    * @param integer $pageNum
    * @param integer $itemsPerPage
    * @param string $orderBy
    * @return array
    */
    public static function getPageASC(int $pageNum, int $itemsPerPage, string $orderBy): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active; 
        
        $nextPage = ($pageNum - 1) * $itemsPerPage;
        $idAsArray = static::getStartingId($orderBy); ///initiates array of all articles id to use it as a map in page pagination;
        return $db->query(
            sprintf('SELECT * FROM `%s` WHERE id >= %d ORDER BY %s LIMIT %d;',
            static::getTableName(),
            $idAsArray[$nextPage]->id, ///starting article id in query;
            $orderBy,
            $itemsPerPage,
            ),
            [],
            static::class
        ); 
    }
    
    /**
     * function creates query to Db to get data with rating => 10 and according to page pagination; 
     * data ordered by specified column name DESC;
     * @param integer $pageNum
     * @param integer $itemsPerPage
     * @param string $orderBy
     * @return array
     */
    public static function getPageByRating(int $pageNum, int $itemsPerPage, string $orderBy): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active; 
        
        $nextPage = ($pageNum - 1) * $itemsPerPage;
        $idAsArray = static::getStartingId($orderBy, 'WHERE plus >= 10'); ///initiates array of all articles id to use it as a map in page pagination; 
        return $db->query(
            sprintf('SELECT * FROM `%s` WHERE plus >= 10 AND id <= %d ORDER BY %s LIMIT %d;',
            static::getTableName(),
            $idAsArray[$nextPage]->id,
            $orderBy,
            $itemsPerPage
            ), 
            [],
            static::class
        );
    }
    
    /**
     * function creates query to Db to get data considering the search query and according to page pagination; 
     * data ordered by specified column name DESC;
     * @param integer $pageNum
     * @param integer $itemsPerPage
     * @param array $getValues ///values from user search rows;
     * @param string $orderBy
     * @param string $optional ///optional query condition extending parameter;
     * @return array
     */
    public static function getPageWithSearchArgs(int $pageNum, int $itemsPerPage, array $getValues, string $orderBy = 'articles.id DESC', string $optional = ''): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
   
        if ($optional === 'ratingDESC' AND $getValues[0] === 'nickname') {
            $idAsArray = static::getStartingIdForSortingWithSearchArgs($getValues, $orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
            $nextPage = ($pageNum - 1) * $itemsPerPage;
            $startId = $idAsArray[$nextPage]->id; ///starting article id in query;
            return  $db->query('SELECT articles.* FROM ' . static::getTableName() . ' INNER JOIN users ON users.' . $getValues[0] . ' LIKE :value  WHERE articles.id <= ' . $startId . ' AND articles.plus >= 10 AND articles.author_id = users.id ORDER BY ' . $orderBy . ' LIMIT ' . $itemsPerPage . ';',
                [
                    ':value' => "%" . $getValues[1]. "%"
                ], 
                static::class
            );     
        }
        elseif ($optional === 'ratingDESC') {
            $idAsArray = static::getStartingIdForSortingWithSearchArgs($getValues, $orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
            $nextPage = ($pageNum - 1) * $itemsPerPage;
            $startId = $idAsArray[$nextPage]->id; ///starting article id in query;
             return  $db->query('SELECT articles.* FROM ' . static::getTableName() . ' WHERE articles.id <= ' . $startId . ' AND articles.plus >= 10 AND articles.' . $getValues[0] . ' LIKE :value ORDER BY ' . $orderBy . ' LIMIT ' . $itemsPerPage . ';',
                [
                    ':value' => "%" . $getValues[1]. "%"
                ], 
                static::class
            );     
        }
        elseif ($getValues[0] === 'nickname') {
            $idAsArray = static::getStartingIdForSortingWithSearchArgs($getValues, $orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
            $nextPage = ($pageNum - 1) * $itemsPerPage;
            $startId = $idAsArray[$nextPage]->id; ///starting article id in query;
            return $db->query('SELECT articles.* FROM ' . static::getTableName() . ' INNER JOIN users ON users.' . $getValues[0] . ' LIKE :value  WHERE articles.id <= ' . $startId . ' AND articles.author_id = users.id ORDER BY ' . $orderBy . ' LIMIT ' . $itemsPerPage . ';',
                [
                    ':value' => "%" . $getValues[1]. "%"
                ], 
                static::class
            );     
        } else {
            $idAsArray = static::getStartingIdForSortingWithSearchArgs($getValues, $orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
            $nextPage = ($pageNum - 1) * $itemsPerPage;
            $startId = $idAsArray[$nextPage]->id; ///starting article id in query;
            return $db->query('SELECT articles.* FROM ' . static::getTableName() . ' WHERE articles.id <= ' . $startId . ' AND articles.' . $getValues[0] . ' LIKE :value ORDER BY ' . $orderBy . ' LIMIT ' . $itemsPerPage . ';',
                [
                    ':value' => "%" . $getValues[1]. "%"
                ], 
                static::class
            );     
        }
    }

    /**
     * function creates query to Db to get data considering the search query and according to page pagination; 
     * data ordered by specified column name ASC;
     * @param integer $pageNum
     * @param integer $itemsPerPage
     * @param array $getValues ///values from user search rows;
     * @param string $orderBy
     * @param string $optional ///optional query condition extending parameter;
     * @return array
     */
    public static function getPageWithSearchArgsASC(int $pageNum, int $itemsPerPage, array $getValues, string $orderBy = 'articles.id ASC'): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
   
        if ($getValues[0] === 'nickname') {
            $idAsArray = static::getStartingIdForSortingWithSearchArgs($getValues, $orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
            $nextPage = ($pageNum - 1) * $itemsPerPage;
            $startId = $idAsArray[$nextPage]->id; ///starting article id in query;
            return  $sql = $db->query('SELECT articles.* FROM ' . static::getTableName() . ' INNER JOIN users ON users.' . $getValues[0] . ' LIKE :value  WHERE articles.id >= ' . $startId . ' AND articles.author_id = users.id ORDER BY ' . $orderBy . ' LIMIT ' . $itemsPerPage . ';',
                [
                    ':value' => "%" . $getValues[1]. "%"
                ], 
                static::class
            );     
        } else {
            $idAsArray = static::getStartingIdForSortingWithSearchArgs($getValues, $orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
            $nextPage = ($pageNum - 1) * $itemsPerPage;
            $startId = $idAsArray[$nextPage]->id; ///starting article id in query;
            return  $sql = $db->query('SELECT articles.* FROM ' . static::getTableName() . ' WHERE articles.id >= ' . $startId . ' AND articles.' . $getValues[0] . ' LIKE :value ORDER BY ' . $orderBy . ' LIMIT ' . $itemsPerPage . ';',
                [
                    ':value' => "%" . $getValues[1]. "%"
                ], 
                static::class
            );     
        }

    }

   /**
   * returns count of pages taking into account the count of items per page, optional values
   * and returns a count of all rows in specific Db table;
   * @param integer $itemsPerPage;
   * @param string $optional ///optional query condition extending parameter;
   * @return array
   */
    public static function getPagesCount(int $itemsPerPage, string $optional = ''): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        
        if ($optional === 'ratingDESC') {
            $result = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ' WHERE plus >= 10;',);
            return [(int)ceil($result[0]->cnt / $itemsPerPage), (int)$result[0]->cnt]; 
        }
        
        $result = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ';',); 
        return [(int)ceil($result[0]->cnt / $itemsPerPage), (int)$result[0]->cnt];
    }

    /**
     * returns count of pages taking into account the count of items per page, values from user search rows, optional values
     * and returns a count of all rows in specific Db table;
     * @param integer $itemsPerPage
     * @param array $getValues ///values from user search rows;
     * @param string $optional ///optional query condition extending parameter;
     * @return array
     */
    public static function getPagesCountWithSearchArgs(int $itemsPerPage, array $getValues, string $optional = ''): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
   
        if ($optional === 'ratingDESC' AND $getValues[0] === 'nickname') {
             $sql = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ' INNER JOIN users WHERE articles.plus >= 10 AND users.' . $getValues[0] . ' LIKE :value AND articles.author_id = users.id',
                [
                    ':value' => "%" . $getValues[1] . "%"
                ]
            );         
        }
        elseif ($optional === 'ratingDESC') {
            $sql = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ' WHERE articles.plus >= 10 AND articles.' . $getValues[0] . ' LIKE :value;',
                [
                    ':value' => "%" . $getValues[1] . "%"
                ]
            );     
        }
        elseif ($getValues[0] === 'nickname') {
            $sql = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ' INNER JOIN users WHERE users.' . $getValues[0] . ' LIKE :value AND articles.author_id = users.id;',
                [
                    ':value' => "%" . $getValues[1] . "%"
                ]
            );     
        } else {
            $sql = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ' WHERE articles.' . $getValues[0] . ' LIKE :value;',
                [
                    ':value' => "%" . $getValues[1] . "%"
                ]
            );     
        }   
        return [(int)ceil($sql[0]->cnt / $itemsPerPage), (int)$sql[0]->cnt];
    }
      

    /**
     * returns count of pages taking into account the count of items per page, values from user search rows
     * and returns a count of all rows in specific Db table;
     * @param integer $itemsPerPage
     * @param array $getValues ///values from user search rows;
     * @return array
     */
    public static function getPagesWithCommentsCount(int $itemsPerPage, array $getValues = []): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        if ($getValues[0] === 'nickname') {
            $sql = $db->query('SELECT COUNT(DISTINCT articles.id) AS cnt FROM articles INNER JOIN users 
            ON users.nickname LIKE :value AND users.id = articles.author_id INNER JOIN users_comments WHERE articles.id = users_comments.article_id;',
                [
                    ':value' => "%". $getValues[1] ."%"
                ]
            );    
        } elseif (!empty($getValues)) {
            $sql = $db->query('SELECT COUNT(DISTINCT users_comments.article_id) AS cnt FROM users_comments INNER JOIN articles 
                ON articles.' . $getValues[0] . ' LIKE :value WHERE articles.id = users_comments.article_id;',
                [
                    ':value' => "%". $getValues[1] ."%"
                ]
            );
        } else {
            $sql = $db->query('SELECT COUNT(DISTINCT users_comments.article_id) AS cnt FROM users_comments INNER JOIN articles WHERE articles.id = users_comments.article_id;');
        }
        return [(int)ceil($sql[0]->cnt / $itemsPerPage), (int)$sql[0]->cnt];
    }
   /**
    * Undocumented function
    *
    * @param integer $itemsPerPage
    * @param array $getValues
    * @return array
    */
    public static function getCommentsCount(int $itemsPerPage, array $getValues = []): array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        if ($getValues[0] === 'nickname') {
            $sql = $db->query("SELECT COUNT(users_comments.article_id) AS cnt FROM users_comments INNER JOIN users 
                ON users." . $getValues[0] . " LIKE :value WHERE users.id = users_comments.user_id;",
                [
                    ':value' => "%" . $getValues[1] . "%"
                ]    
            );
        } elseif (!empty($getValues)) {
            $sql = "SELECT COUNT(users_comments.article_id) AS cnt FROM users_comments INNER JOIN articles 
                ON articles." . $getValues[0] . " LIKE :value WHERE articles.id = users_comments.article_id;";
        } else {
            $sql = $db->query("SELECT COUNT(users_comments.article_id) AS cnt FROM users_comments INNER JOIN articles WHERE articles.id = users_comments.article_id;");
        }
        
        return [(int)ceil($sql[0]->cnt / $itemsPerPage), (int)$sql[0]->cnt];
    }
 
    /**
     * returns articles with comments for specific author;
     * uses no page pagination;
     * @param integer $id
     * @param string $orderBy
     * @return array|null
     */
    public static function getArticlesWithCommentsForUser(int $id, string $orderBy): ?array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        
        $sql = 'SELECT DISTINCT articles.* FROM articles 
        inner join users_comments ON articles.id = users_comments.article_id WHERE articles.author_id = :id order by articles.id ' . $orderBy .';';
        
        $results = $db->query($sql, [":id" => $id], static::class);

        if ($results === []) { 
            return null;
        }
        return $results;

    }

    /**
     * returns articles with comments ordered by articles id DESC;
     * uploaded objects count are limited by the number of elements on the page;
     * @param integer $pageNum
     * @param integer $itemsPerPage
     * @param string $orderBy
     * @return array|null
     */
    public static function getArticlesWithCommentsLimited(int $pageNum, int $itemsPerPage, string $orderBy): ?array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        
        $nextPage = ($pageNum - 1) * $itemsPerPage;
        $startId = static::getStartingIdForSortingWithComments($orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
        $id = $startId[$nextPage]->article_id; ///starting article id in query;

        $sql = 'SELECT DISTINCT articles.id, articles.author_id, articles.name, articles.text, articles.created_at 
            FROM ' . static::getTableName() . ' INNER JOIN users_comments ON users_comments.article_id = articles.id WHERE articles.id <= :id
            order by articles.id ' . $orderBy . ' LIMIT '. $itemsPerPage .';';
        
        $result = $db->query($sql, [':id' => $id], static::class);

        if ($result === []) { 
            return null;
        }
            
        return $result; 
    }

    /**
     * returns articles with comments ordered by articles id ASC;
     * uploaded objects count are limited by the number of elements on the page;
     * @param integer $pageNum
     * @param integer $itemsPerPage
     * @param string $orderBy
     * @return array|null
     */
    public static function getArticlesWithCommentsASCLimited(int $pageNum, int $itemsPerPage, string $orderBy): ?array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        
        $nextPage = ($pageNum - 1) * $itemsPerPage;
        $startId = static::getStartingIdForSortingWithComments($orderBy); ///initiates array of all articles id to use it as a map in page pagination; 
        $id = $startId[$nextPage]->article_id; ///starting article id in query;

        $sql = 'SELECT DISTINCT articles.id, articles.author_id, articles.name, articles.text, articles.created_at 
            FROM ' . static::getTableName() . ' INNER JOIN users_comments ON users_comments.article_id = articles.id WHERE articles.id >= :id
            order by articles.id ' . $orderBy . ' LIMIT '. $itemsPerPage .';';
        
        $result = $db->query($sql, [':id' => $id], static::class);

        if ($result === []) { 
            return null;
        }
            
        return $result; 
    }

    /**
     * returns articles with comments considering users values of search rows ordered by articles id DESC;
     * uploaded objects count are limited by the number of elements on the page;
     * @param integer $pageNum
     * @param integer $itemsPerPage
     * @param array $getValues ///values from user search rows;
     * @return array|null
     */
    public static function getArticlesWithCommentsBySearchArgsLimited(int $pageNum, int $itemsPerPage, array $getValues): ?array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        
        $idAsArray = static::getStartingIdForSortingWithCommentsWithSearchArgs('DESC', $getValues); ///initiates array of all articles id to use it as a map in page pagination; 
        $nextPage = ($pageNum - 1) * $itemsPerPage;
        $startId = $idAsArray[$nextPage]->id; ///starting article id in query;
        
        if ($getValues[0] === 'nickname') {
            $sql = $db->query('SELECT DISTINCT articles.id, articles.author_id, articles.name, articles.text, articles.created_at FROM ' . static::getTableName() . ' 
                INNER JOIN users ON users.nickname LIKE :value AND users.id = articles.author_id 
                INNER JOIN users_comments ON articles.id = users_comments.article_id WHERE articles.id <= ' .  $startId . ' ORDER BY articles.id DESC LIMIT ' . $itemsPerPage . ';',
                    [
                        ':value' => "%" . $getValues[1] . "%" 
                    ],
                    static::class
            );
        } else {
            $sql = $db->query('SELECT DISTINCT articles.id, articles.author_id, articles.name, articles.text, articles.created_at 
                FROM ' . static::getTableName() . ' INNER JOIN users_comments ON articles.' . $getValues[0] . ' LIKE :value
                AND users_comments.article_id = articles.id 
                WHERE articles.id <= ' .  $startId . ' ORDER BY articles.id DESC LIMIT '. $itemsPerPage . ';',
                    [
                        ':value' => "%" . $getValues[1] . "%" 
                    ],
                    static::class
            );
        }

        if ($sql === []) { 
            return null;
        }  
        return $sql; 
    }

    /**
     * returns articles with comments considering users values of search rows ordered by articles id ASC;
     * uploaded objects count are limited by the number of elements on the page;
     * @param integer $pageNum
     * @param integer $itemsPerPage
     * @param array $getValues ///values from user search rows;
     * @return array|null
     */
    public static function getArticlesWithCommentsBySearchArgsLimitedASC(int $pageNum, int $itemsPerPage, array $getValues): ?array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;
        
        $idAsArray = static::getStartingIdForSortingWithCommentsWithSearchArgs('ASC', $getValues); ///initiates array of all articles id to use it as a map in page pagination;
        $nextPage = ($pageNum - 1) * $itemsPerPage;
        $startId = $idAsArray[$nextPage]->id; ///starting article id in query;

        if ($getValues[0] === 'nickname') {
            $sql = $db->query('SELECT DISTINCT articles.id, articles.author_id, articles.name, articles.text, articles.created_at FROM ' . static::getTableName() . ' 
                INNER JOIN users ON users.nickname LIKE :value AND users.id = articles.author_id 
                INNER JOIN users_comments ON articles.id = users_comments.article_id WHERE articles.id >= ' .  $startId . ' ORDER BY articles.id DESC LIMIT ' . $itemsPerPage . ';',
                    [
                        ':value' => "%" . $getValues[1] . "%" 
                    ],
                    static::class
            );
        } else {
            $sql = $db->query('SELECT DISTINCT articles.id, articles.author_id, articles.name, articles.text, articles.created_at 
                FROM ' . static::getTableName() . ' INNER JOIN users_comments ON articles.' . $getValues[0] . ' LIKE :value
                AND users_comments.article_id = articles.id 
                WHERE articles.id >= ' .  $startId . ' ORDER BY articles.id DESC LIMIT '. $itemsPerPage . ';',
                    [
                        ':value' => "%" . $getValues[1] . "%" 
                    ],
                    static::class
            );
        }

        if ($sql === []) { 
            return null;
        }  
        return $sql; 
    }

    /**
     * returns count of articles with comments for specific author;
     *
     * @param integer $id
     * @return integer
     */
    public static function getArticlesWithCommentsCountForUser(int $id): int
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        $result = $db->query('SELECT COUNT(DISTINCT articles.id) AS count FROM articles inner join users_comments ON articles.id = users_comments.article_id 
        WHERE articles.author_id = :id;',
        [":id" => $id],
        static::class
        ); 
        
        return (int)ceil($result[0]->count);
    }

    /**
     * returns count of articles for specific author;
     *
     * @param integer $id
     * @return integer
     */
    public static function getArticlesCountForUser(int $id): int
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        $result = $db->query('SELECT COUNT(DISTINCT articles.id) AS count FROM articles WHERE articles.author_id = :id;',
        [":id" => $id],
        static::class
        ); 
        
        return (int)ceil($result[0]->count);
    }

    /**
     * returns count of rows from Db filtered by value of specific column;
     *
     * @param array $values
     * @param string $columnName
     * @return array|null
     */
    public static function getItemsCountByColumn(array $values, string $columnName): ?array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        foreach ($values as $value) {
            $sql = $db->query('SELECT COUNT(*) AS count FROM ' . static::getTableName() . ' WHERE ' . $columnName . ' = :value;',
                [':value' => $value->getId()],
                static::class
            );  
            $result[] = $sql;     
        }

        if ($result === []) { 
            return null;
        }
            
        return $result;    
    }
    
    /**
     * returns data from Db table by row id;
     *
     * @param integer $id
     * @return self|null
     */
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        $entities = $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE id = :id;',
        [':id' => $id],
        static::class
        );
    
        if ($entities === []){
            return null;
        }
        return $entities[0];
    }

    /**
     * returns all data from Db table;
     *
     * @return array|null
     */
    public static function findAll(): ?array
    {
        $db = Db::getInstance(); ///check if connection with Db is active;

        return $db->query('SELECT * FROM ' . static::getTableName() . ';',
        [],
        static::class
        );
    }

    /**
     * returns the first found value from Db table by specific column value;
     *
     * @param string $columnName
     * @param [type] $value
     * @return self|null
     */
    public static function findOneByColumn(string $columnName, $value): ?self
    {   
        $db = Db::getInstance(); ///check if connection with Db is active;

        $result = $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE ' . $columnName  . ' = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        
        if ($result === []) { 
            return null;
        }    
        return $result[0];    
    }
    
    /**
     * returns all data from Db table by specific column value;
     * ordered by data id ASC;
     * @param string $columnName
     * @param [type] $value
     * @return array|null
     */
    public static function findAllByColumnASC(string $columnName, $value): ?array
    {   
        $db = Db::getInstance(); ///check if connection with Db is active;  
        
        $result = $db->query('SELECT * FROM ' . static::getTableName() .
            ' WHERE ' . $columnName  . ' = :value ORDER BY id ASC;',
            [':value' => $value],
            static::class
        );
        
        if ($result === []) {
            return null;
        }
        return $result;    
    }
    
    /**
     * returns all data from Db table by specific column value;
     * ordered by data id DESC;
     * @param string $columnName
     * @param [type] $value
     * @return array|null
     */
    public static function findAllByColumnDESC(string $columnName, $value): ?array
    {   
        $db = Db::getInstance(); ///check if connection with Db is active;  
        
        $result = $db->query('SELECT * FROM ' . static::getTableName() .
            ' WHERE ' . $columnName  . ' = :value ORDER BY id DESC;',
            [':value' => $value],
            static::class
        );
        
        if ($result === []) {
            return null;
        }
        return $result;    
    }

    /**
     * returns users data from Db found by nickname;
     * ordered by user registration data DESC;
     * @param string $value
     * @return array|null
     */
    public static function findUsersByNameDESC(string $value): ?array
    {   
        $db = Db::getInstance(); ///check if connection with Db is active;  

        $result = $db->query('SELECT * FROM ' . static::getTableName() .
            ' WHERE users.nickname LIKE :value ORDER BY created_at DESC;',
            [':value' => '%' . $value . '%'],
            static::class
        );
        
        if ($result === []) {
            return null;
        }
        return $result;    
    }

    /**
     * returns data from Db according to set column name and sorting order;
     *
     * @param string $columnName
     * @param string $orderBy
     * @return array|null
     */
    public static function findAllWithOptionalColumnOrder(string $columnName, string $orderBy): ?array
    {   
        $db = Db::getInstance(); ///check if connection with Db is active;
         
        $result = $db->query('SELECT * FROM ' . static::getTableName() .
            ' ORDER BY ' . $columnName . ' ' . $orderBy.';',
            [],
            static::class
        );
        
        if ($result === []) {
            return null;
        }
        return $result;    
    }

    /**
     * returns the found data in the form of an array in accordance with the specified search value;
     *
     * @param string $columnName
     * @param [type] $values ///the list of search values;
     * @return array|null
     */
    public static function findAllAsArrayByColumn(string $columnName, $values): ?array
    {   
        $db = Db::getInstance(); ///check if connection with Db is active;  

        $usersArray = [];
        for ($i = 0; $i < count($values); $i++) {    
            foreach ($values[$i] as $value) {
                $result = $db->query('SELECT * FROM ' . static::getTableName() .
                ' WHERE ' . $columnName  . ' = :value;',
                [':value' => $value],
                static::class
                );
            
                if ($result !== []) {
                    $usersArray[$i][] = $result;
                }
            }    
            if (empty($values[$i])) {
                $usersArray[$i] = [];
            }
        }
        return $usersArray;    
    }
    
    /**
     * enters the rater's email in the 'minus_by', 'plus_by' columns;
     * updates the object rating in the 'minus', 'plus' columns of the table;
     * @param string $column
     * @param [type] $updates ///rater's email or rating points;
     * @return void
     */
    public function setRate(string $column, $updates): void
    {
        $db = Db::getInstance(); ///check if connection with Db is active;  
        
        $sql = 'UPDATE ' . static::getTableName() . ' set ' . $column . ' = "' . $updates . '" WHERE id = '. $this->id;
        $db->query($sql, [], static::class);
    }

    /**
     * converts string $match to array;
     * compares if the string $sample is in array $match;
     * @param string $sample
     * @param string $match
     * @return boolean
     */
    public function compareWithArray(string $sample, string $match): bool
    {
       return in_array($sample, explode(',', $match));
    }

    /**
     * function excludes string data from $followerEmail from list of emails in variable $pull;
     *
     * @param string $followerEmail ///session user email;
     * @param string $pull ///data from column 'plus_by' or 'minus_by';
     * @param string $property ///string indicates which property is for further update;
     * @return void
     */
    public function unRate(string $followerEmail, string $pull, string $property): void
    {
        if ($property === 'plus') {
            $property = 'plusBy';
        } else {
            $property = 'minusBy';
        }

        $arrayList = explode(',', $pull);
        $filteredArray = [];
        foreach($arrayList as $list)
        {
            if ($list === $followerEmail) {
                continue;
            }
            $filteredArray[] = $list;
        }
        $this->$property = implode(',' , $filteredArray);  
    }

    /**
     * adds current session user`s email to the list in property $plusBy/$minusBy;  
     *
     * @param string $property ///string indicates which property is for further update;
     * @param User $user ///current session user
     * @return void
     */
    public function addMoreToTable(string $property, User $user): void
    {
        if ($property === 'plus') {
            $property = 'plusBy';
        } else {
            $property = 'minusBy';
        }

        $this->$property .= ',' . $user->getEmail();
    }

    /**
     * adds current session user`s email as the first data to the list in property $plusBy/$minusBy;
     *
     * @param string $property ///string indicates which property is for further update;
     * @param User $user ///current session user
     * @return void
     */
    public function addNewToTable(string $property, User $user): void
    {    
        if ($property === 'plus') {
            $property = 'plusBy';
        } else {
            $property = 'minusBy';
        }

        $this->$property = $user->getEmail();
    }
}