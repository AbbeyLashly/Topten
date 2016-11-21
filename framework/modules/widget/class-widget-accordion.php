<?php
/**
 * Widget_accordion class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Accordion extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_accordion', 'description' => esc_html__( 'Collapsible content panels.', 'bignews' ) );
		parent::__construct( 'swbignews_accordion', esc_html_x( 'SW: Accordion', 'Accordion widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$widget_default = array(
			'title' => '',
			'fields' => array(),
		);
		$instance = wp_parse_args( (array) $instance, $widget_default );
		$title = esc_attr( $instance['title'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id ( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'bignews' ) ?>
			<input type="text" name="<?php echo  esc_attr( $this->get_field_name ( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id ( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></label>
		</p>
		<?php
		$fields = isset ( $instance ['fields'] ) ? $instance ['fields'] : array ();
		$field_num = count ( $fields );
		$fields [$field_num] = array( 'subtitle' => '','description' => '' );
		foreach ( $fields as $k => $v ) {
			$v = (array)$v;
		?>
		<div class ="widget-box">
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id ( 'fields' ) ) . '-subtitle'; ?>-<?php echo esc_attr( $k ); ?>"><?php echo esc_html_e( 'Subtitle', 'bignews' ); ?>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id ( 'fields' ) ) . '-subtitle'; ?>-<?php echo esc_attr( $k ); ?>" name="<?php echo esc_attr($this->get_field_name ( 'fields' )); ?>[<?php echo esc_attr( $k ); ?>][subtitle]" value="<?php echo esc_attr( $v['subtitle'] ); ?>" class="widefat"/></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id ( 'fields' ) ). '-description'; ?>-<?php echo esc_attr( $k ); ?>"><?php echo esc_html_e( 'Description', 'bignews' ); ?>
				<textarea rows="3" id="<?php echo esc_attr( $this->get_field_id ( 'fields' ) ). '-description'; ?>-<?php echo esc_attr( $k ); ?>" name="<?php echo esc_attr($this->get_field_name ( 'fields' )); ?>[<?php echo esc_attr( $k ); ?>][description]" class="widefat"><?php echo esc_textarea( $v['description'] ); ?></textarea></label>
			</p>
		</div>
		<?php
		}
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance ['fields'] = array ();
		if (isset ( $new_instance ['fields'] )) {
			foreach ( $new_instance ['fields'] as $k => $v ) {
				if (('' !== trim ( $v['subtitle'] )) || ( '' !== trim ( $v['description'] ))){
					$instance ['fields'][$k]['subtitle'] = $v['subtitle'];
					$instance ['fields'][$k]['description'] = $v['description'];
				}
			}
		}
		return $instance;
	}

	function widget( $args, $instance ) {
		extract ( $args );
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$fields = $instance ['fields'];
		$widget_id =  Swbignews::make_id();
		echo wp_kses_post( $before_widget );
			if(!empty($title)){
					echo wp_kses_post( $before_title );
					echo esc_html( $title );
					echo wp_kses_post( $after_title );
			}?>
			<div class="footer-content">
					<div class="footer-show-more">
						<div id="accordion-<?php echo esc_attr( $widget_id ); ?>" role="tablist" aria-multiselectable="true" class="panel-group">
							<?php foreach( $fields as $k => $v ){
							$v = (array)$v;
							?>
							<div class="widget-show-more panel panel-default border-bottom-1x">
								<div id="headingOne" role="tab" class="panel-heading">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion-<?php echo esc_attr( $widget_id ); ?>"
										href="#collapse-<?php echo esc_attr( $widget_id ).'-'.esc_attr( $k ); ?>" aria-expanded="true" aria-controls="collapseOne">
										<i class="fa fa-plus-circle"></i>
										<span class="title-show"><?php echo esc_html( $v['subtitle'] ); ?></span>
										</a>
									</h4>
								</div>
								<div id="collapse-<?php echo esc_attr( $widget_id ).'-'.esc_attr( $k ); ?>" role="tabpanel" aria-labelledby="headingOne" class="panel-collapse collapse <?php if( $k == 0 ) echo 'in'; ?>">
									<div class="panel-body"><?php echo esc_html( $v['description'] ); ?>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
			</div>
		<?php
		echo wp_kses_post( $after_widget );
	}
}