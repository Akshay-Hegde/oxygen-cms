<div class="content container">

			<article class="container post format-standart m-center inforow">
            <header class="entry-header clearfix">
                <div class="col-sm-1 no-padding">
             
                    	   <h1>
                                <span>
                                    {{ date.year_short }}
                                </span>
                                {{ date.month_short }}
                            </h1>
              
                    	<h2>Archives</h2>
                </div>
            </header>
        </article>


	{{ if posts }}

		{{ posts }}
			<article class="container post format-standart m-center inforow">
            <header class="entry-header clearfix">
                <div class="col-sm-1 no-padding">
                    <a href="{{url:site}}">
                    	{{ helper:gravatar email=created_by:email size='400' }}
                    </a>
                </div>
                <div class="col-sm-11">
                    <h3><a href="{{ url }}">{{ title }}</a></h3>
                    <div class="meta">
                        <small class="date text-muted">{{ helper:date timestamp=created_on }}</small>
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
                    </div>
                        <div>
                            <a href="{{ url }}#comments">{{comment_count}} comments</a>
                        </div>                    
                </div>
            </header>
            <section class="entry-content">
                <img src="{{ur:site}}files/large/{{blog_image:filename}}" alt="">
                <div class="container">
                    <div class="col-sm-1 no-padding">
                        <div class="icon icon-xs" data-icon="i"></div>
                    </div>
                    <div class="col-sm-10">
                        <p>{{ preview }}</p>
                        <p><a href="{{ url }}" class="readmore">{{ helper:lang line="blog:read_more_label" }}</a></p>
                    </div>
                </div>
            </section>
        </article>

        {{ /posts }}


		{{ pagination }}

	{{ else }}
		
		{{ helper:lang line="blog:currently_no_posts" }}

	{{ endif }}

</div>