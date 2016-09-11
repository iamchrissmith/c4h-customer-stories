<?php
/**
 * Class CustomPostTypeTest
 *
 * @package 
 */

/**
 * Custom post type test cases.
 */
class CustomPostTypeTest extends WP_UnitTestCase {

	/**
	 * Check if our post type is getting registered.
	 */
	function test_post_type_registered() {

		// Replace this with some actual testing code.
		$this->assertTrue( post_type_exists( 'customer-story' ) );
	}

	/**
	 * Create Post Type and check that we are getting it in our public-get stories function.
	 */
	function test_get_post_type() {

		// Replace this with some actual testing code.
		$this->assertTrue( false );
	}

	/**
	 * Test the Grid select options callback to ensure it shows the right number of columns
	 */
	function test_cmb2_column_count() {
		$field = (object) 'args';
		$field->args = array( 'name' => esc_html__( 'Grid - column', 'c4h-customer-stories' ) );
		$result = C4h_Customer_Stories_Admin::cs_select_populate($field);
		$this->assertEquals( 22, sizeof( $result ) );
	}

	/**
	 * Test the Grid select options callback to ensure it shows the right number of rows
	 */
	function test_cmb2_row_count() {
		$field = (object) 'args';
		$field->args = array( 'name' => esc_html__( 'Grid - row', 'c4h-customer-stories' ) );
		$result = C4h_Customer_Stories_Admin::cs_select_populate($field);
		$this->assertEquals( 18, sizeof( $result ) );
	}

	/**
	 * Test the Grid select options callback to ensure it shows the right number when an invalid option is passed
	 */
	function test_cmb2_select_break() {
		$field = (object) 'args';
		$field->args = array( 'name' => 'should_break' );
		$result = C4h_Customer_Stories_Admin::cs_select_populate($field);
		$this->assertEquals( 0, sizeof( $result ) );
	}
}

