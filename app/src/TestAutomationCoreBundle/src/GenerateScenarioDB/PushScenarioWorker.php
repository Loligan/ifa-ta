<?php

namespace TestAutomationCoreBundle\src\GenerateScenarioDB;


use SQLite3;

class PushScenarioWorker
{
    public static function getAllFeatures(){
        $features = [];
        $db = new SQLite3(Generater::pathSqliteFiles . "feature");
        $data = $db->query('SELECT * FROM feature');
        while ($feature = $data->fetchArray()){
            array_push($features,$feature);
        }
        $db->close();
        return $features;

    }

    public static function getAllScenarioFeatures($idFeature){
        $scenarios = [];
        $dbFeature = new SQLite3(Generater::pathSqliteFiles . "feature");
        $resultQueryGetId = $dbFeature->query('SELECT nameTable FROM feature WHERE id='.$idFeature)->fetchArray();
        $nameTableScenario = $resultQueryGetId['nameTable'];
        $dbFeature->close();
        $dbScenario = new SQLite3(Generater::pathSqliteFiles . "scenario");
        $data = $dbScenario->query('SELECT * FROM '.$nameTableScenario);
        while ($scenario = $data->fetchArray()){
            array_push($scenarios,$scenario);
        }
        $dbScenario->close();
        return $scenarios;
    }
}