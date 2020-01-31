<?php
add_shortcode('ss_cazari',function(){
    $loop = new WP_Query(
        array(
            'post_type' => 'ss_cazare'
            'orderby' => 'name'
        )
        );
        if($loop->have_posts()){
            $output = '<ul class="ss_cazari_lista">';

            while($loop->have_posts()){
                $loop->the_post();
                $meta = get_post_meta(get_the_id(),'');

                $output .= '
                    <li>
                    <a href="' . get_permalink() . '">
                    '. get_the_title() . '
                     
                    </a>
                    </li>
                ';
            }
        }
        else{
            $output = 'Lipsa Cazari';
        }
})
return $output;
?>