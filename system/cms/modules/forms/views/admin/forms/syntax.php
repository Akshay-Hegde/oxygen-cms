
<div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                Syntax
                </h4>
            </div>

            <div class="modal-body">
			
<pre>
{{ forms:display slug="<?php echo $slug;?>" is_required="*" }}

    {{ form_start }}


          {{ form_fields }}

                    {{ form_field_label }} {{is_required}}

                    {{ form_field }}

          {{ /form_fields }}

          &lt;button&gt;Send&lt;/button&gt;

    {{ form_end }}

{{ /forms:display }}
</pre>


		    </div>

        </div>

</div>


