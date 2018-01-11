<?php

namespace TestAutomationCoreBundle\src\GenerateScenarioDB;

use \SQLite3;

class Generater
{
    public static $valuesName;
    public static $generateVariants;
    public static $filePathFile = null;
    public static $data;
    public static $dataComplete;
    public static $name;

    public static $feature;
    public static $tags;
    public static $scenario;
    public static $steps;

    const stringValuesDefaultPositive = ['TestTA', 'T', '1', '-1', 'ТестТА',
/*        'עברי', '中国', ' SELECT * FOM blog WHERE code LIKE f', "“♣☺♂” ,", "“”‘~!@#$%^&*()?>", ",./\<][", "Aa!@#$%^&*()", "-_+=`~/\,.?></b", " ^&*()-_+=`~/\,.?><", "%%%/%%%", '<form action="http://live.hh.ru"><input type="submit"></form>', '<script>alert("Hello, world!")</alert>'*/
    ];
    const integerValuesDefaultPositive = ['1','10',
//        '0',
        '100','65530'];
    const mainPathFeaturesFile = __DIR__ . '/../../Resource/FeaturesForGenerate/';
    const pathSqliteFiles = __DIR__ . '/../../Resource/SQLiteDB/';

    public static function generate()
    {
        print "Start generate " . self::$name . PHP_EOL;
        print "get feature data" . PHP_EOL;
        self::getFeatureData();
        print "generate values" . PHP_EOL;
        self::generateValues();
        print "generate sqlite db files" . PHP_EOL;
        self::generateSQLiteDBFiles();
        print "generate variants in db" . PHP_EOL;
        self::generateVariantsInDB();
    }

    private static function getFeatureData()
    {
        self::$data = file_get_contents(self::$filePathFile);
        preg_match('/(Feature:.*)@|Scenario/Usi', self::$data, $result);
        self::$feature = $result[1];

        preg_match('/(@.*)/', self::$data, $result);
        if (key_exists(0, $result)) {
            self::$tags = $result[0];
        }

        preg_match('/(Scenario:.*)and|when|then/suiU', self::$data, $result);
        self::$scenario = $result[1];

        preg_match('/((And|When|Then).*)/sui', self::$data, $result);
        self::$steps = $result[0];
    }

    private static function generateValues()
    {
        $variants = [];
        foreach (self::$valuesName as $name => $values) {
            $variantDefault = [];
            foreach (self::$valuesName as $nameDefault => $valuesDefault) {
                $variantDefault[$nameDefault] = $valuesDefault[0];
            }
            foreach ($values as $value) {
                $variantGenerate = $variantDefault;
                $variantGenerate[$name] = $value;
                array_push($variants, $variantGenerate);
            }
        }
        self::$generateVariants = $variants;
    }

    private static function generateSQLiteDBFiles()
    {
        self::createFeatureDBFile();
        self::createScenarioDBFile();
        self::addFeatureInDb();
    }

    private static function createFeatureDBFile()
    {
        $db = new SQLite3(self::pathSqliteFiles . "feature");
        $queryCheckTable = "SELECT name FROM sqlite_master WHERE type='table' AND name='feature'";
        $resultIsCreate = $db->query($queryCheckTable)->fetchArray();
        if ($resultIsCreate == false) {
            $db->query("
                          CREATE TABLE `feature` (
                                            `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                                            'nameTable' TEXT,
                                            'feature' TEXT,
                                            'tags' TEXT,
                                            'scenario' TEXT,
                                            'steps' TEXT
                                            );"
            );
        }
        $db->close();
    }

    private static function createScenarioDBFile()
    {

        $db = new SQLite3(self::pathSqliteFiles . "scenario");
        $queryCheckTable = "SELECT name FROM sqlite_master WHERE type='table' AND name='" . self::$name . "'";
        $resultIsCreate = $db->query($queryCheckTable)->fetchArray();

        if ($resultIsCreate == false) {
            $stringParamsSql = "";
            foreach (self::$valuesName as $name => $value) {
                if (is_array($value[0])) {
                    foreach ($value[0] as $a_name=>$a_value){
                    $stringParamsSql .= "'" . $a_name . "' TEXT," . PHP_EOL;
                    }
                } else {
                    $stringParamsSql .= "'" . $name . "' TEXT," . PHP_EOL;
                }

            }
            $stringParamsSql = substr($stringParamsSql, 0, -2);
            $db->query("
                          CREATE TABLE `" . self::$name . "` (
                                            `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                                            'isSmoke' INTEGER,
                                            " . $stringParamsSql . "
                                            );"
            );
        }
        $db->close();
    }

    private static function addFeatureInDb()
    {
        $db = new SQLite3(self::pathSqliteFiles . "feature");
        $queryCheckLine = "SELECT * FROM feature WHERE nameTable='" . self::$name . "'";
        $result = $db->query($queryCheckLine)->fetchArray();
        if ($result == false) {
            $insertQuery = "INSERT INTO feature(nameTable, feature, tags, scenario, steps) VALUES ('" .
                self::$name . "','" . self::$feature . "','" . self::$tags . "','" . self::$scenario . "','" . self::$steps . "');";
            $db->query($insertQuery);
        } else {
            $updateQuery = "UPDATE feature SET " .
                "feature='" . self::$feature . "', 
                 tags='" . self::$tags . "', 
                 scenario='" . self::$scenario . "', 
                 steps='" . self::$steps . "'
                 WHERE nameTable='" . self::$name . "'";
            $db->query($updateQuery);
        }
        $db->close();

    }

    private static function generateVariantsInDB()
    {
        $db = new SQLite3(self::pathSqliteFiles . "scenario");
        foreach (self::$generateVariants as $indexVariant => $variant) {
            $isSmoke = false;
            if ($indexVariant <= 2) {
                $isSmoke = true;
            }
            $sqlValueInsert = (int)$isSmoke . ", ";
            $sqlName = "isSmoke, ";
            foreach ($variant as $name => $value) {
                if (is_array($value)) {
                    foreach ($value as $a_name => $a_value) {
                        $sqlName = $sqlName . $a_name . " ,";
                        $sqlValueInsert = $sqlValueInsert . "'" . $a_value . "',";
                    }

                } else {
                    $sqlName = $sqlName . $name . " ,";
                    $sqlValueInsert = $sqlValueInsert . "'" . $value . "',";
                }
            }
            $sqlValueInsert = substr($sqlValueInsert, 0, -1);
            $sqlName = substr($sqlName, 0, -1);
            $insertQuery = "INSERT INTO " . self::$name . " (" . $sqlName . ") VALUES (" . $sqlValueInsert . ")";
            $db->query($insertQuery);
        }
        $db->close();
    }
}