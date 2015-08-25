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

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetCourseName()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            //Act
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals($course_name, $result);
        }

        function testSetCourseName()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            //Act
            $test_course->setCourseName("Intro to Fine Arts");
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals("Intro to Fine Arts", $result);

        }

        function testGetId()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            //Act
            $result = $test_course->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function testUpdate()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            //Act
            $new_course_name = "Intro to Fine Arts";
            $test_course->update($new_course_name);

            //Assert
            $this->assertEquals("Intro to Fine Arts", $test_course->getCourseName());

        }

        function testDeleteCourse()
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

            //Act
            $test_course->delete();

            //Assert
            $this->assertEquals([$test_course2], Category::getAll());
        }

        function testGetAll()
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

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);

        }

        function testDeleteAll()
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

            //Act
            Course::deleteAll();
            $result = Course::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function testFind()
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

            //Act
            $search_id = $test_course->getId();
            $result = Course::find($search_id);

            //Assert
            $this->assertEquals($test_course, $result);
        }

        function testAddStudent()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }

        function testGetStudents()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

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
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            $result = $test_course->getStudents();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDelete()
        {
            //Arrange
            $course_name = "Intro to Art";
            $course_number = "ART101";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $name = "Ben";
            $enroll_date = "0000-00-00";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->delete();

            //Assert
            $this->assertEquals([], $test_student->getCourses());
        }
    }
?>
