<?php

/**
 * @file
 * contains \Drupal\entity_embed\Tests\EntityEmbedPreviewTest.
 */

namespace Drupal\entity_embed\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests the entity_embed preview controller and route.
 *
 * @see Drupal\entity_embed\EntityEmbedController
 */
class EntityEmbedPreviewTest extends EntityEmbedTestBase {

  public static function getInfo() {
    return array(
      'name' => 'Entity Embed Preview Test',
      'description' => 'Tests the entity_embed controller and route',
      'group' => 'Entity Embed',
    );
  }

  protected function setUp() {
    parent::setUp();

    // Define URL that will be used to access the preview route.
    $this->preview_url = 'entity-embed/preview/custom_format';
  }

  /**
   * Tests preview route with a valid request.
   */
  public function testPreviewController() {
    $content = '<div data-entity-type="node" data-entity-id="' . $this->node->id() . '" data-view-mode="teaser">This placeholder should not be rendered.</div>';

    $html = $this->drupalGet($this->preview_url, array('query' => array('value' => $content)));

    $this->assertResponse(200, 'The preview route exists.');
    $this->assertText($this->embedContent, 'Embedded node exists in page');
    $this->assertNoText(strip_tags($content), 'Placeholder does not appears in the output when embed is successful.');
  }

  /**
   * Tests preview route with an invalid request.
   */
  public function testPreviewControllerInvalidRequest() {
    $content = 'Testing preview route without valid values';
    $html = $this->drupalGet($this->preview_url, array('query' => array('value' => $content)));

    $this->assertResponse(200, 'The preview route exists.');
    $this->assertText($content, 'Placeholder appears in the output when embed is unsuccessful.');
  }

  /**
   * Tests preview route with an empty request.
   */
  public function testPreviewControllerEmptyRequest() {
    $html = $this->drupalGet($this->preview_url);

    $this->assertResponse(404, "The preview returns 'Page not found' when GET parameters are not provided.");
  }

}
