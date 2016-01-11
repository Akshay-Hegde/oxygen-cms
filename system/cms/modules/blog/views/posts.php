
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">{{ template:title }}</h3>
              </div>
              <div class="box-body">

                {{ if posts }}
                         {{ theme:module name="blog/posts_list" }}
                {{else}}
                        {{ title }}
                        {{ helper:lang line="blog:currently_no_posts" }}
                {{endif}}

                {{ pagination }}

              </div>
            </div>
