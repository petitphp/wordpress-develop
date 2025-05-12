<?php

/**
 * Test wp_sanitize_script_attributes().
 *
 * @group dependencies
 * @group scripts
 * @covers ::wp_sanitize_script_attributes
 */
class Tests_Functions_wpSanitizeScriptAttributes extends WP_UnitTestCase {

	public function test_sanitize_script_attributes_type_set() {
		add_theme_support( 'html5', array( 'script' ) );

		$this->assertSame(
			' type="application/javascript" src="https://DOMAIN.TLD/PATH/FILE.js" nomodule',
			wp_sanitize_script_attributes(
				array(
					'type'     => 'application/javascript',
					'src'      => 'https://DOMAIN.TLD/PATH/FILE.js',
					'async'    => false,
					'nomodule' => true,
				)
			)
		);

		remove_theme_support( 'html5' );

		$this->assertSame(
			' src="https://DOMAIN.TLD/PATH/FILE.js" type="application/javascript" nomodule="nomodule"',
			wp_sanitize_script_attributes(
				array(
					'src'      => 'https://DOMAIN.TLD/PATH/FILE.js',
					'type'     => 'application/javascript',
					'async'    => false,
					'nomodule' => true,
				)
			)
		);
	}

	public function test_sanitize_style_attributes_type_set() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			' type="text/css" src="https://DOMAIN.TLD/PATH/FILE.js" data-attr1',
			wp_sanitize_style_attributes(
				array(
					'type'       => 'text/css',
					'src'        => 'https://DOMAIN.TLD/PATH/FILE.js',
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);

		remove_theme_support( 'html5' );

		$this->assertSame(
			' src="https://DOMAIN.TLD/PATH/FILE.js" type="text/css" data-attr1="data-attr1"',
			wp_sanitize_style_attributes(
				array(
					'src'        => 'https://DOMAIN.TLD/PATH/FILE.js',
					'type'       => 'text/css',
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);
	}

	public function test_sanitize_script_attributes_type_not_set() {
		add_theme_support( 'html5', array( 'script' ) );

		$this->assertSame(
			' src="https://DOMAIN.TLD/PATH/FILE.js" nomodule',
			wp_sanitize_script_attributes(
				array(
					'src'      => 'https://DOMAIN.TLD/PATH/FILE.js',
					'async'    => false,
					'nomodule' => true,
				)
			)
		);

		remove_theme_support( 'html5' );

		$this->assertSame(
			' src="https://DOMAIN.TLD/PATH/FILE.js" nomodule="nomodule"',
			wp_sanitize_script_attributes(
				array(
					'src'      => 'https://DOMAIN.TLD/PATH/FILE.js',
					'async'    => false,
					'nomodule' => true,
				)
			)
		);
	}

	public function test_sanitize_style_attributes_type_not_set() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			' src="https://DOMAIN.TLD/PATH/FILE.js" data-attr1',
			wp_sanitize_style_attributes(
				array(
					'src'        => 'https://DOMAIN.TLD/PATH/FILE.js',
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);

		remove_theme_support( 'html5' );

		$this->assertSame(
			' src="https://DOMAIN.TLD/PATH/FILE.js" data-attr1="data-attr1"',
			wp_sanitize_style_attributes(
				array(
					'src'        => 'https://DOMAIN.TLD/PATH/FILE.js',
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);
	}

	public function test_sanitize_script_attributes_no_attributes() {
		add_theme_support( 'html5', array( 'script' ) );

		$this->assertSame(
			'',
			wp_sanitize_script_attributes( array() )
		);

		remove_theme_support( 'html5' );
	}

	public function test_sanitize_style_attributes_no_attributes() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			'',
			wp_sanitize_style_attributes( array() )
		);

		remove_theme_support( 'html5' );
	}

	public function test_sanitize_script_attributes_relative_src() {
		add_theme_support( 'html5', array( 'script' ) );

		$this->assertSame(
			' src="PATH/FILE.js" nomodule',
			wp_sanitize_script_attributes(
				array(
					'src'      => 'PATH/FILE.js',
					'async'    => false,
					'nomodule' => true,
				)
			)
		);

		remove_theme_support( 'html5' );
	}

	public function test_sanitize_style_attributes_relative_src() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			' src="PATH/FILE.js" data-attr1',
			wp_sanitize_style_attributes(
				array(
					'src'        => 'PATH/FILE.js',
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);

		remove_theme_support( 'html5' );
	}


	public function test_sanitize_script_attributes_only_false_boolean_attributes() {
		add_theme_support( 'html5', array( 'script' ) );

		$this->assertSame(
			'',
			wp_sanitize_script_attributes(
				array(
					'async'    => false,
					'nomodule' => false,
				)
			)
		);

		remove_theme_support( 'html5' );
	}

	public function test_sanitize_style_attributes_only_false_boolean_attributes() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			'',
			wp_sanitize_style_attributes(
				array(
					'data-attr2' => false,
					'data-attr1' => false,
				)
			)
		);

		remove_theme_support( 'html5' );
	}

	public function test_sanitize_script_attributes_only_true_boolean_attributes() {
		add_theme_support( 'html5', array( 'script' ) );

		$this->assertSame(
			' async nomodule',
			wp_sanitize_script_attributes(
				array(
					'async'    => true,
					'nomodule' => true,
				)
			)
		);

		remove_theme_support( 'html5' );
	}

	public function test_sanitize_style_attributes_only_true_boolean_attributes() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			' data-attr2 data-attr1',
			wp_sanitize_style_attributes(
				array(
					'data-attr2' => true,
					'data-attr1' => true,
				)
			)
		);

		remove_theme_support( 'html5' );
	}

	public function test_sanitize_tag_attributes_invalid_tag_default_to_script() {
		add_theme_support( 'html5', array( 'script' ) );

		$this->assertSame(
			' data-attr2 data-attr1',
			_wp_sanitize_tag_attributes(
				array(
					'data-attr2' => true,
					'data-attr1' => true,
				),
				'invalid_tag'
			)
		);

		remove_theme_support( 'html5' );
	}
}
