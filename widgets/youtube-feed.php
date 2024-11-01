<?php

if (! defined( 'ABSPATH' ) ) exit;

class Ultimate_Youtube_Feed_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ultimate-youtube-feed';
	}

	public function get_title() {
		return esc_html__( 'Youtube Feed', 'ultimate-youtube-feed' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'youtube', 'youtube feed' ];
	}

	protected function register_controls() {
		// Content Tab Start

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'ultimate-youtube-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Description', 'ultimate-youtube-feed' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Default description', 'ultimate-youtube-feed' ),
				'placeholder' => esc_html__( 'Type your description here', 'ultimate-youtube-feed' ),
			]
		);

		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'ultimate-youtube-feed' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'ultimate-youtube-feed' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .youtube-feed-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab End
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<p class="youtube-feed-title"><?php echo esc_html($settings['title']); ?></p>
		<?php
	}
}