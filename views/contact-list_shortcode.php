<?php


        $args = array(
            'post_type' => 'contact-list', 
            'post_status' => 'publish',
            'post__in' => $id,
            'orderby' => $orderby
        );


        $my_query = new WP_Query($args);

        if($my_query->have_posts()):

            while($my_query->have_posts()): 
                
                $my_query->the_post();

                $name = get_post_meta(get_the_ID(), 'contact_list_name', true);
                $email = get_post_meta(get_the_ID(), 'contact_list_email', true);
                $code = get_post_meta(get_the_ID(), 'contact_list_code_number', true);
                $number = get_post_meta(get_the_ID(), 'contact_list_number', true);
    ?>


<h1>HEllo World</h1>

<table class="table">    
            <thead>
                <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Description</th>
                
                </tr>
            </thead>
        <tbody>
                
                <tr>
                    <td>
                        <?php
                        
                        if(has_post_thumbnail()){

                                the_post_thumbnail('full', array('class' => 'img-fluid')); 

                        }else{

                                echo "Image Default";

                        }
                        
                        
                        ?>     
                    </td>


                    <td><?php echo esc_html($name); ?></td>
                    <td><?php echo esc_html($email); ?></td>
                    <td><?php echo esc_html($code) . esc_html($number) ; ?></td>
                
                    <td><?php the_content(); ?></td>

                </tr>

        </tbody>
        <?php
                endwhile;
                //Função para resetar e não afetar outras consultas
                wp_reset_postdata();

            endif;

        ?>

   
</table>