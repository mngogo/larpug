<?php 

class TestPackage extends PHPUnit_Framework_TestCase
{

  public function testConfig() {
    $test = new TestApp();
    $app = $test->createApplication();
    $this->assertEquals(config('app.env'), 'testing');
  }

  public function testServiceProvider() {
    $test = new TestApp();
    $app = $test->createApplication();
    $this->assertContains('Larpug\ServiceProvider',config('app.providers'));
  }

  public function testView() {

    $result = '<!DOCTYPE html>
<html lang="en">
  <head>
    <title>\'this is a title\'</title>
  </head>
  <body>
    <div class="test">test rendering</div>
  </body>
</html>';

    $test = new TestApp();
    $app = $test->createApplication();

    view()->addLocation(__DIR__ . '/resources/views');
    $view = view('pages.test1')->render();
    $this->assertEquals($view, $result);

  }

  public function testError() {

    $test = new TestApp();
    $app = $test->createApplication();

    view()->addLocation(__DIR__ . '/resources/views');
    $this->expectException(ErrorException::class);
    $view = view('pages.error')->render();

  }

  public function testVars() {

    $result = '
<li>1</li>
<li>2</li>
<li>3</li>
<li>4</li>
<li>5</li>';

    $test = new TestApp();
    $app = $test->createApplication();

    view()->addLocation(__DIR__ . '/resources/views');
    $view = view('pages.vars', ['array' => [1,2,3,4,5]])->render();
    $this->assertEquals($view, $result);

  }



}


class TestApp extends Orchestra\Testbench\TestCase
{
  protected function getPackageProviders($app)
  {
    return ['Larpug\ServiceProvider'];
  }

}
