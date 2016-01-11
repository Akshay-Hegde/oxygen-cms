<?php if(isset($recent_emails)):?>
<div class="col-md-6">

      <div class="box box-solid">

          <div class="box-header with-border">
             <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Recent Emails</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <a href="{{url:site}}admin/dashboard/toggle/<?php echo $id;?>" class="btn btn-box-tool" ><i class="fa fa-times"></i></a>
            </div>
          </div>


          <div class="box-body">


            <ul class="">

              <?php foreach($recent_emails as $email_header): ?>

              <li style="list-style-type:none" class="" id='email-<?php echo $email_header->uid;?>'>
                <a href='admin/email/read/<?php echo $email_header->uid;?>'>
                  <i class="fa fa-envelope-o"></i>
                  <?php echo $email_header->from;?> <span class="text"><i> <?php echo $email_header->subject;?></i></span>
                </a>
              </li>

              <?php endforeach;?>

            </ul>
          </div>

      </div>
</div>
<?php endif;?>