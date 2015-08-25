<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=univ_registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //HOME PAGE
    $app->get("/", function() use($app){
        return $app['twig']->render('index.html.twig');
    });

    //ALL STUDENTS PAGE
    $app->get("/students", function() use ($app) {
        $students = Student::getAll();
        return $app["twig"]->render("students.html.twig", array('students' => $students));
    });

    //ALL COURSES PAGE
    $app->get("/courses", function() use ($app) {
        $courses = Course::getAll();
        return $app["twig"]->render("courses.html.twig", array('courses' => $courses));
    });

    //STUDENT VIEW PAGE: STUDENT ADDED
    $app->post("/student_added", function() use ($app) {
        $newbie = new Student($_POST["name"], $_POST["date"]);
        $newbie->save();
        $students = Student::getAll();
        return $app["twig"]->render("students.html.twig", array('students' => $students));
    });

    //COURSE VIEW PAGE: COURSE ADDED
    $app->post("/course_added", function() use ($app) {
        $class = new Course($_POST["name"], $_POST["number"]);
        $class->save();
        $courses = Course::getAll();
        return $app["twig"]->render("courses.html.twig", array('courses' => $courses));
    });

    //INDIVIDUAL STUDENT PAGE - DISPLAY INFO AND CLASSES ENROLLED, OPTION TO ADD CLASS TO SCHEDULE
    $app->get("/student/{id}", function($id) use ($app){
        $student = Student::find($id);
        $courses = $student->getCourses();
        $all_courses = Course::getAll();
        return $app['twig']->render("student_info.html.twig", array('student' => $student, 'courses' => $courses, "all_courses" => $all_courses));
    });

    //INDIVIDUAL STUDENT PAGE - NEW CLASS ADDED
    $app->post("/student/{id}/add_course", function($id) use ($app){
        $student = Student::find($id);
        $new_course = Course::find($_POST["course_id"]);
        $student->addCourse($new_course);
        $courses = $student->getCourses();
        $all_courses = Course::getAll();
        return $app['twig']->render("student_info.html.twig", array('student' => $student, 'courses' => $courses, "all_courses" => $all_courses));
    });

    //INDIVIDUAL COURSE PAGE - DISPLAY COURSE INFO, STUDENT TO ADD LIST, DELETE, UPDATE
    $app->get("/course/{id}", function($id) use ($app){
        $course = Course::find($id);
        $students = $course->getStudents();
        $all_students = Student::getAll();
        return $app['twig']->render("course_info.html.twig", array('students' => $students, 'course' => $course, "all_students" => $all_students));
    });

    //INDIVIDUAL COURSE PAGE - NEW STUDENT ADDED
    $app->post("/course/{id}/add_student", function($id) use ($app){
        $course = Course::find($id);
        $added_student = Student::find($_POST['student_id']);
        $course->addStudent($added_student);
        $students = $course->getStudents();
        $all_students = Student::getAll();
        return $app['twig']->render("course_info.html.twig", array('students' => $students, 'course' => $course, "all_students" => $all_students));
    });

    //CONTENT DELETED PAGE
    $app->delete("/delete_student/{id}", function($id) use($app){
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render('deletion.html.twig');
    });

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


    return $app;
?>
