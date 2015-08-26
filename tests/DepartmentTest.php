<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //All tests passed
    
    require_once 'src/Student.php';
    require_once 'src/Course.php';

    $server = 'mysql:host=localhost;dbname=univ_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
			Department::deleteAll();
        }
		
		function test_save(){
		{
            //Arrange
			$name = "Social Science";
            $course_id = 1;
            $student_id = 2;
            $test_department = new Department($name, $course_id, $student_id);
            $test_department->save();

            //Act
            $result = Department::getAll();

            //Assert
            $this->assertEquals($test_department, $result[0]);
        }	
	}
	
?>
	