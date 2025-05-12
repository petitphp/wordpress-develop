<?php

/**
 * Test wp_get_inline_style_tag() and wp_print_inline_style_tag().
 *
 * @group dependencies
 * @group scripts
 * @covers ::wp_get_inline_style_tag
 * @covers ::wp_print_inline_style_tag
 */
class Tests_Functions_wpInlineStyleTag extends WP_UnitTestCase {

	private $original_theme_features = array();

	public function set_up() {
		global $_wp_theme_features;
		parent::set_up();
		$this->original_theme_features = $_wp_theme_features;
	}

	public function tear_down() {
		global $_wp_theme_features;
		$_wp_theme_features = $this->original_theme_features;
		parent::tear_down();
	}

	private $inline_style = <<<'CSS'
p {
	color: red;
}
CSS;

	public function test_get_inline_style_tag_type_set() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			'<style type="text/css" data-attr1>' . "\n{$this->inline_style}\n</style>\n",
			wp_get_inline_style_tag(
				$this->inline_style,
				array(
					'type'       => 'text/css',
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);

		remove_theme_support( 'html5' );

		$this->assertSame(
			'<style type="text/css" data-attr1="data-attr1">' . "\n{$this->inline_style}\n</style>\n",
			wp_get_inline_style_tag(
				$this->inline_style,
				array(
					'type'       => 'text/css',
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);
	}

	public function test_get_inline_style_tag_type_not_set() {
		add_theme_support( 'html5', array( 'style' ) );

		$this->assertSame(
			'<style data-attr1>' . "\n{$this->inline_style}\n</style>\n",
			wp_get_inline_style_tag(
				$this->inline_style,
				array(
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);

		remove_theme_support( 'html5' );

		$this->assertSame(
			'<style type="text/css" data-attr1="data-attr1">' . "\n{$this->inline_style}\n</style>\n",
			wp_get_inline_style_tag(
				$this->inline_style,
				array(
					'data-attr2' => false,
					'data-attr1' => true,
				)
			)
		);
	}

	public function test_print_style_tag_prints_get_inline_style_tag() {
		add_filter(
			'wp_inline_style_attributes',
			static function ( $attributes ) {
				if ( isset( $attributes['id'] ) && 'utils-css-extra' === $attributes['id'] ) {
					$attributes['data-attr1'] = true;
				}
				return $attributes;
			}
		);

		add_theme_support( 'html5', array( 'style' ) );

		$attributes = array(
			'id'         => 'utils-css-before',
			'data-attr2' => false,
		);

		$this->assertSame(
			wp_get_inline_style_tag( $this->inline_style, $attributes ),
			get_echo(
				'wp_print_inline_style_tag',
				array(
					$this->inline_style,
					$attributes,
				)
			)
		);

		remove_theme_support( 'html5' );

		$this->assertSame(
			wp_get_inline_style_tag( $this->inline_style, $attributes ),
			get_echo(
				'wp_print_inline_style_tag',
				array(
					$this->inline_style,
					$attributes,
				)
			)
		);
	}
}
