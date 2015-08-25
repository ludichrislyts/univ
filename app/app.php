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






    return $app;
?>
