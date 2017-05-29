<div class="row hot-product wow fadeInUp">
                        <h3 class="title-big"><i class="glyphicon glyphicon-star"></i> Sản phẩm mới nhất</h3>
                        <ul id="producthot">
                        <?php 
                            $args = array(
                                        'showposts' => 8,
                                        'post_type' => 'san-pham',
                                        'orderby' => 'date',
                                        'order' => 'DESC',
                                        'meta_query' => array(array("key" => "sk_hotproduct","compare" => true))  
                                    );
                         $query = new WP_Query( $args );                    
                        if($query->have_posts()):
                        while ( $query->have_posts() ) : $query->the_post();
                            $check   = get_field('sk_checkprice');
                            if($check == false){
                            $price   = get_field('sk_price');
                            if(is_numeric($price)){
                                $price = formatvnd($price);
                            }

                             }else{
                                $price  = get_field('sk_pricekm');
                                $price  = formatvnd($price);
                             }
                         ?>        

                            <li>
                                <div class="product-box">
                                    <a class="pro-img" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail('img-sm'); ?>
                                    </a>
                                    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="price"><?php echo $price; ?></div>
                                    <span class="icon hot"></span>
                                    <div class="coltrol">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Mua hàng</a>
                                    </div>
                                </div>
                            </li>
                        <?php 
                            endwhile;
                            endif;
                            wp_reset_query();
                         ?>

                        </ul>
                    </div>