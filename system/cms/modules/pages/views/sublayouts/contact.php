
{{ layout:partial name="title" }}
    <h1>
        <small></small>
    </h1>
{{ /layout:partial }}
        
        
<div class="box box-solid">

    <div class="box-header with-border">
        <h3 class="box-title">{{ page:title }}</h3>
    </div>

    <div class="box-body">

        <div>
            {{body}}
        </div>

        <div class="box-body">

                    {{ forms:display slug="contact-form" is_required="*" }}

                        {{ form_start }}
                            <table class='table'>

                              {{ form_fields }}
                              <tr>
                                    <td>
                                        {{ form_field_label }} {{is_required}}
                                    </td>
                                    <td>
                                        {{ form_field }}
                                    </td>
                              </tr>
                              {{ /form_fields }}
                              <tr>
                                    <td>
                                    
                                    </td>
                                    <td>
                                        <button>{{helper:lang line="public:label:send"}}</button>
                                    </td>
                                </tr>
                            </table>
                        {{ form_end }}

                    {{ /forms:display }}

        </div>


      {{ widgets:display area="top-page" }}

      <?php if (Settings::get('enable_comments') and $page->comments_enabled): ?>
          <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo lang('comments:title') ?></h3>
                </div>
                <div class="box-body">
                     <?php echo $this->comments->display() ?>
                     <?php echo $this->comments->form() ?>
                </div>
          </div>
      <?php endif ?>

    </div>

</div>    



