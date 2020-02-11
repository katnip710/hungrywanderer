<?php
register_block_style(
	'core/quote',
	array(
		'name'         => 'blue-quote',
		'label'        => esc_html__( 'Blue Quote', 'sample-theme' ),
		'inline_style' => '.wp-block-quote.is-style-blue-quote { color: #3B47FA; }',
	)
);
register_block_style(
	'core/quote',
	array(
		'name'         => 'fancy-quote',
		'label'        => esc_html__( 'Fancy Quote', 'sample-theme' ),
		'inline_style' => '.wp-block-quote.is-style-fancy-quote { color: black; }',
	)
);
?>