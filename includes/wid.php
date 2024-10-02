<?php
class top_box_1_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'top_box_1_Widget',
			'Questions',
            array( 'description' => 'Questions article' )
        );
    }
public function widget( $args, $instance )
{
	extract( $args );
	$title = isset( $instance[ 'title' ] )  ? $instance[ 'title' ] : false;
	$id_cat = isset( $instance['id_cat'] )  ? $instance['id_cat'] : false;
	$count_posts = isset( $instance['count_posts'] )  ? $instance['count_posts'] : false;
	$best_sort = isset( $instance['best_sort'] )  ? $instance['best_sort'] : false;
	$best_time = isset( $instance['best_time'] )  ? $instance['best_time'] : false;
		if($best_sort == "meta_value_num"){
			$arg = array('post_type'=> 'post','post_status'=> 'publish','cat'=> $id_cat,'orderby' => $best_sort,'order'=> 'DESC','meta_key'=> 'views','posts_per_page'=> $count_posts,'offset'=>$count_offset);
		} elseif($best_sort == "reit") {
			$arg = array('post_type'=> 'post','post_status'=> 'publish','cat'=> $id_cat,'orderby' => "meta_value_num",'order'=> 'DESC','meta_key'=> 'reit','posts_per_page'=> $count_posts);
		} else {
			$arg = array('post_type'=> 'post','post_status'=> 'publish','cat'=> $id_cat,'orderby' => $best_sort,'order'=> 'DESC','posts_per_page'=> $count_posts);
		}
			
			//конец заголовок
			$query = new WP_Query($arg);
			$i = 0;
		echo $before_widget;
			//начало заголовок
			if(!empty($title)) {
				echo $before_title;
				echo $title;
				echo $after_title;
			}
			
			if ($query->have_posts()){ 
			echo '<div class="list-questions_posts"><ul>';
			while ($query->have_posts()){ $query->the_post();global $post;?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php }
			echo '</ul></div>';
			get_template_part('box-question');
			}
			wp_reset_query();
		//конец виджета
		echo $after_widget;
}
public function update( $new_instance, $old_instance )
{
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['id_cat'] =  esc_sql( $new_instance['id_cat'] );
	$instance['count_posts'] = strip_tags( $new_instance['count_posts'] );
	$instance['best_sort'] = strip_tags( $new_instance['best_sort'] );
    return $instance;
}
public function form( $instance )
{
    $title = isset( $instance[ 'title' ] )  ? $instance[ 'title' ] : '';
	$id_cat = isset( $instance[ 'id_cat' ] )  ? $instance[ 'id_cat' ] : '';
	$count_posts = isset( $instance[ 'count_posts' ] )  ? $instance[ 'count_posts' ] : '';
	$best_sort = isset( $instance[ 'best_sort' ] )  ? $instance[ 'best_sort' ] : '';
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <div class="multiSelect">
    <label for="<?php echo $this->get_field_id( 'id_cat' ); ?>"><b><?php _e( 'Categories:' ); ?></b></label>
	<a href="#" class="changeSelect">Edit</a>
	<div class="hideSelect">
    <?php
		$categories = get_categories('hide_empty=0');
           printf(
                '<select multiple="multiple" name="%s[]" id="%s" class="widefat" size="15">',
                $this->get_field_name('id_cat'),
                $this->get_field_id('id_cat')
            );
            foreach( $categories as $cat )
            {
                printf(
                    '<option value="%s" class="hot-topic" %s>%s</option>',
                    $cat->term_id,
                    in_array($cat->term_id, $id_cat) ? 'selected="selected"' : '',
                    $cat->name
                );
            }
            echo '</select>'; ?>
</div>
    </div>
	<p>
    <label for="<?php echo $this->get_field_id( 'count_posts' ); ?>"><?php _e( 'Count articles:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'count_posts' ); ?>" name="<?php echo $this->get_field_name( 'count_posts' ); ?>" type="text" value="<?php echo esc_attr( $count_posts ); ?>" /> 
	</p>
    <p>
    <label for="<?php echo $this->get_field_id( 'best_sort' ); ?>"><?php _e( 'Sort by:' ); ?></label>
	<select id="<?php echo $this->get_field_id('best_sort'); ?>" name="<?php echo $this->get_field_name('best_sort'); ?>" class="widefat" style="width:100%;">
		<option value="rand" <?php if($best_sort == 'rand') echo ' selected="selected"'; ?>>Rand</option>
		<option value="date" <?php if($best_sort == 'date') echo ' selected="selected"'; ?>>Date</option>
		<option value="comment_count"<?php if($best_sort == 'comment_count') echo ' selected="selected"'; ?>>Comments</option>
		<option value="meta_value_num"<?php if($best_sort == 'meta_value_num') echo ' selected="selected"'; ?>>Views</option>	
     </select> 
    </p>
<?php }
}
// add_action( 'widgets_init', create_function( '', 'register_widget( "top_box_1_Widget" );' ) );
function kama_recent_comments( $args = array() ){
	global $wpdb;

	$def = array(
		'limit'      => 10, // сколько комментов выводить.
		'ex'         => 120, // n символов. Обрезка текста комментария.
		'term'       => '', // id категорий/меток. Включить(5,12,35) или исключить(-5,-12,-35) категории. По дефолту - из всех категорий.
		'gravatar'   => '', // Размер иконки в px. Показывать иконку gravatar. '' - не показывать.
		'user'       => '', // id юзеров. Включить(5,12,35) или исключить(-5,-12,-35) комменты юзеров. По дефолту - все юзеры.
		'echo'       => 0,  // выводить на экран (1) или возвращать (0).
		'comm_type'  => '', // название типа комментария
		'meta_query' => '', // WP_Meta_Query
		'meta_key'   => '', // WP_Meta_Query
		'meta_value' => '', // WP_Meta_Query
		'url_patt'   => '', // оптимизация ссылки на коммент. Пр: '%s?comments#comment-%d' плейсхолдеры будут заменены на $post->guid и $comment->comment_ID
	);

	$args = wp_parse_args( $args, $def );
	extract( $args );

	$AND = '';

	// ЗАПИСИ
	if( $term ){
		$cats = explode(',', $term );
		$cats = array_map('intval', $cats );

		$CAT_IN = ( $cats[ key($cats) ] > 0 ); // из категорий или нет

		$cats = array_map('absint', $cats ); // уберем минусы
		$AND_term_id = 'AND term_id IN ('. implode(',', $cats) .')';

		$posts_sql = "SELECT object_id FROM $wpdb->term_relationships rel LEFT JOIN $wpdb->term_taxonomy tax ON (rel.term_taxonomy_id = tax.term_taxonomy_id) WHERE 1 $AND_term_id ";

		$AND .= ' AND comment_post_ID '. ($CAT_IN ? 'IN' : 'NOT IN') .' ('. $posts_sql .')';
	}

	// ЮЗЕРЫ
	if( $user ){
		$users = explode(',', $user );
		$users = array_map('intval', $users );

		$USER_IN = ( $users[ key($users) ] > 0 );

		$users = array_map('absint', $users );

		$AND .= ' AND user_id '. ($USER_IN ? 'IN' : 'NOT IN') .' ('. implode(',', $users) .')';
	}

	// WP_Meta_Query
	$META_JOIN = '';
	if( $meta_query || $meta_key || $meta_value ){
		$mq = new WP_Meta_Query( $args );
		$mq->parse_query_vars( $args );
		if( $mq->queries ){
			$mq_sql = $mq->get_sql('comment', $wpdb->comments, 'comment_ID' );
			$META_JOIN = $mq_sql['join'];
			$AND .= $mq_sql['where'];
		}
	}

	$sql = $wpdb->prepare("SELECT * FROM $wpdb->comments LEFT JOIN $wpdb->posts ON (ID = comment_post_ID ) $META_JOIN
	WHERE comment_approved = '1' AND comment_type = %s $AND ORDER BY comment_date_gmt DESC LIMIT %d", $comm_type, $limit );

	//die( $sql );  
	$results = $wpdb->get_results( $sql );

	if( ! $results ) return 'Комментариев нет.';

	// HTML
	$out = $grava = '';
	foreach ( $results as $comm ){
		if( $gravatar )
			$grava = get_avatar( $comm->comment_author_email, $gravatar );

		$comtext = strip_tags( $comm->comment_content );
		$com_url = $url_patt ? sprintf( $url_patt, $comm->guid, $comm->comment_ID ) : get_comment_link( $comm->comment_ID );

		$leight = (int) mb_strlen( $comtext );
		if( $leight > $ex )
			$comtext = mb_substr( $comtext, 0, $ex ) .' …';

		$out .= '<div class="item-discuss_posts"><div class="item-discuss_post">
							<div class="stars-post">
								'. kk_star_ratings($comm->comment_post_ID) .'
							</div>
							<div class="wrap-discuss_post">
								<div class="thumb-discuss_post">
									<a href="'. get_permalink($comm->comment_post_ID) .'">'.get_the_post_thumbnail($comm->comment_post_ID, 'thumb_3' ).'</a>
								</div>
								<div class="title-discuss_posts"><a href="'. get_permalink($comm->comment_post_ID) .'">'. esc_attr( $comm->post_title ) .'</a></div>
							</div>
						</div>
						<div class="itemp-discuss_post">
							<div class="desc-discuss_posts">'. $comtext .'</div>
							<div class="comments-item_post">'.get_comments_number($comm->comment_post_ID).' comments</div>
						</div></div>';
	}

	if( $echo )
		return print $out;
	return $out;
}
class top_box_2_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'top_box_2_Widget',
			'Last comments',
            array( 'description' => 'Last comments articles' )
        );
    }
public function widget( $args, $instance )
{
	extract( $args );
	$title = isset( $instance[ 'title' ] )  ? $instance[ 'title' ] : false;
	$count_posts = isset( $instance['count_posts'] )  ? $instance['count_posts'] : false;
			//конец заголовок
			$query = new WP_Query($arg);
			$i = 0;
		echo $before_widget;
			//начало заголовок
			if(!empty($title)) {
				echo $before_title;
				echo $title;
				echo $after_title;
			}
			echo '<div class="list-discuss_posts">';
			echo kama_recent_comments("limit=".$count_posts."&ex=125");
			echo '</div>';
		//конец виджета
		echo $after_widget;
}
public function update( $new_instance, $old_instance )
{
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
	$instance['count_posts'] = strip_tags( $new_instance['count_posts'] );
    return $instance;
}
public function form( $instance )
{
    $title = isset( $instance[ 'title' ] )  ? $instance[ 'title' ] : '';
	$count_posts = isset( $instance[ 'count_posts' ] )  ? $instance[ 'count_posts' ] : '';
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
	<p>
    <label for="<?php echo $this->get_field_id( 'count_posts' ); ?>"><?php _e( 'Count comments:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'count_posts' ); ?>" name="<?php echo $this->get_field_name( 'count_posts' ); ?>" type="text" value="<?php echo esc_attr( $count_posts ); ?>" /> 
	</p>
<?php }
}
// add_action( 'widgets_init', create_function( '', 'register_widget( "top_box_2_Widget" );' ) );
?>