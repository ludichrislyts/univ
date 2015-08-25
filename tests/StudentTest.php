<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Student.php';
    require_once 'src/Course.php';

    $server = 'mysql:host=localhost;dbname=univ_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetName()
        {

        }
        
        function testSetName()
        {

        }

        function testUpdate()
        {

        }

        function testSave()
        {

        }

        function testGetAll()
        {

        }

        function testDeleteAll()
        {

        }

        function testGetId()
        {

        }

        function testDeleteStudent()
        {

        }

        function testFind()
        {

        }

        function testSaveSetsId()
        {

        }

        function testAddCourse()
        {

        }

        function testGetCourse()
        {

        }

        function testDelete()
        {

        }
    }
?>
