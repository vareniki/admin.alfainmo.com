<?php

App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');

/**
 * AppHelper Test Case
 *
 */
class AppHelperTest extends CakeTestCase {

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $View = new View();
    $this->AppHelper = new AppHelper($View);
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->AppHelper);

    parent::tearDown();
  }

  /**
   * testGetActiveClass method
   *
   * @return void
   */
  public function testGetActiveClass() {
    $i=0;
  }

  /**
   * testGetBrowser method
   *
   * @return void
   */
  public function testGetBrowser() {
    
  }

  /**
   * testGetJQueryVersion method
   *
   * @return void
   */
  public function testGetJQueryVersion() {
    
  }

}
