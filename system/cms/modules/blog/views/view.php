        
<?php $created_by_email   = (isset($post[0]['created_by']['email'])) ? $post[0]['created_by']['email'] : false ; ?>

{{ post }}

            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">{{ page:title }}</h3>
              </div>
              <div class="box-body">
                    {{ helper:gravatar email=created_by:email size='400' style='' }}
                    {{ title }}
                    {{ helper:date timestamp=created_on }} {{ helper:lang line="blog:posted_label" }}

                        {{ if category }}
                            <small><a href="{{ url:site }}blog/category/{{ category:slug }}">{{ category:title }}</a></small>
                        {{ endif }}

                        {{ if keywords }}
                            <small>
                                {{ keywords }}
                                    <a href="{{ url:site }}blog/tagged/{{ keyword }}">{{ keyword }}</a>
                                {{ /keywords }}
                            </small>
                        {{ endif }}

                        {{ helper:lang line="blog:written_by_label" }}
                        <a href="{{ url:site }}user/{{ created_by:user_id }}">{{ created_by:display_name }}</a>  

                         {{comment_count}} comments

                         <img src="files/large/{{blog_image:filename}}" alt="{{blog_image:alt}}">

                        {{ body }}

                        <h3>About the author</h3>

                        {{ helper:gravatar email=created_by:email size='100' }}

                        <a href="">{{ user:display_name user_id=post.created_by.id }}</a>

                        {{ user:bio user_id=post.created_by.id }}


                        <div class="col-sm-6 nav-previous">
                            {{blog:prev current='<?php echo $post[0]['id'];?>'}}            
                                <a href="blog/view/{{slug}}">
                                    <small>&larr; PREVIOUS POST</small>
                                    <span>{{title}}</span>
                                </a>
                            {{/blog:prev}}       
                        </div>
                        <div class="col-sm-6 nav-next text-right">
                            {{blog:next current='<?php echo $post[0]['id'];?>'}} 
                                <a href="blog/view/{{slug}}">
                                    <small>NEXT POST &rarr;</small>
                                    <span>{{title}}</span>
                                </a>
                            {{/blog:next}}   
                        </div>


                        {{theme:module name="blog/view_comments" }}



              </div><!-- /.box-body -->
            </div><!-- /.box -->
    {{ /post }}

