
<div id="chat-box" class="box-body chat" style="overflow: hidden; width: auto; height: 250px;">
    {{ posts }}
        <!-- chat item -->
        <div class="item">
            {{ helper:gravatar email=created_by:email class='offline' }}
            {{ title }}
            <p class="message">
                <a class="name" href="#">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>{{ helper:date timestamp=created_on }}</small>
                    Susan Doe
                </a>
                {{ if category }}
                    <small><a href="{{ url:site }}blog/category/{{ category:slug }}">{{ category:title }}</a>
                {{ endif }}
                {{ if keywords }}
                <small>
                    {{ keywords }}
                        <a href="{{ url:site }}blog/tagged/{{ keyword }}">{{ keyword }}</a>
                    {{ /keywords }}
                </small>
                {{ endif }}   
                
                {{comment_count}} comments  

                 <img src="{{ur:site}}files/large/{{blog_image:filename}}" alt="">             

                {{ preview }}

                <a href="{{ url }}" class="readmore">{{ helper:lang line="blog:read_more_label" }}</a></p>
            </p>
        </div><!-- /.item -->
    {{ /posts }}
</div>                        