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

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);

            //Act
            $test_student->setName("Jen");
            $result = $test_student->getName();

            //Assert
            $this->assertEquals("Jen", $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            $new_name = "Jen";

            //Act
            $test_student->update($new_name);

            //Assert
            $this->assertEquals($new_name, $test_student->getName());
        }

        function testSave()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);

            //Act
            $test_student->save();

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            $name2 = "David";
            $enroll_date2 = "0000-00-11";
            $id2 = 2;
            $test_student2 = new Student($name2, $enroll_date2, $id2);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            $name2 = "David";
            $enroll_date2 = "0000-00-11";
            $id2 = 2;
            $test_student2 = new Student($name2, $enroll_date2, $id2);
            $test_student2->save();

            //Act
            Student::deleteAll();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testDeleteStudent()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            $name2 = "David";
            $enroll_date2 = "0000-00-11";
            $id2 = 2;
            $test_student2 = new Student($name2, $enroll_date2, $id2);
            $test_student2->save();

            //Act
            $test_student->delete();

            //Assert
            $this->assertEquals([$test_student2], Student::getAll());

        }

        function testFind()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            $name2 = "David";
            $enroll_date2 = "0000-00-11";
            $id2 = 2;
            $test_student2 = new Student($name2, $enroll_date2, $id2);
            $test_student2->save();

            //Act
            $id = $test_student->getId();
            $result = Student::find($id);

            //Assert
            $this->assertEquals($test_student, $result);

        }

        function testSaveSetsId()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);

            //Act
            $test_student->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_student->getId()));


        }

        function testAddCourse()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            $name2 = "David";
            $enroll_date2 = "0000-00-11";
            $id2 = 2;
            $test_student2 = new Student($name2, $enroll_date2, $id2);
            $test_student2->save();

            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course]);
        }

        function testGetCourses()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $course_name2 = "Intro to Spanish";
            $course_number2 = "SPN101";
            $id2 = 2;
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();

            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);

        }

        function testDelete()
        {
            //Arrange
            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->delete();

            //Assert
            $this->assertEquals([], $test_course->getStudents());
        }
    }
?>
